<?php

declare(strict_types=1);

require_once __DIR__ . '/inc/hero-images.php';
require_once __DIR__ . '/inc/price-cards.php';
require_once __DIR__ . '/inc/faq.php';

function bsh_register_theme_pattern(string $slug, string $title, string $pattern_path): void
{
    if (! function_exists('register_block_pattern')) {
        return;
    }

    $pattern_file = get_theme_file_path($pattern_path);
    if (! file_exists($pattern_file)) {
        return;
    }

    ob_start();
    include $pattern_file;
    $content = ob_get_clean();

    if (! is_string($content) || $content === '') {
        return;
    }

    register_block_pattern(
        'beziehungssache-hund/' . $slug,
        [
            'title' => __($title, 'beziehungssache-hund'),
            'categories' => ['beziehungssache-hund'],
            'content' => $content,
        ]
    );
}

add_action(
    'after_setup_theme',
    static function (): void {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('wp-block-styles');
        add_theme_support('responsive-embeds');
        add_theme_support('editor-styles');
        add_theme_support('custom-spacing');
        add_theme_support('custom-line-height');
        add_editor_style(
            [
                'style.css',
                'assets/css/faq.css',
                'assets/css/editor.css',
            ]
        );

        register_nav_menus(
            [
                'primary' => __('Hauptnavigation', 'beziehungssache-hund'),
            ]
        );

        register_block_pattern_category(
            'beziehungssache-hund',
            [
                'label' => __('Beziehungssache Hund', 'beziehungssache-hund'),
            ]
        );

        bsh_register_theme_pattern('landing-2', 'Landing 2', 'patterns/landing-2.php');
        bsh_register_theme_pattern('kitesplash', 'Kitesplash', 'patterns/kitesplash.php');
    }
);

add_action(
    'init',
    static function (): void {
        register_block_style(
            'core/group',
            [
                'name' => 'bsh-hidden',
                'label' => __('Auf Website ausblenden', 'beziehungssache-hund'),
            ]
        );
    }
);

add_action(
    'wp_enqueue_scripts',
    static function (): void {
        $theme_stylesheet = get_theme_file_path('style.css');

        wp_enqueue_style(
            'beziehungssache-hund-style',
            get_stylesheet_uri(),
            [],
            file_exists($theme_stylesheet) ? (string) filemtime($theme_stylesheet) : wp_get_theme()->get('Version')
        );

        wp_enqueue_script(
            'beziehungssache-hund-header',
            get_template_directory_uri() . '/assets/js/header.js',
            [],
            wp_get_theme()->get('Version'),
            true
        );
        wp_script_add_data('beziehungssache-hund-header', 'strategy', 'defer');

        if (is_front_page()) {
            $landing_hero_js = get_theme_file_path('assets/js/landing-hero.js');

            wp_enqueue_script(
                'beziehungssache-hund-landing-hero',
                get_theme_file_uri('assets/js/landing-hero.js'),
                [],
                file_exists($landing_hero_js) ? (string) filemtime($landing_hero_js) : wp_get_theme()->get('Version'),
                true
            );
            wp_script_add_data('beziehungssache-hund-landing-hero', 'strategy', 'defer');
        }

        if (bsh_should_enqueue_image_slider()) {
            $slider_js = get_theme_file_path('assets/js/image-slider.js');

            wp_enqueue_script(
                'beziehungssache-hund-image-slider',
                get_theme_file_uri('assets/js/image-slider.js'),
                [],
                file_exists($slider_js) ? (string) filemtime($slider_js) : wp_get_theme()->get('Version'),
                true
            );
            wp_script_add_data('beziehungssache-hund-image-slider', 'strategy', 'defer');
        }

        if (bsh_page_uses_forminator()) {
            $form_js = get_theme_file_path('assets/js/form.js');

            wp_enqueue_script(
                'beziehungssache-hund-form',
                get_theme_file_uri('assets/js/form.js'),
                ['jquery'],
                file_exists($form_js) ? (string) filemtime($form_js) : wp_get_theme()->get('Version'),
                true
            );
            wp_script_add_data('beziehungssache-hund-form', 'strategy', 'defer');
        }

        if (! is_page('faq')) {
            return;
        }

        $faq_css = get_theme_file_path('assets/css/faq.css');
        $faq_js = get_theme_file_path('assets/js/faq.js');

        wp_enqueue_style(
            'beziehungssache-hund-faq',
            get_theme_file_uri('assets/css/faq.css'),
            [],
            file_exists($faq_css) ? (string) filemtime($faq_css) : wp_get_theme()->get('Version')
        );

        wp_enqueue_script(
            'beziehungssache-hund-faq',
            get_theme_file_uri('assets/js/faq.js'),
            [],
            file_exists($faq_js) ? (string) filemtime($faq_js) : wp_get_theme()->get('Version'),
            true
        );
        wp_script_add_data('beziehungssache-hund-faq', 'strategy', 'defer');
    }
);

add_action(
    'wp_head',
    static function (): void {
        $favicon = get_theme_file_uri('assets/brand/log-cropped-favicon.png');

        echo '<link rel="icon" type="image/png" sizes="96x96" href="' . esc_url($favicon) . '">' . "\n";
        echo '<link rel="shortcut icon" type="image/png" href="' . esc_url($favicon) . '">' . "\n";
    },
    1
);

add_action(
    'wp_head',
    static function (): void {
        if (! is_page('faq')) {
            return;
        }

        $post = get_post();
        if (! $post instanceof WP_Post) {
            return;
        }

        $questions = [];
        $collect = static function (array $blocks) use (&$collect, &$questions): void {
            foreach ($blocks as $block) {
                if (($block['blockName'] ?? '') === 'core/details') {
                    $rendered = render_block($block);
                    if (preg_match('/<summary[^>]*>(.*?)<\/summary>(.*)<\/details>/si', $rendered, $matches) === 1) {
                        $question = trim(wp_strip_all_tags($matches[1]));
                        $answer = trim(preg_replace('/\s+/', ' ', wp_strip_all_tags($matches[2])) ?? '');
                        if ($question !== '' && $answer !== '') {
                            $questions[] = [
                                '@type' => 'Question',
                                'name' => $question,
                                'acceptedAnswer' => [
                                    '@type' => 'Answer',
                                    'text' => $answer,
                                ],
                            ];
                        }
                    }
                }

                if (! empty($block['innerBlocks'])) {
                    $collect($block['innerBlocks']);
                }
            }
        };
        $collect(parse_blocks($post->post_content));

        if ($questions === []) {
            return;
        }

        echo '<script type="application/ld+json">' . wp_json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $questions,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    },
    20
);

add_filter(
    'body_class',
    static function (array $classes): array {
        if (is_page('landing-2')) {
            $classes[] = 'bsh-landing-2-page';
        }

        if (is_page('kitesplash')) {
            $classes[] = 'bsh-kitesplash-page';
        }

        return $classes;
    }
);

function bsh_should_enqueue_image_slider(): bool
{
    if (! is_singular()) {
        return false;
    }

    $post = get_post();
    if (! $post instanceof WP_Post) {
        return false;
    }

    return str_contains($post->post_content, 'bsh-image-slider');
}

function bsh_page_uses_forminator(): bool
{
    if (! is_singular()) {
        return false;
    }

    $post = get_post();
    if (! $post instanceof WP_Post) {
        return false;
    }

    return str_contains($post->post_content, '[forminator_form');
}
