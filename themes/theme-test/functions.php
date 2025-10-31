<?php
require_once get_template_directory() . '/include/handle_page_feedback.php';
require_once get_template_directory() . '/include/handle_display_view_table.php';



function myTheme_enqueue_styles()
{
    // css
    wp_enqueue_style('theme-css', get_template_directory_uri() . "/assets/css/my.css");
    wp_enqueue_style('theme-style', get_stylesheet_uri());

    // js
    wp_enqueue_script('theme-js', get_template_directory_uri() . "/assets/js/js-theme.js", array('jquery'), '1.0', true);
    wp_localize_script(
        'theme-js',
        'myAjax',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'), // Đường dẫn AJAX  của WP
            'home_url' => home_url()
        )
    );
    wp_enqueue_script('webcamjs', get_template_directory_uri() . "/assets/js/webcam.min.js", [], null, true);
    wp_enqueue_script('signature_pad', get_template_directory_uri() . "/assets/js/signature_pad.min.js", [], null, true);
};

function mytheme_register_nav_menus()
{
    register_nav_menus(array(
        'primary' => esc_html__('Menu Chính (Header)'),
    ));
}
add_action('after_setup_theme', 'mytheme_register_nav_menus');
