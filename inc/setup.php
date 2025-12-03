<?php

function accept_img_type($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'accept_img_type');
function giaphan_theme_setup() {
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 300,
        'flex-width'  => true,
        'flex-height' => true,
    ]);

    register_nav_menus([
        'primary' => __('Main Menu', 'giaphan'),
    ]);
}
add_action('after_setup_theme', 'giaphan_theme_setup');
