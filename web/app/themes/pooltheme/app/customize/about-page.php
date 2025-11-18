<?php
add_action('customize_register', function ($wp_customize) {

    $wp_customize->add_panel('about_Panel', [
        'title' => __('Nội dung trang giới thiệu'),
        'priority'    => 10,
        'description' => __('Quản lý nội dung các section trên trang chủ', 'sage'),
    ]);
    $wp_customize->add_section('about_Panel_intro_section', [
        'title'       => __('Nội dung giới thiệu', 'sage'),
        'panel'       => 'about_Panel',
        'priority'    => 1,
    ]);
    $wp_customize->add_setting('intro_name_page', [
        'default'   => 'Giới thiệu',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('intro_name_page', [
        'label'     => __('Tên trang', 'sage'),
        'section'   => 'about_Panel_intro_section',
        'type'      => 'text',
    ]);

     $wp_customize->add_setting('intro_journey', [
        'default'   => 'HÌNH THÀNH & PHÁT TRIỂN HNS',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('intro_journey', [
        'label'     => __('Tiêu đề phụ', 'sage'),
        'section'   => 'about_Panel_intro_section',
        'type'      => 'text',
    ]);


    $wp_customize->add_section('about_Panel_journey_section', [
        'title'       => __('Nội dung chặng đường', 'sage'),
        'panel'       => 'about_Panel',
        'priority'    => 2,
    ]);
    $wp_customize->add_setting('intro_journey_title', [
        'default'   => 'Chặng đường thành công',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('intro_journey_title', [
        'label'     => __('Tiêu đề', 'sage'),
        'section'   => 'about_Panel_journey_section',
        'type'      => 'text',
    ]);



});
