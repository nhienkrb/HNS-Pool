<?php


add_action('customize_register', function ($wp_customize) {

    $wp_customize->add_panel('giaphan_news_panel', [
        'title'       => __('Trang Tin tức', 'giaphan'),
        'description' => __('Cấu hình các phần cho trang Tin tức', 'giaphan'),
        'priority'    => 40,
    ]);

    $wp_customize->add_section('giaphan_news_banner_section', [
        'title'       => __('Banner', 'giaphan'),
        'priority'    => 10,
        'panel'       => 'giaphan_news_panel',
    ]);

    $wp_customize->add_setting('news_banner_image', [
        'default'           => get_template_directory_uri() . '/assets/img/BANNER-about.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'news_banner_image',
            [
                'label'    => __('Ảnh banner trang Tin tức', 'giaphan'),
                'section'  => 'giaphan_news_banner_section',
                'settings' => 'news_banner_image',
            ]
        )
    );
});
