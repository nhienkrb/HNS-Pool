<?php
add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_panel('homepage_panel', [
        'title'       => __('Nội dung Giới thiệu Trang chủ', 'sage'),
        'priority'    => 10,
        'description' => __('Quản lý nội dung các section trên trang chủ', 'sage'),
    ]);

    $wp_customize->add_section('homepage_intro_section', [
        'title'       => __('Section Giới thiệu', 'sage'),
        'panel'       => 'homepage_panel',
        'priority'    => 1,
    ]);
    $wp_customize->add_setting('intro_subtitle', [
        'default'   => 'Giới thiệu',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('intro_subtitle', [
        'label'     => __('Tiêu đề phụ', 'sage'),
        'section'   => 'homepage_intro_section',
        'type'      => 'text',
    ]);

    $wp_customize->add_setting('intro_title', [
        'default'   => 'HÌNH THÀNH & PHÁT TRIỂN HNS',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('intro_title', [
        'label'     => __('Tiêu đề chính', 'sage'),
        'section'   => 'homepage_intro_section',
        'type'      => 'text',
    ]);

    $wp_customize->add_setting('intro_content', [
        'default'   => 'Lần đầu tiên tôi xin thay mặt công ty...',
        'sanitize_callback' => 'wp_kses_post', 
    ]);
    $wp_customize->add_control('intro_content', [
        'label'     => __('Nội dung 1', 'sage'),
        'section'   => 'homepage_intro_section',
        'type'      => 'textarea', 
    ]);

      $wp_customize->add_setting('intro_content2', [
        'default'   => 'Lần đầu tiên tôi xin thay mặt công ty...',
        'sanitize_callback' => 'wp_kses_post', 
    ]);
    $wp_customize->add_control('intro_content2', [
        'label'     => __('Nội dung 2', 'sage'),
        'section'   => 'homepage_intro_section',
        'type'      => 'textarea', 
    ]);

    $wp_customize->add_setting('intro_button_text', [
        'default'   => 'XEM THÊM VỀ CHÚNG TÔI',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('intro_button_text', [
        'label'     => __('Chữ trên nút', 'sage'),
        'section'   => 'homepage_intro_section',
        'type'      => 'text',
    ]);

    $wp_customize->add_setting('intro_button_link', [
        'default'   => '#',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('intro_button_link', [
        'label'     => __('Đường dẫn nút (URL)', 'sage'),
        'section'   => 'homepage_intro_section',
        'type'      => 'url',
    ]);
});
