<?php
require_once get_template_directory() . '/include/api/Tracking_Controller.php';

add_action('rest_api_init', function () {
    $controller = new Tracking_Controller();
    $controller->register_routes();
});

// function create_post_views_table() {
//     global $wpdb;
//     require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

//     $table_name = $wpdb->prefix . 'post_views';

//     $sql = "CREATE TABLE $table_name (
//         id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
//         post_id bigint(20) NOT NULL,
//         ip_address VARBINARY(16) DEFAULT NULL,
//         last_view int(11) NOT NULL,
//         created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
//         PRIMARY KEY (id),
//         KEY post_id (post_id)
//     ) DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;"; 

//     dbDelta( $sql ); 
// }
// add_action( 'after_switch_theme', 'create_post_views_table' );
