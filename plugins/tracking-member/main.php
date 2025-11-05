<?php

/**
 * Plugin Name:  Tracking Member
 * Author: Nhien
 * Description: Theo dõi hành động của thành viên
 */

defined('ABSPATH') || exit;

require_once plugin_dir_path(__FILE__) . "includes/logger/Logger_loader.php";
// require_once plugin_dir_path(__FILE__) . "includes/Add_Action_Log.php";

add_action('plugins_loaded', function () {
    Logger_loader::init();
});

define("TRACKING_MEMBER_SLUG", "lich-su-hoat-dong");

function add_menu_admin_tracking_action()
{
    add_menu_page(
        "Lịch sử hoạt động",
        "Lịch sử hoạt động",
        "manage_options",
        TRACKING_MEMBER_SLUG,
        'view_user_action_logs',
        'dashicons-buddicons-tracking',
        3
    );
}
add_action('admin_menu', 'add_menu_admin_tracking_action');

function view_user_action_logs()
{
    require_once plugin_dir_path(__FILE__) . "views/display_user_action_logs.php";
}
