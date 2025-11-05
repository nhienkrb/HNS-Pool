<?php

const TABLE_NAME = "user_action_logger";


class Logger_DB
{
    // public static function create_table()
    // {
    //     global $wpdb;
    //     $table = $wpdb->prefix . TABLE_NAME;
    //     $charset = $wpdb->get_charset_collate();

    //     $sql = "CREATE TABLE IF NOT EXISTS $table (
    //         id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    //         user_id BIGINT(20),
    //         name VARCHAR(100),
    //         email VARCHAR(100),
    //         role VARCHAR(50),
    //         action_name VARCHAR(100),
    //         ip_address VARBINARY(16) DEFAULT NULL,
    //         date  DATETIME DEFAULT CURRENT_TIMESTAMP
    //     ) $charset;";

    //     require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    //     dbDelta($sql);
    // }

    public static function insert($user_id, $action_name)
    {
        $user = get_user_by('ID', $user_id);
        if (!$user) return;
        $ip_address = Logger_Utils::get_ip();

        global $wpdb;
        $wpdb->insert(
            $wpdb->prefix . TABLE_NAME,
            [
                'name'         => $user->display_name,
                'email'        => $user->user_email,
                'role'         => current($user->roles),
                'action_name'  => $action_name,
                'ip_address'   => $ip_address,
                'user_id'      => $user->ID,
            ],
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d'
            ]
        );
    }
};
