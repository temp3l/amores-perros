<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Route local mail through Mailpit so form submissions are visible during development.
 */
add_action(
    'phpmailer_init',
    static function ($phpmailer): void {
        if (defined('WP_ENVIRONMENT_TYPE') && 'local' !== WP_ENVIRONMENT_TYPE) {
            return;
        }

        $phpmailer->isSMTP();
        $phpmailer->Host = 'mailpit';
        $phpmailer->Port = 1025;
        $phpmailer->SMTPAuth = false;
        $phpmailer->SMTPSecure = '';
        $phpmailer->SMTPAutoTLS = false;
        $phpmailer->From = 'info@beziehungssache-hund.de';
        $phpmailer->FromName = 'Beziehungssache Hund';
        $phpmailer->CharSet = 'UTF-8';
    }
);

add_filter(
    'wp_mail_from',
    static function (string $from): string {
        if (defined('WP_ENVIRONMENT_TYPE') && 'local' !== WP_ENVIRONMENT_TYPE) {
            return $from;
        }

        return 'info@beziehungssache-hund.de';
    }
);

add_filter(
    'wp_mail_from_name',
    static function (string $from_name): string {
        if (defined('WP_ENVIRONMENT_TYPE') && 'local' !== WP_ENVIRONMENT_TYPE) {
            return $from_name;
        }

        return 'Beziehungssache Hund';
    }
);
