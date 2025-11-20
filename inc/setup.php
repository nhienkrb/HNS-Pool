<?php

add_action('after_setup_theme', 'register_nav_menu_theme', 11);
function register_nav_menu_theme()
{
    register_nav_menus(
        [
            'primary_navigation' => __('Menu Chính', 'theme-pool')
        ]
    );
};

function accept_img_type($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'accept_img_type');