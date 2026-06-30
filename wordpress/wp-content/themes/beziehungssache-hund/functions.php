<?php

declare(strict_types=1);

add_action(
    'after_setup_theme',
    static function (): void {
        add_theme_support('wp-block-styles');
        add_theme_support('responsive-embeds');
    }
);
