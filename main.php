<?php

/**
 * Plugin Name:  Class list table wp
 * Author: Nhien
 * Description: Demo Class list table wp
 */
require_once plugin_dir_path(__FILE__) . "includes/My_List_Table.php";
require_once plugin_dir_path(__FILE__) . "includes/ajax-handler.php";

function my_add_menu_manager_member()
{
    add_menu_page(
        'Page manager member',
        "Quản lý memeber",
        "manage_options",
        "quan-ly-member",
        "view_quan_ly_member",
        "dashicons-universal-access"
    );
}


function view_quan_ly_member()
{
    require_once plugin_dir_path(__FILE__) . "views/display_manager_member.php";
}

add_action('admin_menu', 'my_add_menu_manager_member');
