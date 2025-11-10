<?php

/**
 * Plugin Name: Google Sheet Product Sync
 * Description: Đồng bộ sản phẩm từ Google Sheet hàng ngày, có admin toggle.
 * Version: 1.1.0
 * Author: Nhien
 */

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';
require_once plugin_dir_path(__FILE__) . "includes/handle_syn_sheet.php";
require_once plugin_dir_path(__FILE__) . "includes/api.php";
require_once plugin_dir_path(__FILE__) . "includes/cron.php";

define("PRODUCT", "product");


function add_menu_admin_product_syn()
{
    add_menu_page(
        "products",
        "products",
        "manage_options",
        PRODUCT,
        'display_product_table',
        'dashicons-buddicons-tracking',
        4
    );
}
add_action('admin_menu', 'add_menu_admin_product_syn');


function display_product_table()
{
    require_once plugin_dir_path(__FILE__) . "views/display_product.php";
}
