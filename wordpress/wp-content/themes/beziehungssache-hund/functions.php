<?php

declare(strict_types=1);

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
    }
);
