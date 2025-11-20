<?php
// ----- Header   -----
add_action('customize_register', function ($wp_customize) {

    $wp_customize->add_panel('logo_panel', [
        'title'       => __('Logo Header', 'theme-pool'),
        'priority'    => 11,
        'description' => __('Quản lý logo và thông tin hiển thị trên header', 'theme-pool'),
    ]);

    $wp_customize->add_section('logo_theme', [
        'title' => __('Cấu hình Logo', 'theme-pool'),
        'panel' => 'logo_panel',
    ]);

    $wp_customize->add_setting('logo_image', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'logo_image',
        [
            'label'    => __('Ảnh Logo', 'theme-pool'),
            'section'  => 'logo_theme',
            'settings' => 'logo_image',
        ]
    ));

   
    $wp_customize->add_section('phone_header', [
        'title' => __('Cấu hình phone', 'theme-pool'),
        'panel' => 'logo_panel',
    ]);

    $wp_customize->add_setting('phone', [
        'default'           => '08321700969',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
      $wp_customize->add_control('phone', [
        'label'     => __('Số điện thoại', 'theme-pool'),
        'section'   => 'phone_header',
        'type'      => 'text',
    ]);
});


// -----  Giới Thiệu Tại Trang Home  ------ 
add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_panel('homepage_panel', [
        'title'       => __('Nội dung Giới thiệu Trang chủ', 'theme-pool'),
        'priority'    => 10,
        'description' => __('Quản lý nội dung các section trên trang chủ', 'theme-pool'),
    ]);

    $wp_customize->add_section('homepage_intro_section', [
        'title'       => __('Section Giới thiệu', 'theme-pool'),
        'panel'       => 'homepage_panel',
        'priority'    => 1,
    ]);
    $wp_customize->add_setting('intro_subtitle', [
        'default'   => 'Giới thiệu',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('intro_subtitle', [
        'label'     => __('Tiêu đề phụ', 'theme-pool'),
        'section'   => 'homepage_intro_section',
        'type'      => 'text',
    ]);

    $wp_customize->add_setting('intro_title', [
        'default'   => 'HÌNH THÀNH & PHÁT TRIỂN HNS',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('intro_title', [
        'label'     => __('Tiêu đề chính', 'theme-pool'),
        'section'   => 'homepage_intro_section',
        'type'      => 'text',
    ]);

    $wp_customize->add_setting('intro_content', [
        'default'   => 'Lần đầu tiên tôi xin thay mặt công ty...',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    $wp_customize->add_control('intro_content', [
        'label'     => __('Nội dung 1', 'theme-pool'),
        'section'   => 'homepage_intro_section',
        'type'      => 'textarea',
    ]);

    $wp_customize->add_setting('intro_content2', [
        'default'   => 'Lần đầu tiên tôi xin thay mặt công ty...',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    $wp_customize->add_control('intro_content2', [
        'label'     => __('Nội dung 2', 'theme-pool'),
        'section'   => 'homepage_intro_section',
        'type'      => 'textarea',
    ]);

    $wp_customize->add_setting('intro_button_text', [
        'default'   => 'XEM THÊM VỀ CHÚNG TÔI',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('intro_button_text', [
        'label'     => __('Chữ trên nút', 'theme-pool'),
        'section'   => 'homepage_intro_section',
        'type'      => 'text',
    ]);

    $wp_customize->add_setting('intro_button_link', [
        'default'   => '#',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('intro_button_link', [
        'label'     => __('Đường dẫn nút (URL)', 'theme-pool'),
        'section'   => 'homepage_intro_section',
        'type'      => 'url',
    ]);
});;



// ----- Banner tại trang Hồ bơi ------ 
add_action('customize_register', function ($wp_customize) {

    $wp_customize->add_panel('pool_panel', [
        'title'       => __('Banner Trang Hồ bơi', 'theme-pool'),
        'priority'    => 11,
        'description' => __('Quản lý Banner Trang Hồ bơi', 'theme-pool'),
    ]);

    $wp_customize->add_section('banner_section', [
        'title' => __('Section Banner', 'theme-pool'),
        'panel' => 'pool_panel',
    ]);

    $wp_customize->add_setting('banner_sb', [
        'default'           => 'Hồ Bơi',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('banner_sb', [
        'label'   => __('Tiêu đề phụ', 'theme-pool'),
        'section' => 'banner_section',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('banner_image', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'banner_image',
        [
            'label'    => __('Ảnh Banner', 'theme-pool'),
            'section'  => 'banner_section',
            'settings' => 'banner_image',
        ]
    ));
});
