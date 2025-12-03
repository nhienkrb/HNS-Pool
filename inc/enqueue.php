<?php
function theme_scripts() {
    wp_enqueue_style('main-css', get_template_directory_uri() . '/assets/assets/main-DF7bZ1FH.css');
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/assets/main-tVNspECq.js', [], false, true);
}
add_action('wp_enqueue_scripts', 'theme_scripts');
