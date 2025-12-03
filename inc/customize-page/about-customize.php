<?php
// ============== Trang Giới thiệu ============
add_action('customize_register', function ($wp_customize) {

    $wp_customize->add_panel('giaphan_about_panel', [
        'title'       => __('Trang Giới thiệu', 'giaphan'),
        'description' => __('Cấu hình các phần cho trang Giới thiệu', 'giaphan'),
        'priority'    => 40,
    ]);

    // SECTION: Banner trang Giới thiệu
    $wp_customize->add_section('giaphan_about_banner_section', [
        'title'       => __('Banner', 'giaphan'),
        'priority'    => 10,
        'panel'       => 'giaphan_about_panel',
    ]);

    $wp_customize->add_setting('about_banner_image', [
        'default'           => get_template_directory_uri() . '/assets/img/BANNER-about.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'about_banner_image',
            [
                'label'    => __('Ảnh banner trang Giới thiệu', 'giaphan'),
                'section'  => 'giaphan_about_banner_section',
                'settings' => 'about_banner_image',
            ]
        )
    );


    // ================== SECTION: VỀ CHÚNG TÔI (NỘI DUNG) ==================
    $wp_customize->add_section('giaphan_about_content_section', [
        'title'    => __('Nội dung "Về chúng tôi"', 'giaphan'),
        'priority' => 20,
        'panel'    => 'giaphan_about_panel',
    ]);

    // Heading nhỏ
    $wp_customize->add_setting('about_page_heading_label', [
        'default'           => 'Về chúng tôi',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('about_page_heading_label', [
        'label'   => __('Tiêu đề nhỏ', 'giaphan'),
        'section' => 'giaphan_about_content_section',
        'type'    => 'text',
    ]);

    // Heading lớn
    $wp_customize->add_setting('about_page_heading_title', [
        'default'           => 'NHÔM KÍNH GIA PHAN – KIẾN TẠO KHÔNG GIAN SỐNG BỀN VỮNG',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('about_page_heading_title', [
        'label'   => __('Tiêu đề lớn', 'giaphan'),
        'section' => 'giaphan_about_content_section',
        'type'    => 'text',
    ]);

    // Ảnh 1
    $wp_customize->add_setting('about_page_image_1', [
        'default'           => get_template_directory_uri() . '/assets/img/about1.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'about_page_image_1',
            [
                'label'    => __('Ảnh 1 (bên phải trên)', 'giaphan'),
                'section'  => 'giaphan_about_content_section',
                'settings' => 'about_page_image_1',
            ]
        )
    );

    // Ảnh 2
    $wp_customize->add_setting('about_page_image_2', [
        'default'           => get_template_directory_uri() . '/assets/img/about1.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'about_page_image_2',
            [
                'label'    => __('Ảnh 2 (bên trái dưới)', 'giaphan'),
                'section'  => 'giaphan_about_content_section',
                'settings' => 'about_page_image_2',
            ]
        )
    );

    // 4–5 đoạn nội dung
    $wp_customize->add_setting('about_page_intro_p1', [
        'default'           => 'Công ty TNHH MTV Nhôm kính Gia Phan là công ty hoạt động chuyên nghiệp trong lĩnh vực gia công cơ khí dân dụng và công nghiệp được hình thành từ năm 2011...',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    $wp_customize->add_control('about_page_intro_p1', [
        'label'   => __('Đoạn 1 (phần trên)', 'giaphan'),
        'section' => 'giaphan_about_content_section',
        'type'    => 'textarea',
    ]);

    $wp_customize->add_setting('about_page_intro_p2', [
        'default'           => 'Với hơn 4 năm kinh nghiệm hoạt động trong ngành nhôm kính dân dụng và công nghiệp, Nhôm kính Gia Phan không ngừng cải tiến...',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    $wp_customize->add_control('about_page_intro_p2', [
        'label'   => __('Đoạn 2 (phần trên)', 'giaphan'),
        'section' => 'giaphan_about_content_section',
        'type'    => 'textarea',
    ]);

    $wp_customize->add_setting('about_page_body_p1', [
        'default'           => 'Nhôm kính Gia Phan đầu tư nghiên cứu phát triển kỹ thuật và công nghệ...',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    $wp_customize->add_control('about_page_body_p1', [
        'label'   => __('Đoạn 3 (phần dưới)', 'giaphan'),
        'section' => 'giaphan_about_content_section',
        'type'    => 'textarea',
    ]);

    $wp_customize->add_setting('about_page_body_p2', [
        'default'           => 'Chúng tôi luôn tâm niệm khách hàng và nhân lực là tài sản lớn nhất của Công ty...',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    $wp_customize->add_control('about_page_body_p2', [
        'label'   => __('Đoạn 4 (phần dưới)', 'giaphan'),
        'section' => 'giaphan_about_content_section',
        'type'    => 'textarea',
    ]);

    $wp_customize->add_setting('about_page_body_p3', [
        'default'           => 'Nhôm kính Gia Phan trân trọng cảm ơn sự ủng hộ của Quý đối tác...',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    $wp_customize->add_control('about_page_body_p3', [
        'label'   => __('Đoạn 5 (phần dưới)', 'giaphan'),
        'section' => 'giaphan_about_content_section',
        'type'    => 'textarea',
    ]);


    // ================== SECTION: TẦM NHÌN - SỨ MỆNH - GIÁ TRỊ CỐT LÕI ==================
    $wp_customize->add_section('giaphan_about_vmv_section', [
        'title'    => __('Tầm nhìn - Sứ mệnh - Giá trị cốt lõi', 'giaphan'),
        'priority' => 30,
        'panel'    => 'giaphan_about_panel',
    ]);

    // Ảnh nền banner phía trên
    $wp_customize->add_setting('about_vmv_bg_image', [
        'default'           => get_template_directory_uri() . '/assets/img/banner-tam-nhin.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);


    $wp_customize->add_setting('about_vmv_icon_mission', [
        'default'           => get_template_directory_uri() . '/assets/img/icon-su-menh.svg', // sửa lại path nếu khác
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'about_vmv_icon_mission',
            [
                'label'    => __('Icon box "Sứ mệnh"', 'giaphan'),
                'section'  => 'giaphan_about_vmv_section',
                'settings' => 'about_vmv_icon_mission',
            ]
        )
    );

    $wp_customize->add_setting('about_vmv_icon_values', [
        'default'           => get_template_directory_uri() . '/assets/img/iocn-gia-tri.svg', // đúng tên file bạn đang dùng
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'about_vmv_icon_values',
            [
                'label'    => __('Icon box "Giá trị cốt lõi"', 'giaphan'),
                'section'  => 'giaphan_about_vmv_section',
                'settings' => 'about_vmv_icon_values',
            ]
        )
    );

       // ================== SECTION: TẦM NHÌN - SỨ MỆNH - GIÁ TRỊ CỐT LÕI ==================
    $wp_customize->add_section('giaphan_about_vmv_section', [
        'title'    => __('Tầm nhìn - Sứ mệnh - Giá trị cốt lõi', 'giaphan'),
        'priority' => 30,
        'panel'    => 'giaphan_about_panel',
    ]);

    // Ảnh nền banner phía trên
    $wp_customize->add_setting('about_vmv_bg_image', [
        'default'           => get_template_directory_uri() . '/assets/img/banner-tam-nhin.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'about_vmv_bg_image',
            [
                'label'    => __('Ảnh nền "Tầm nhìn - Sứ mệnh - Giá trị cốt lõi"', 'giaphan'),
                'section'  => 'giaphan_about_vmv_section',
                'settings' => 'about_vmv_bg_image',
            ]
        )
    );

    // ========== ICON 3 BOX ==========
    $wp_customize->add_setting('about_vmv_icon_vision', [
        'default'           => get_template_directory_uri() . '/assets/img/icon-tam-nhin.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'about_vmv_icon_vision',
            [
                'label'    => __('Icon box "Tầm nhìn"', 'giaphan'),
                'section'  => 'giaphan_about_vmv_section',
                'settings' => 'about_vmv_icon_vision',
            ]
        )
    );

    $wp_customize->add_setting('about_vmv_icon_mission', [
        'default'           => get_template_directory_uri() . '/assets/img/icon-su-menh.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'about_vmv_icon_mission',
            [
                'label'    => __('Icon box "Sứ mệnh"', 'giaphan'),
                'section'  => 'giaphan_about_vmv_section',
                'settings' => 'about_vmv_icon_mission',
            ]
        )
    );

    $wp_customize->add_setting('about_vmv_icon_values', [
        'default'           => get_template_directory_uri() . '/assets/img/iocn-gia-tri.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'about_vmv_icon_values',
            [
                'label'    => __('Icon box "Giá trị cốt lõi"', 'giaphan'),
                'section'  => 'giaphan_about_vmv_section',
                'settings' => 'about_vmv_icon_values',
            ]
        )
    );

    // -------- CARD 1: TẦM NHÌN --------
    $wp_customize->add_setting('about_vmv_vision_title', [
        'default'           => 'Tầm nhìn',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('about_vmv_vision_title', [
        'label'   => __('Tiêu đề card 1', 'giaphan'),
        'section' => 'giaphan_about_vmv_section',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('about_vmv_vision_text', [
        'default'           => 'Trở thành một trong những công ty nhôm kính dân dụng và công nghiệp hàng đầu tại TP. Hồ Chí Minh và trong khu vực.',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    $wp_customize->add_control('about_vmv_vision_text', [
        'label'   => __('Nội dung card 1', 'giaphan'),
        'section' => 'giaphan_about_vmv_section',
        'type'    => 'textarea',
    ]);

    // -------- CARD 2: SỨ MỆNH --------
    $wp_customize->add_setting('about_vmv_mission_title', [
        'default'           => 'Sứ mệnh',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('about_vmv_mission_title', [
        'label'   => __('Tiêu đề card 2', 'giaphan'),
        'section' => 'giaphan_about_vmv_section',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('about_vmv_mission_items', [
        'default'           => "Tạo ra những sản phẩm chất lượng cao, các dự án đảm bảo tiêu chí về kỹ thuật, tiến độ và an toàn.\nNâng cao đời sống vật chất và tinh thần cho cán bộ, nhân viên công ty.\nChung tay xây dựng một xã hội giàu có, văn minh và hạnh phúc.",
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('about_vmv_mission_items', [
        'label'   => __('Các dòng bullet card 2 (mỗi dòng là 1 bullet)', 'giaphan'),
        'section' => 'giaphan_about_vmv_section',
        'type'    => 'textarea',
    ]);

    // -------- CARD 3: GIÁ TRỊ CỐT LÕI --------
    $wp_customize->add_setting('about_vmv_values_title', [
        'default'           => 'Giá trị cốt lõi',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('about_vmv_values_title', [
        'label'   => __('Tiêu đề card 3', 'giaphan'),
        'section' => 'giaphan_about_vmv_section',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('about_vmv_values_items', [
        'default'           => "Con người: Nhôm kính Gia Phan xem yếu tố con người là trọng tâm của mọi sự phát triển.\nChất lượng: Sản phẩm mang đến cho khách hàng là mục tiêu và là mối quan tâm hàng đầu.\nTính chuyên nghiệp: Quy trình làm việc hiện đại, hiệu quả, minh bạch.\nCam kết: Luôn đồng hành cùng khách hàng để mang lại giá trị bền vững.",
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('about_vmv_values_items', [
        'label'   => __('Các dòng bullet card 3 (mỗi dòng là 1 bullet)', 'giaphan'),
        'section' => 'giaphan_about_vmv_section',
        'type'    => 'textarea',
    ]);


        // ================== SECTION: THÀNH TÍCH / CHỨNG NHẬN ==================
    $wp_customize->add_section('giaphan_about_cert_section', [
        'title'    => __('Thành tích / Chứng nhận', 'giaphan'),
        'priority' => 40,
        'panel'    => 'giaphan_about_panel',
    ]);

    // Tiêu đề nhỏ: Thành tích
    $wp_customize->add_setting('about_cert_label', [
        'default'           => 'Thành tích',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('about_cert_label', [
        'label'   => __('Tiêu đề nhỏ', 'giaphan'),
        'section' => 'giaphan_about_cert_section',
        'type'    => 'text',
    ]);

    // Tiêu đề lớn
    $wp_customize->add_setting('about_cert_title', [
        'default'           => "CHỨNG NHẬN VÀ GIẢI THƯỞNG\nCỦA GIA PHAN",
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('about_cert_title', [
        'label'   => __('Tiêu đề lớn (có thể xuống dòng)', 'giaphan'),
        'section' => 'giaphan_about_cert_section',
        'type'    => 'textarea',
    ]);

    // Background decor phía sau 3 chứng nhận
    $wp_customize->add_setting('about_cert_bg', [
        'default'           => get_template_directory_uri() . '/assets/img/decor.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'about_cert_bg',
            [
                'label'    => __('Ảnh nền trang trí phía sau chứng nhận', 'giaphan'),
                'section'  => 'giaphan_about_cert_section',
                'settings' => 'about_cert_bg',
            ]
        )
    );

    // Ảnh chứng nhận 1
    $wp_customize->add_setting('about_cert_image_1', [
        'default'           => get_template_directory_uri() . '/assets/img/chung-nhan2.svg', // chỉnh lại path đúng file của bạn
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'about_cert_image_1',
            [
                'label'    => __('Ảnh chứng nhận 1', 'giaphan'),
                'section'  => 'giaphan_about_cert_section',
                'settings' => 'about_cert_image_1',
            ]
        )
    );

    // Ảnh chứng nhận 2
    $wp_customize->add_setting('about_cert_image_2', [
        'default'           => get_template_directory_uri() . '/assets/img/chung-nhan1.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'about_cert_image_2',
            [
                'label'    => __('Ảnh chứng nhận 2 (giữa)', 'giaphan'),
                'section'  => 'giaphan_about_cert_section',
                'settings' => 'about_cert_image_2',
            ]
        )
    );

    // Ảnh chứng nhận 3
    $wp_customize->add_setting('about_cert_image_3', [
        'default'           => get_template_directory_uri() . '/assets/img/chung-nhan3.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'about_cert_image_3',
            [
                'label'    => __('Ảnh chứng nhận 3', 'giaphan'),
                'section'  => 'giaphan_about_cert_section',
                'settings' => 'about_cert_image_3',
            ]
        )
    );

});
