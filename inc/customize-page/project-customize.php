<?php
// ============== Trang Dịch vụ ==============
add_action('customize_register', function ($wp_customize) {

    $wp_customize->add_panel('giaphan_service_panel', [
        'title'       => __('Trang Dịch vụ', 'giaphan'),
        'description' => __('Cấu hình giao diện trang Dịch vụ', 'giaphan'),
        'priority'    => 45,
    ]);

    // SECTION: Banner trang Dịch vụ
    $wp_customize->add_section('giaphan_service_banner_section', [
        'title'       => __('Banner', 'giaphan'),
        'priority'    => 10,
        'panel'       => 'giaphan_service_panel',
    ]);

    $wp_customize->add_setting('service_banner_image', [
        'default'           => get_template_directory_uri() . '/assets/img/banner-service.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'service_banner_image',
            [
                'label'    => __('Ảnh banner trang Dịch vụ', 'giaphan'),
                'section'  => 'giaphan_service_banner_section',
                'settings' => 'service_banner_image',
            ]
        )
    );

});
