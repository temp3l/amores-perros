<?php
/**
 * Plugin Name: BSH Site Editor Migration
 * Description: Loads the local, idempotent Gutenberg editor-first migration commands.
 */

declare(strict_types=1);

if (defined('WP_CLI') && WP_CLI) {
    require_once __DIR__ . '/site-editor-migration/site-editor-migration.php';
}
