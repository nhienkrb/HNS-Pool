<?php
// ========= Header + About Section ===========
add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_section('giaphan_header_section', [
        'title'    => __('Header Settings', 'giaphan'),
        'priority' => 30,
    ]);

    // Phone
    $wp_customize->add_setting('header_phone', [
        'default'           => '0123 456 789',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('header_phone', [
        'label'   => __('Số điện thoại header', 'giaphan'),
        'section' => 'giaphan_header_section',
        'type'    => 'text',
    ]);

    // Logo header
    $wp_customize->add_setting('header_logo', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'header_logo',
            [
                'label'    => __('Logo header', 'giaphan'),
                'section'  => 'giaphan_header_section',
                'settings' => 'header_logo',
            ]
        )
    );

    // ================== ABOUT SECTION ==================
    $wp_customize->add_section('giaphan_about_section', [
        'title'    => __('About Section (Trang chủ)', 'giaphan'),
        'priority' => 40,
    ]);

    // Nhãn nhỏ: "Về chúng tôi"
    $wp_customize->add_setting('about_label', [
        'default'           => 'Về Chúng tôi',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('about_label', [
        'label'   => __('Tiêu đề nhỏ', 'giaphan'),
        'section' => 'giaphan_about_section',
        'type'    => 'text',
    ]);

    // Tiêu đề lớn
    $wp_customize->add_setting('about_title', [
        'default'           => 'Nhôm Kính Gia Phan - Kiến tạo không gian sống bền vững',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('about_title', [
        'label'   => __('Tiêu đề lớn', 'giaphan'),
        'section' => 'giaphan_about_section',
        'type'    => 'text',
    ]);

    // Nội dung
    $wp_customize->add_setting('about_content', [
        'default'           => 'Công ty TNHH MTV Nhôm kính Gia Phan là công ty hoạt động chuyên nghiệp trong lĩnh vực gia công cơ khí dân dụng và công nghiệp...',
        'sanitize_callback' => 'wp_kses_post',
    ]);

    $wp_customize->add_control('about_content', [
        'label'   => __('Nội dung giới thiệu', 'giaphan'),
        'section' => 'giaphan_about_section',
        'type'    => 'textarea',
    ]);

    // Text nút
    $wp_customize->add_setting('about_button_text', [
        'default'           => 'Xem Thêm',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('about_button_text', [
        'label'   => __('Text nút', 'giaphan'),
        'section' => 'giaphan_about_section',
        'type'    => 'text',
    ]);

    // Link nút
    $wp_customize->add_setting('about_button_url', [
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control('about_button_url', [
        'label'   => __('Link nút', 'giaphan'),
        'section' => 'giaphan_about_section',
        'type'    => 'url',
    ]);
    // ================== END ABOUT SECTION ==================



    $wp_customize->add_section('giaphan_stats_section', [
        'title'    => __('Stats Section (Trang chủ)', 'giaphan'),
        'priority' => 45,
    ]);

    // Ảnh bên trái
    $wp_customize->add_setting('stats_main_image', [
        'default'           => get_template_directory_uri() . '/assets/img/home1.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'stats_main_image',
            [
                'label'    => __('Ảnh bên trái', 'giaphan'),
                'section'  => 'giaphan_stats_section',
                'settings' => 'stats_main_image',
            ]
        )
    );

    // Logo outline bên phải
    $wp_customize->add_setting('stats_logo_image', [
        'default'           => get_template_directory_uri() . '/assets/img/LOGO-Giaphan1-outline.svg',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'stats_logo_image',
            [
                'label'    => __('Logo outline trong block số liệu', 'giaphan'),
                'section'  => 'giaphan_stats_section',
                'settings' => 'stats_logo_image',
            ]
        )
    );

    // Khối 1: Khách hàng
    $wp_customize->add_setting('stats_1_number', [
        'default'           => '50+',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('stats_1_number', [
        'label'   => __('Số liệu 1 - Giá trị', 'giaphan'),
        'section' => 'giaphan_stats_section',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('stats_1_label', [
        'default'           => 'Khách hàng',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('stats_1_label', [
        'label'   => __('Số liệu 1 - Nhãn', 'giaphan'),
        'section' => 'giaphan_stats_section',
        'type'    => 'text',
    ]);

    // Khối 2: Nhân sự
    $wp_customize->add_setting('stats_2_number', [
        'default'           => '20+',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('stats_2_number', [
        'label'   => __('Số liệu 2 - Giá trị', 'giaphan'),
        'section' => 'giaphan_stats_section',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('stats_2_label', [
        'default'           => 'Nhân sự',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('stats_2_label', [
        'label'   => __('Số liệu 2 - Nhãn', 'giaphan'),
        'section' => 'giaphan_stats_section',
        'type'    => 'text',
    ]);

    // Khối 3: Đối tác
    $wp_customize->add_setting('stats_3_number', [
        'default'           => '18+',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('stats_3_number', [
        'label'   => __('Số liệu 3 - Giá trị', 'giaphan'),
        'section' => 'giaphan_stats_section',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('stats_3_label', [
        'default'           => 'Đối tác',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('stats_3_label', [
        'label'   => __('Số liệu 3 - Nhãn', 'giaphan'),
        'section' => 'giaphan_stats_section',
        'type'    => 'text',
    ]);

    // Khối 4: Năm kinh nghiệm
    $wp_customize->add_setting('stats_4_number', [
        'default'           => '15+',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('stats_4_number', [
        'label'   => __('Số liệu 4 - Giá trị', 'giaphan'),
        'section' => 'giaphan_stats_section',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('stats_4_label', [
        'default'           => 'Năm kinh nghiệm',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('stats_4_label', [
        'label'   => __('Số liệu 4 - Nhãn', 'giaphan'),
        'section' => 'giaphan_stats_section',
        'type'    => 'text',
    ]);

    // ================== PARTNERS SECTION (SECTION 5) ==================
    $wp_customize->add_section('giaphan_partners_section', [
        'title'    => __('Partners Section (Trang chủ)', 'giaphan'),
        'priority' => 50,
    ]);

    // Tiêu đề nhỏ: Đối tác - khách hàng
    $wp_customize->add_setting('partners_label', [
        'default'           => 'Đối tác - khách hàng',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('partners_label', [
        'label'   => __('Tiêu đề nhỏ', 'giaphan'),
        'section' => 'giaphan_partners_section',
        'type'    => 'text',
    ]);

    // Tiêu đề lớn
    $wp_customize->add_setting('partners_title', [
        'default'           => 'đồng hành cùng nhôm kính gia phan',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('partners_title', [
        'label'   => __('Tiêu đề lớn', 'giaphan'),
        'section' => 'giaphan_partners_section',
        'type'    => 'text',
    ]);

    for ($i = 1; $i <= 8; $i++) {
        $wp_customize->add_setting("partners_logo_$i", [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                "partners_logo_{$i}_control",
                [
                    'label'    => sprintf(__('Logo đối tác %d', 'giaphan'), $i),
                    'section'  => 'giaphan_partners_section',
                    'settings' => "partners_logo_$i",
                ]
            )
        );
    }



    // PANEL: Trang Liên hệ
    $wp_customize->add_panel('giaphan_contact_panel', [
        'title'       => __('Trang Liên Hệ', 'giaphan'),
        'description' => __('Cấu hình nội dung cho trang Liên hệ', 'giaphan'),
        'priority'    => 50,
    ]);

    /*
    |----------------------------------------------------------------
    | SECTION: Banner
    |----------------------------------------------------------------
    */
    $wp_customize->add_section('giaphan_contact_banner_section', [
        'title'    => __('Banner', 'giaphan'),
        'panel'    => 'giaphan_contact_panel',
        'priority' => 10,
    ]);

    // Ảnh banner
    $wp_customize->add_setting('contact_banner_image', [
        'default'           => get_theme_file_uri('/assets/img/banner-contact.svg'),
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'contact_banner_image',
            [
                'label'    => __('Ảnh banner', 'giaphan'),
                'section'  => 'giaphan_contact_banner_section',
                'settings' => 'contact_banner_image',
            ]
        )
    );

    // Text lớn "CONTACT US"
    $wp_customize->add_setting('contact_banner_title', [
        'default'           => 'CONTACT US',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('contact_banner_title', [
        'label'   => __('Tiêu đề lớn trên banner', 'giaphan'),
        'section' => 'giaphan_contact_banner_section',
        'type'    => 'text',
    ]);

    // SECTION: Giới thiệu / tiêu đề giữa
    $wp_customize->add_section('giaphan_contact_intro_section', [
        'title'    => __('Tiêu đề & mô tả', 'giaphan'),
        'panel'    => 'giaphan_contact_panel',
        'priority' => 30,
    ]);

    // H1: LIÊN HỆ VỚI NHÔM KÍNH GIA PHAN
    $wp_customize->add_setting('contact_intro_heading', [
        'default'           => 'LIÊN HỆ VỚI NHÔM KÍNH GIA PHAN',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('contact_intro_heading', [
        'label'   => __('Tiêu đề lớn', 'giaphan'),
        'section' => 'giaphan_contact_intro_section',
        'type'    => 'text',
    ]);

    // Đoạn mô tả
    $wp_customize->add_setting('contact_intro_text', [
        'default'           => 'Gia Phan rất mong nhận được phản hồi từ bạn và cùng nhau bắt đầu một điều gì đó đặc biệt. Hãy gọi cho chúng tôi nếu bạn có bất kỳ thắc mắc nào.',
        'sanitize_callback' => 'wp_kses_post',
    ]);

    $wp_customize->add_control('contact_intro_text', [
        'label'   => __('Đoạn mô tả', 'giaphan'),
        'section' => 'giaphan_contact_intro_section',
        'type'    => 'textarea',
    ]);

    //SECTION: Thông tin liên hệ + ảnh bên cạnh
    $wp_customize->add_section('giaphan_contact_info_section', [
        'title'    => __('Thông tin liên hệ', 'giaphan'),
        'panel'    => 'giaphan_contact_panel',
        'priority' => 40,
    ]);

    // Tên công ty
    $wp_customize->add_setting('contact_company_name', [
        'default'           => 'CÔNG TY TNHH MTV THƯƠNG MẠI DỊCH VỤ NHÔM KÍNH GIA PHAN',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('contact_company_name', [
        'label'   => __('Tên công ty', 'giaphan'),
        'section' => 'giaphan_contact_info_section',
        'type'    => 'text',
    ]);

    // Điện thoại
    $wp_customize->add_setting('contact_phone', [
        'default'           => '08 6275 3239 - 093 5555 456',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('contact_phone', [
        'label'   => __('Số điện thoại', 'giaphan'),
        'section' => 'giaphan_contact_info_section',
        'type'    => 'text',
    ]);

    // Email
    $wp_customize->add_setting('contact_email', [
        'default'           => 'nhomkinhgiaphan@gmail.com',
        'sanitize_callback' => 'sanitize_email',
    ]);

    $wp_customize->add_control('contact_email', [
        'label'   => __('Email', 'giaphan'),
        'section' => 'giaphan_contact_info_section',
        'type'    => 'text',
    ]);

    // Địa chỉ
    $wp_customize->add_setting('contact_address', [
        'default'           => '11/2 Đường liên khu 2 -10, P.Bình Hưng Hòa A, Q.Bình Tân, TP. HCM.',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('contact_address', [
        'label'   => __('Địa chỉ văn phòng', 'giaphan'),
        'section' => 'giaphan_contact_info_section',
        'type'    => 'textarea',
    ]);

    // Ảnh bên cạnh form 
    $wp_customize->add_setting('contact_side_image', [
        'default'           => get_theme_file_uri('/assets/img/banner2-contact.png'),
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'contact_side_image',
            [
                'label'    => __('Ảnh bên cạnh form', 'giaphan'),
                'section'  => 'giaphan_contact_info_section',
                'settings' => 'contact_side_image',
            ]
        )
    );


    //SECTION: Bản đồ
    $wp_customize->add_section('giaphan_contact_map_section', [
        'title'    => __('Bản đồ', 'giaphan'),
        'panel'    => 'giaphan_contact_panel',
        'priority' => 50,
    ]);

    // URL embed Google Maps
    $wp_customize->add_setting('contact_map_url', [
        'default'           => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4570165705354!2d106.6063701809902!3d10.77626648733133!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752c14c5a09755%3A0xdf8c9b3374896ec1!2zMzUyIMSQLiBMw6ogVsSDbiBRdeG7m2ksIELDrG5oIFRy4buLIMSQw7RuZyBBLCBCw6xuaCBUw6JuLCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1764579371734!5m2!1svi!2s',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control('contact_map_url', [
        'label'       => __('Google Maps embed URL (thuộc tính src)', 'giaphan'),
        'description' => __('Dán nguyên giá trị của thuộc tính src trong mã nhúng iframe Google Maps.', 'giaphan'),
        'section'     => 'giaphan_contact_map_section',
        'type'        => 'text',
    ]);
});;
