<?php

declare(strict_types=1);

if (! defined('ABSPATH') || ! defined('WP_CLI') || ! WP_CLI) {
    return;
}

final class BSH_Site_Editor_Migration_Command
{
    private const VERSION = '6';
    private const VERSION_META = '_bsh_editor_first_version';
    private const BACKUP_META = '_bsh_editor_first_backup_v1';
    private const BACKUP_HASH_META = '_bsh_editor_first_backup_hash_v1';
    private const MEDIA_BACKUP_META = '_bsh_editor_first_backup_v4';
    private const MEDIA_BACKUP_HASH_META = '_bsh_editor_first_backup_hash_v4';
    private const MEDIA_SOURCE_META = '_bsh_editor_first_theme_asset';
    private const EDITOR_PREFERENCES_BACKUP_META = '_bsh_editor_first_preferences_backup_v1';
    private const EDITOR_PREFERENCES_VERSION_META = '_bsh_editor_first_preferences_version';

    /** @var array<string, string> */
    private const LEGACY_HASHES = [
        'startseite' => 'e4f0e2e2f760e7883960e3d3678f1161a84af77be344419fb5a2a3ae2a03a7a6',
        'hundetraining-hamburg' => 'b1241a028dad1e2481db1ffbd065fecc0b7b2b6865768cfa59e57256036e31b6',
        'erstgespraech' => '8890f5805fb05ff5080981f32622e6c16fde050552c1428e3ba5fe146bf75c13',
        'einzeltraining' => 'b1b7e8a82f0a0c9a009cb0b8f0bf5330c8d9c02a10b793d64ee8f8b02f1aa460',
        'dogspace-hamburg' => 'da1e2b08b68353bf636d7f5a79458dac920bd2167dd612867d0ee99629db5b87',
        'workshops-seminare' => 'b35b175e9c47b8610269ed99fc0d6861d453ad5ef774c40ba1afb73d09360bf0',
        'coaching-mit-hund' => '8af0b38937f8d153bffeeda3c9d2d76366770fcf31362cb88c157e4f2a40d824',
        'ueber-jacky-rebien' => 'ba773a561a90dc33f2ea811cb3ec0b3d30c54c841f01006b5b0f68d1b5c4a37e',
        'preise' => 'a702684f85d40552ef7cf4bd2c3927f17a02dfe4bff616682b07d904488acc93',
        'kontakt' => '301d267529b4761775dbef80b235ed7b3885e132dc219a6cf4dffca7c727fb07',
        'faq' => 'a9e2d73ab44c5e8f9e8b1fe4c39621e4e9a9a0d51a29a43319c3d9c386fd28cc',
        'ratgeber' => 'fe291c27099f90770baac86bde09e0813b938e8ad6d0814fe96a977353195586',
        'impressum' => 'ff655aa0bcda7254f804fdf2ea59cddaca38c28222c840f02047fb8909a5442d',
        'datenschutz' => '6f22f01bf4e18a1b19114b9512e94a301be7140a1599420934c8a38bb47d59d3',
    ];

    private const HEADER_LEGACY_HASH = 'a627784ae9871e0b263ba869a3a00a98cfc712ee2b2012e1f3351c49f4644d6b';
    private const GLOBAL_STYLES_LEGACY_HASH = '30d7f043b76a1391d4e39ae083b50bdfab221f009465c1933b006ae5edca7caa';

    /**
     * Reports page block sources and database Site Editor overrides.
     *
     * ## EXAMPLES
     *
     *     wp site-editor-migration audit
     */
    public function audit(): void
    {
        foreach (self::LEGACY_HASHES as $slug => $legacy_hash) {
            $page = get_page_by_path($slug, OBJECT, 'page');
            if (! $page instanceof WP_Post) {
                WP_CLI::warning(sprintf('%s: Seite fehlt.', $slug));
                continue;
            }

            $counts = $this->block_counts($page->post_content);
            $state = $this->page_state($page, $legacy_hash);
            WP_CLI::log(sprintf(
                '%s ID=%d state=%s html=%d pattern=%d shortcode=%d blocks=%d images_without_id=%d hash=%s',
                $slug,
                $page->ID,
                $state,
                $counts['core/html'] ?? 0,
                $counts['core/pattern'] ?? 0,
                $counts['core/shortcode'] ?? 0,
                array_sum($counts),
                $this->count_image_blocks_without_attachment($page->post_content),
                hash('sha256', $page->post_content)
            ));
        }

        foreach (['wp_template', 'wp_template_part', 'wp_block', 'wp_global_styles', 'wp_navigation'] as $post_type) {
            $ids = get_posts([
                'post_type' => $post_type,
                'post_status' => 'any',
                'numberposts' => -1,
                'fields' => 'ids',
            ]);
            WP_CLI::log(sprintf('%s: %d Datenbankeinträge', $post_type, count($ids)));
        }
    }

    /**
     * Migrates audited page content and the header template-part override.
     *
     * ## OPTIONS
     *
     * [--dry-run]
     * : Calculates and validates changes without writing to the database.
     *
     * [--force]
     * : Allows a page whose legacy hash differs. A backup is still mandatory.
     *
     * ## EXAMPLES
     *
     *     wp site-editor-migration migrate --dry-run
     *     wp site-editor-migration migrate
     */
    public function migrate(array $args, array $assoc_args): void
    {
        $dry_run = (bool) ($assoc_args['dry-run'] ?? false);
        $force = (bool) ($assoc_args['force'] ?? false);
        $definitions = $this->target_definitions();

        foreach (self::LEGACY_HASHES as $slug => $legacy_hash) {
            $page = get_page_by_path($slug, OBJECT, 'page');
            if (! $page instanceof WP_Post) {
                WP_CLI::error(sprintf('%s: Seite fehlt; Migration abgebrochen.', $slug));
            }

            if ((string) get_post_meta($page->ID, self::VERSION_META, true) === self::VERSION) {
                WP_CLI::log(sprintf('%s: bereits migriert.', $slug));
                continue;
            }

            $current_hash = hash('sha256', $page->post_content);
            $previous_version = (string) get_post_meta($page->ID, self::VERSION_META, true);
            if (! hash_equals($legacy_hash, $current_hash) && $previous_version === '' && ! $force) {
                WP_CLI::error(sprintf(
                    '%s: Inhalt weicht vom auditierten Legacy-Hash ab (%s). Ohne --force keine Änderung.',
                    $slug,
                    $current_hash
                ));
            }

            if (! isset($definitions[$slug])) {
                WP_CLI::error(sprintf('%s: Zieldefinition fehlt.', $slug));
            }

            // Upgrades transform the current editor-owned content in place. Only
            // untouched legacy pages are rebuilt from the audited definitions.
            $target = $previous_version === '' ? $definitions[$slug] : $page->post_content;
            $theme_image_count = $this->count_theme_image_blocks($target);
            $target_counts = $this->block_counts($target);
            if (($target_counts['core/html'] ?? 0) > 0 || ($target_counts['core/pattern'] ?? 0) > 0) {
                WP_CLI::error(sprintf('%s: Ziel enthält weiterhin HTML- oder Pattern-Platzhalter.', $slug));
            }

            WP_CLI::log(sprintf(
                '%s: %s, %d -> %d Bytes, %d native Blöcke, %d Theme-Bilder, %d ungültige Absatzattribute, %d verbundene Patterns.',
                $slug,
                $dry_run ? 'würde migriert' : 'migriere',
                strlen($page->post_content),
                strlen($target),
                array_sum($target_counts),
                $theme_image_count,
                substr_count($target, ' aria-hidden="true"'),
                $this->count_connected_patterns($target)
            ));

            if ($dry_run) {
                continue;
            }

            $this->backup_post_content($page);
            if ($previous_version !== '') {
                $this->backup_media_source_content($page);
            }
            $target = $this->detach_pattern_instances($target);
            $target = $this->remove_unsupported_paragraph_attributes($target);
            $target = $this->migrate_theme_images($target);
            $updated = wp_update_post([
                'ID' => $page->ID,
                'post_content' => $target,
            ], true);
            if ($updated instanceof WP_Error) {
                WP_CLI::error(sprintf('%s: %s', $slug, $updated->get_error_message()));
            }
            update_post_meta($page->ID, self::VERSION_META, self::VERSION);
        }

        $this->migrate_header_override($dry_run, $force);
        $this->migrate_global_styles($dry_run, $force);
        $this->migrate_editor_preferences($dry_run);

        if (! $dry_run) {
            $logo_id = $this->ensure_site_logo();
            WP_CLI::log(sprintf('Website-Logo: Attachment ID %d.', $logo_id));
        }

        WP_CLI::success($dry_run ? 'Dry-Run ohne Datenbankänderung abgeschlossen.' : 'Editor-first-Migration abgeschlossen.');
    }

    /**
     * Verifies native blocks, migration markers, locks and the Site Editor header.
     *
     * ## EXAMPLES
     *
     *     wp site-editor-migration verify
     */
    public function verify(): void
    {
        $failures = [];

        foreach (array_keys(self::LEGACY_HASHES) as $slug) {
            $page = get_page_by_path($slug, OBJECT, 'page');
            if (! $page instanceof WP_Post) {
                $failures[] = sprintf('%s fehlt', $slug);
                continue;
            }

            $counts = $this->block_counts($page->post_content);
            if (($counts['core/html'] ?? 0) > 0) {
                $failures[] = sprintf('%s enthält core/html', $slug);
            }
            if (($counts['core/pattern'] ?? 0) > 0) {
                $failures[] = sprintf('%s enthält core/pattern', $slug);
            }
            if ($this->count_locked_blocks(parse_blocks($page->post_content)) > 0) {
                $failures[] = sprintf('%s enthält Block-Sperren', $slug);
            }
            $images_without_id = $this->count_image_blocks_without_attachment($page->post_content);
            if ($images_without_id > 0) {
                $failures[] = sprintf('%s enthält %d Bildblöcke ohne Medien-ID', $slug, $images_without_id);
            }
            if (str_contains($page->post_content, '<p class="welcome-editorial__bond-')
                && str_contains($page->post_content, ' aria-hidden="true"')) {
                $failures[] = sprintf('%s enthält nicht unterstützte Absatzattribute', $slug);
            }
            $connected_patterns = $this->count_connected_patterns($page->post_content);
            if ($connected_patterns > 0) {
                $failures[] = sprintf('%s enthält %d verbundene Pattern-Instanzen', $slug, $connected_patterns);
            }
            if ((string) get_post_meta($page->ID, self::VERSION_META, true) !== self::VERSION) {
                $failures[] = sprintf('%s hat keinen Migrationsmarker', $slug);
            }
            $backup = (string) get_post_meta($page->ID, self::BACKUP_META, true);
            if ($backup === '') {
                $failures[] = sprintf('%s hat kein Inhaltsbackup', $slug);
            } elseif (! hash_equals(
                hash('sha256', $backup),
                (string) get_post_meta($page->ID, self::BACKUP_HASH_META, true)
            )) {
                $failures[] = sprintf('%s hat eine ungueltige Backup-Pruefsumme', $slug);
            }

            WP_CLI::log(sprintf('%s: OK (%d Blöcke)', $slug, array_sum($counts)));
        }

        $header = $this->get_header_override();
        if (! $header instanceof WP_Post || ! has_block('core/site-logo', $header) || ! has_block('core/navigation', $header)) {
            $failures[] = 'Header-Override enthält nicht Site Logo und Navigation';
        } elseif (! $this->has_valid_backup($header)) {
            $failures[] = 'Header-Override hat kein gueltiges Inhaltsbackup';
        }

        $global_styles = $this->get_global_styles_override();
        if ($global_styles instanceof WP_Post
            && (string) get_post_meta($global_styles->ID, self::VERSION_META, true) !== self::VERSION) {
            $failures[] = 'Global-Styles-Override ist nicht normalisiert';
        } elseif ($global_styles instanceof WP_Post && ! $this->has_valid_backup($global_styles)) {
            $failures[] = 'Global-Styles-Override hat kein gueltiges Inhaltsbackup';
        }

        if ($failures !== []) {
            WP_CLI::error("Verifikation fehlgeschlagen:\n- " . implode("\n- ", $failures));
        }

        WP_CLI::success('Alle migrierten Seiten und der Header sind editor-first verifiziert.');
    }

    /** @return array<string, string> */
    private function target_definitions(): array
    {
        if (! defined('BSH_SEED_LIBRARY_ONLY')) {
            define('BSH_SEED_LIBRARY_ONLY', true);
        }

        require_once get_theme_file_path('seed-content.php');
        if (! function_exists('bsh_seed_page_definitions')) {
            WP_CLI::error('Seed-Definitionen konnten nicht geladen werden.');
        }

        $targets = [];
        foreach (bsh_seed_page_definitions() as $definition) {
            $slug = (string) ($definition['slug'] ?? '');
            if (! isset(self::LEGACY_HASHES[$slug])) {
                continue;
            }
            $targets[$slug] = $this->resolve_patterns((string) $definition['content']);
        }

        return $targets;
    }

    private function resolve_patterns(string $content): string
    {
        $blocks = parse_blocks($content);
        if (function_exists('resolve_pattern_blocks')) {
            $blocks = resolve_pattern_blocks($blocks);
        }
        return serialize_blocks($this->detach_pattern_blocks($blocks));
    }

    private function count_connected_patterns(string $content): int
    {
        $count = 0;
        $walk = static function (array $blocks) use (&$walk, &$count): void {
            foreach ($blocks as $block) {
                if (! empty($block['attrs']['metadata']['patternName'])) {
                    $count++;
                }
                if (! empty($block['innerBlocks'])) {
                    $walk($block['innerBlocks']);
                }
            }
        };
        $walk(parse_blocks($content));
        return $count;
    }

    private function detach_pattern_instances(string $content): string
    {
        return serialize_blocks($this->detach_pattern_blocks(parse_blocks($content)));
    }

    private function detach_pattern_blocks(array $blocks): array
    {
        foreach ($blocks as &$block) {
            if (! empty($block['attrs']['metadata']['patternName'])) {
                unset(
                    $block['attrs']['metadata']['patternName'],
                    $block['attrs']['metadata']['name'],
                    $block['attrs']['metadata']['categories']
                );
                if ($block['attrs']['metadata'] === []) {
                    unset($block['attrs']['metadata']);
                }
            }
            if (! empty($block['innerBlocks'])) {
                $block['innerBlocks'] = $this->detach_pattern_blocks($block['innerBlocks']);
            }
        }
        unset($block);

        return $blocks;
    }

    private function count_theme_image_blocks(string $content): int
    {
        $count = 0;
        $walk = function (array $blocks) use (&$walk, &$count): void {
            foreach ($blocks as $block) {
                if (($block['blockName'] ?? '') === 'core/image') {
                    $source = $this->image_source($block);
                    if ($source !== '' && $this->theme_asset_relative_path($source) !== null) {
                        $count++;
                    }
                }
                if (! empty($block['innerBlocks'])) {
                    $walk($block['innerBlocks']);
                }
            }
        };
        $walk(parse_blocks($content));
        return $count;
    }

    private function count_image_blocks_without_attachment(string $content): int
    {
        $count = 0;
        $walk = static function (array $blocks) use (&$walk, &$count): void {
            foreach ($blocks as $block) {
                if (($block['blockName'] ?? '') === 'core/image' && empty($block['attrs']['id'])) {
                    $count++;
                }
                if (! empty($block['innerBlocks'])) {
                    $walk($block['innerBlocks']);
                }
            }
        };
        $walk(parse_blocks($content));
        return $count;
    }

    private function migrate_theme_images(string $content): string
    {
        return serialize_blocks($this->migrate_image_blocks(parse_blocks($content)));
    }

    private function migrate_image_blocks(array $blocks): array
    {
        foreach ($blocks as &$block) {
            if (($block['blockName'] ?? '') === 'core/image') {
                $source = $this->image_source($block);
                $relative_path = $this->theme_asset_relative_path($source);
                $attachment_id = 0;

                if ($relative_path !== null) {
                    $attachment_id = $this->ensure_content_attachment(
                        $relative_path,
                        $this->image_alt($block)
                    );
                } elseif (! empty($block['attrs']['id'])) {
                    $attachment_id = (int) $block['attrs']['id'];
                }

                if ($attachment_id > 0) {
                    $attachment_url = wp_get_attachment_url($attachment_id);
                    if (! is_string($attachment_url) || $attachment_url === '') {
                        WP_CLI::error(sprintf('Attachment %d hat keine URL.', $attachment_id));
                    }

                    $block['attrs']['id'] = $attachment_id;
                    $block['innerHTML'] = $this->update_image_markup(
                        (string) ($block['innerHTML'] ?? ''),
                        $attachment_id,
                        $attachment_url
                    );
                    foreach ($block['innerContent'] ?? [] as $index => $fragment) {
                        if (is_string($fragment) && str_contains($fragment, '<img')) {
                            $block['innerContent'][$index] = $this->update_image_markup(
                                $fragment,
                                $attachment_id,
                                $attachment_url
                            );
                        }
                    }
                }
            }

            if (! empty($block['innerBlocks'])) {
                $block['innerBlocks'] = $this->migrate_image_blocks($block['innerBlocks']);
            }
        }
        unset($block);

        return $blocks;
    }

    private function remove_unsupported_paragraph_attributes(string $content): string
    {
        return serialize_blocks($this->sanitize_paragraph_blocks(parse_blocks($content)));
    }

    private function sanitize_paragraph_blocks(array $blocks): array
    {
        foreach ($blocks as &$block) {
            if (($block['blockName'] ?? '') === 'core/paragraph') {
                $block['innerHTML'] = $this->sanitize_paragraph_markup((string) ($block['innerHTML'] ?? ''));
                foreach ($block['innerContent'] ?? [] as $index => $fragment) {
                    if (is_string($fragment) && str_contains($fragment, '<p')) {
                        $block['innerContent'][$index] = $this->sanitize_paragraph_markup($fragment);
                    }
                }
            }
            if (! empty($block['innerBlocks'])) {
                $block['innerBlocks'] = $this->sanitize_paragraph_blocks($block['innerBlocks']);
            }
        }
        unset($block);

        return $blocks;
    }

    private function sanitize_paragraph_markup(string $html): string
    {
        $html = preg_replace(
            '/<p>\s*<p([^>]*)>(.*?)<\/p>\s*<\/p>/si',
            '<p$1>$2</p>',
            $html
        ) ?? $html;
        $processor = new WP_HTML_Tag_Processor($html);
        while ($processor->next_tag('p')) {
            $processor->remove_attribute('aria-hidden');
        }
        return $processor->get_updated_html();
    }

    private function image_source(array $block): string
    {
        $processor = new WP_HTML_Tag_Processor((string) ($block['innerHTML'] ?? ''));
        if (! $processor->next_tag('img')) {
            return '';
        }

        return html_entity_decode((string) $processor->get_attribute('src'), ENT_QUOTES | ENT_HTML5);
    }

    private function image_alt(array $block): string
    {
        $processor = new WP_HTML_Tag_Processor((string) ($block['innerHTML'] ?? ''));
        if (! $processor->next_tag('img')) {
            return '';
        }

        return (string) $processor->get_attribute('alt');
    }

    private function theme_asset_relative_path(string $source): ?string
    {
        if ($source === '') {
            return null;
        }

        $source_path = (string) wp_parse_url($source, PHP_URL_PATH);
        $theme_url_path = untrailingslashit((string) wp_parse_url(get_template_directory_uri(), PHP_URL_PATH));
        if ($source_path === '' || $theme_url_path === '' || ! str_starts_with($source_path, $theme_url_path . '/')) {
            return null;
        }

        $relative_path = rawurldecode(ltrim(substr($source_path, strlen($theme_url_path)), '/'));
        if ($relative_path === '' || str_contains($relative_path, '..')) {
            WP_CLI::error(sprintf('Unsicherer Theme-Asset-Pfad: %s', $relative_path));
        }

        $theme_root = realpath(get_template_directory());
        $asset_path = realpath(get_theme_file_path($relative_path));
        if (! is_string($theme_root)
            || ! is_string($asset_path)
            || ! str_starts_with($asset_path, trailingslashit($theme_root))
            || ! is_readable($asset_path)) {
            WP_CLI::error(sprintf('Theme-Bild ist nicht lesbar: %s', $relative_path));
        }

        return $relative_path;
    }

    private function ensure_content_attachment(string $relative_path, string $alt): int
    {
        $existing = get_posts([
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'meta_key' => self::MEDIA_SOURCE_META,
            'meta_value' => $relative_path,
            'numberposts' => 1,
            'fields' => 'ids',
        ]);
        if ($existing !== []) {
            return (int) $existing[0];
        }

        if ($relative_path === 'assets/optimized/logo-full-640.webp') {
            $site_logos = get_posts([
                'post_type' => 'attachment',
                'post_status' => 'inherit',
                'meta_key' => '_bsh_editor_first_asset',
                'meta_value' => 'site-logo-v1',
                'numberposts' => 1,
                'fields' => 'ids',
            ]);
            if ($site_logos !== []) {
                update_post_meta((int) $site_logos[0], self::MEDIA_SOURCE_META, $relative_path);
                return (int) $site_logos[0];
            }
        }

        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $source = get_theme_file_path($relative_path);
        $temporary = wp_tempnam(basename($relative_path));
        if (! $temporary || ! copy($source, $temporary)) {
            WP_CLI::error(sprintf('Temporäre Kopie für %s konnte nicht erstellt werden.', $relative_path));
        }

        $attachment_id = media_handle_sideload([
            'name' => basename($relative_path),
            'tmp_name' => $temporary,
        ], 0);
        if ($attachment_id instanceof WP_Error) {
            @unlink($temporary);
            WP_CLI::error($attachment_id->get_error_message());
        }

        update_post_meta((int) $attachment_id, self::MEDIA_SOURCE_META, $relative_path);
        if ($alt !== '') {
            update_post_meta((int) $attachment_id, '_wp_attachment_image_alt', $alt);
        }
        WP_CLI::log(sprintf('Medienimport: %s -> Attachment ID %d.', $relative_path, $attachment_id));

        return (int) $attachment_id;
    }

    private function update_image_markup(string $html, int $attachment_id, string $attachment_url): string
    {
        $processor = new WP_HTML_Tag_Processor($html);
        if (! $processor->next_tag('img')) {
            WP_CLI::error(sprintf('Image-Block für Attachment %d enthält kein img-Element.', $attachment_id));
        }

        $classes = preg_split('/\s+/', trim((string) $processor->get_attribute('class'))) ?: [];
        $classes = array_values(array_filter(
            $classes,
            static fn (string $class): bool => $class !== '' && ! preg_match('/^wp-image-\d+$/', $class)
        ));
        $classes[] = 'wp-image-' . $attachment_id;

        $processor->set_attribute('src', $attachment_url);
        $processor->set_attribute('class', implode(' ', array_unique($classes)));
        return $processor->get_updated_html();
    }

    /** @return array<string, int> */
    private function block_counts(string $content): array
    {
        $counts = [];
        $walk = static function (array $blocks) use (&$walk, &$counts): void {
            foreach ($blocks as $block) {
                $name = $block['blockName'] ?: 'freeform';
                $counts[$name] = ($counts[$name] ?? 0) + 1;
                if (! empty($block['innerBlocks'])) {
                    $walk($block['innerBlocks']);
                }
            }
        };
        $walk(parse_blocks($content));
        ksort($counts);
        return $counts;
    }

    private function count_locked_blocks(array $blocks): int
    {
        $count = 0;
        foreach ($blocks as $block) {
            $attrs = $block['attrs'] ?? [];
            if (isset($attrs['lock']) || isset($attrs['templateLock'])) {
                $count++;
            }
            if (! empty($block['innerBlocks'])) {
                $count += $this->count_locked_blocks($block['innerBlocks']);
            }
        }
        return $count;
    }

    private function page_state(WP_Post $page, string $legacy_hash): string
    {
        if ((string) get_post_meta($page->ID, self::VERSION_META, true) === self::VERSION) {
            return 'migrated';
        }
        return hash_equals($legacy_hash, hash('sha256', $page->post_content)) ? 'eligible' : 'changed';
    }

    private function backup_post_content(WP_Post $post): void
    {
        if (! metadata_exists('post', $post->ID, self::BACKUP_META)) {
            if (! add_post_meta($post->ID, self::BACKUP_META, $post->post_content, true)) {
                WP_CLI::error(sprintf('Backup für Post %d konnte nicht erstellt werden.', $post->ID));
            }
        }

        $backup = (string) get_post_meta($post->ID, self::BACKUP_META, true);
        update_post_meta($post->ID, self::BACKUP_HASH_META, hash('sha256', $backup));
    }

    private function backup_media_source_content(WP_Post $post): void
    {
        if (! metadata_exists('post', $post->ID, self::MEDIA_BACKUP_META)) {
            if (! add_post_meta($post->ID, self::MEDIA_BACKUP_META, $post->post_content, true)) {
                WP_CLI::error(sprintf('Medien-Backup für Post %d konnte nicht erstellt werden.', $post->ID));
            }
        }

        $backup = (string) get_post_meta($post->ID, self::MEDIA_BACKUP_META, true);
        update_post_meta($post->ID, self::MEDIA_BACKUP_HASH_META, hash('sha256', $backup));
    }

    private function has_valid_backup(WP_Post $post): bool
    {
        if (! metadata_exists('post', $post->ID, self::BACKUP_META)) {
            return false;
        }

        return hash_equals(
            hash('sha256', (string) get_post_meta($post->ID, self::BACKUP_META, true)),
            (string) get_post_meta($post->ID, self::BACKUP_HASH_META, true)
        );
    }

    private function migrate_header_override(bool $dry_run, bool $force): void
    {
        $header = $this->get_header_override();
        if (! $header instanceof WP_Post) {
            WP_CLI::warning('Kein Header-Override vorhanden; Theme-Datei bleibt maßgeblich.');
            return;
        }
        if ((string) get_post_meta($header->ID, self::VERSION_META, true) === self::VERSION) {
            WP_CLI::log('Header-Override: bereits migriert.');
            return;
        }

        $current_hash = hash('sha256', $header->post_content);
        $previous_version = (string) get_post_meta($header->ID, self::VERSION_META, true);
        if (! hash_equals(self::HEADER_LEGACY_HASH, $current_hash) && $previous_version === '' && ! $force) {
            WP_CLI::error(sprintf('Header-Override weicht vom Audit-Hash ab (%s).', $current_hash));
        }

        $navigation = get_posts([
            'post_type' => 'wp_navigation',
            'post_status' => 'publish',
            'numberposts' => 1,
            'orderby' => 'ID',
            'order' => 'ASC',
        ]);
        $navigation_id = isset($navigation[0]) && $navigation[0] instanceof WP_Post ? $navigation[0]->ID : 0;
        $target = $this->header_content($navigation_id);
        WP_CLI::log(sprintf('Header-Override ID=%d: %s.', $header->ID, $dry_run ? 'würde migriert' : 'migriere'));

        if ($dry_run) {
            return;
        }

        $this->backup_post_content($header);
        $updated = wp_update_post(['ID' => $header->ID, 'post_content' => $target], true);
        if ($updated instanceof WP_Error) {
            WP_CLI::error($updated->get_error_message());
        }
        update_post_meta($header->ID, self::VERSION_META, self::VERSION);
    }

    private function get_header_override(): ?WP_Post
    {
        $posts = get_posts([
            'post_type' => 'wp_template_part',
            'post_status' => 'any',
            'name' => 'header',
            'numberposts' => 1,
        ]);
        return isset($posts[0]) && $posts[0] instanceof WP_Post ? $posts[0] : null;
    }

    private function migrate_global_styles(bool $dry_run, bool $force): void
    {
        $global_styles = $this->get_global_styles_override();
        if (! $global_styles instanceof WP_Post) {
            WP_CLI::log('Global Styles: kein Datenbank-Override vorhanden.');
            return;
        }
        if ((string) get_post_meta($global_styles->ID, self::VERSION_META, true) === self::VERSION) {
            WP_CLI::log('Global Styles: bereits normalisiert.');
            return;
        }

        $current_hash = hash('sha256', $global_styles->post_content);
        $previous_version = (string) get_post_meta($global_styles->ID, self::VERSION_META, true);
        if (! hash_equals(self::GLOBAL_STYLES_LEGACY_HASH, $current_hash) && $previous_version === '' && ! $force) {
            WP_CLI::error(sprintf('Global-Styles-Override weicht vom Audit-Hash ab (%s).', $current_hash));
        }

        WP_CLI::log(sprintf('Global Styles ID=%d: %s.', $global_styles->ID, $dry_run ? 'würde normalisiert' : 'normalisiere'));
        if ($dry_run) {
            return;
        }

        $this->backup_post_content($global_styles);
        $updated = wp_update_post([
            'ID' => $global_styles->ID,
            'post_content' => '{"settings":{},"isGlobalStylesUserThemeJSON":true,"version":3}',
        ], true);
        if ($updated instanceof WP_Error) {
            WP_CLI::error($updated->get_error_message());
        }
        update_post_meta($global_styles->ID, self::VERSION_META, self::VERSION);
    }

    private function get_global_styles_override(): ?WP_Post
    {
        $posts = get_posts([
            'post_type' => 'wp_global_styles',
            'post_status' => 'publish',
            'numberposts' => 1,
            'orderby' => 'ID',
            'order' => 'ASC',
        ]);
        return isset($posts[0]) && $posts[0] instanceof WP_Post ? $posts[0] : null;
    }

    private function migrate_editor_preferences(bool $dry_run): void
    {
        $users = get_users([
            'role__in' => ['administrator', 'editor'],
            'fields' => 'all',
        ]);

        foreach ($users as $user) {
            if (! $user instanceof WP_User
                || (string) get_user_meta($user->ID, self::EDITOR_PREFERENCES_VERSION_META, true) === '1') {
                continue;
            }

            $preferences = get_user_meta($user->ID, 'wp_persisted_preferences', true);
            if (! is_array($preferences)
                || empty($preferences['core']['fixedToolbar'])
                || empty($preferences['core']['distractionFree'])) {
                continue;
            }

            WP_CLI::log(sprintf(
                'Editor-Präferenzen für %s: %s ablenkungsfreien Modus.',
                $user->user_login,
                $dry_run ? 'würde deaktivieren' : 'deaktiviere'
            ));
            if ($dry_run) {
                continue;
            }

            if (! metadata_exists('user', $user->ID, self::EDITOR_PREFERENCES_BACKUP_META)
                && ! add_user_meta($user->ID, self::EDITOR_PREFERENCES_BACKUP_META, $preferences, true)) {
                WP_CLI::error(sprintf('Editor-Präferenzen für User %d konnten nicht gesichert werden.', $user->ID));
            }

            $preferences['core']['distractionFree'] = false;
            update_user_meta($user->ID, 'wp_persisted_preferences', $preferences);
            update_user_meta($user->ID, self::EDITOR_PREFERENCES_VERSION_META, '1');
        }
    }

    private function header_content(int $navigation_id): string
    {
        $navigation = $navigation_id > 0
            ? sprintf('<!-- wp:navigation {"ref":%d,"overlayMenu":"mobile","className":"site-header__navigation","layout":{"type":"flex","justifyContent":"right","flexWrap":"wrap"}} /-->', $navigation_id)
            : '<!-- wp:navigation {"overlayMenu":"mobile","className":"site-header__navigation"} /-->';

        return '<!-- wp:html --><a class="bsh-skip-link" href="#main-content">Zum Inhalt springen</a><!-- /wp:html -->' . "\n\n"
            . '<!-- wp:group {"className":"site-header","layout":{"type":"default"}} --><div class="wp-block-group site-header">'
            . '<!-- wp:group {"className":"site-header__inner","layout":{"type":"default"}} --><div class="wp-block-group site-header__inner">'
            . '<!-- wp:group {"className":"site-header__brand","layout":{"type":"default"}} --><div class="wp-block-group site-header__brand">'
            . '<!-- wp:site-logo {"width":61,"shouldSyncIcon":false,"className":"site-header__logo"} /-->'
            . '<!-- wp:group {"className":"site-header__brand-copy","layout":{"type":"constrained"}} --><div class="wp-block-group site-header__brand-copy">'
            . '<!-- wp:site-title {"level":0} /--><!-- wp:site-tagline /-->'
            . '</div><!-- /wp:group --></div><!-- /wp:group -->'
            . $navigation
            . '</div><!-- /wp:group --></div><!-- /wp:group -->';
    }

    private function ensure_site_logo(): int
    {
        $existing = get_posts([
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'meta_key' => '_bsh_editor_first_asset',
            'meta_value' => 'site-logo-v1',
            'numberposts' => 1,
            'fields' => 'ids',
        ]);

        if ($existing !== []) {
            $logo_id = (int) $existing[0];
            set_theme_mod('custom_logo', $logo_id);
            return $logo_id;
        }

        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $source = get_theme_file_path('assets/optimized/logo-full-640.webp');
        if (! is_readable($source)) {
            WP_CLI::error('Logo-Quelldatei ist nicht lesbar.');
        }
        $temporary = wp_tempnam('beziehungssache-hund-logo.webp');
        if (! $temporary || ! copy($source, $temporary)) {
            WP_CLI::error('Temporäre Logo-Datei konnte nicht erstellt werden.');
        }

        $logo_id = media_handle_sideload([
            'name' => 'beziehungssache-hund-logo.webp',
            'tmp_name' => $temporary,
        ], 0, 'Beziehungssache Hund Logo');
        if ($logo_id instanceof WP_Error) {
            @unlink($temporary);
            WP_CLI::error($logo_id->get_error_message());
        }

        update_post_meta((int) $logo_id, '_wp_attachment_image_alt', 'Beziehungssache Hund');
        update_post_meta((int) $logo_id, '_bsh_editor_first_asset', 'site-logo-v1');
        set_theme_mod('custom_logo', (int) $logo_id);
        return (int) $logo_id;
    }
}

WP_CLI::add_command('site-editor-migration', BSH_Site_Editor_Migration_Command::class);
