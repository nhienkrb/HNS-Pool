<?php
if (!defined('ABSPATH')) exit;

function sync_create_table() {
    global $wpdb;
    $table = $wpdb->prefix . 'sync_products';
    $charset = $wpdb->get_charset_collate();

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    $sql = "CREATE TABLE $table (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        external_id VARCHAR(191) NOT NULL,
        name TEXT NOT NULL,
        description MEDIUMTEXT NULL,
        content LONGTEXT NULL,
        category VARCHAR(255) NULL,
        price DECIMAL(15,2) DEFAULT 0,
        updated_at DATETIME NULL,
        data_hash CHAR(64) NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY ext_unique (external_id)
    ) $charset;";

    dbDelta($sql);
}
