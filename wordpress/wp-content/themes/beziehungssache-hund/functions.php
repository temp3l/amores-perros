<?php

declare(strict_types=1);

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
    }
);
