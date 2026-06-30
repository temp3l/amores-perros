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
