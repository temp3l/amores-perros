<?php

declare(strict_types=1);

require_once __DIR__ . '/inc/hero-images.php';
require_once __DIR__ . '/inc/faq.php';

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
        add_editor_style('style.css');

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
    }
);

add_action(
    'wp_enqueue_scripts',
    static function (): void {
        wp_enqueue_style(
            'beziehungssache-hund-style',
            get_stylesheet_uri(),
            [],
            wp_get_theme()->get('Version')
        );

        wp_enqueue_script(
            'beziehungssache-hund-header',
            get_template_directory_uri() . '/assets/js/header.js',
            [],
            wp_get_theme()->get('Version'),
            true
        );
        wp_script_add_data('beziehungssache-hund-header', 'strategy', 'defer');

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
        if (! is_singular()) {
            return;
        }

        $post = get_post();
        if (! $post instanceof WP_Post) {
            return;
        }

        if (! preg_match('/--bsh-hero-image:\\s*url\\(\\x27([^\\x27]+)\\x27\\)/', $post->post_content, $matches)) {
            return;
        }

        $hero_png_url = $matches[1];
        $hero_avif_url = preg_replace('/\\.png$/i', '.avif', $hero_png_url);

        if (! is_string($hero_avif_url) || $hero_avif_url === $hero_png_url) {
            return;
        }

        printf(
            '<link rel="preload" as="image" href="%s" type="image/avif" fetchpriority="high" />' . "\n",
            esc_url($hero_avif_url)
        );
    },
    1
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

    return str_contains($post->post_content, 'data-bsh-slider');
}
