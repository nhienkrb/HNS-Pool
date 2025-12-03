<?php

add_action('init', function () {

    //---- Service ----
    register_post_type('service', [
        'label'         => 'Dịch vụ',
        'public'        => true,
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-clipboard',
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'dich-vu'],
    ]);

    register_taxonomy('service_category', 'service', [
        'label'             => 'Danh mục dịch vụ',
        'hierarchical'      => true,
        'public'            => true,
        'show_admin_column' => true,
        'rewrite'           => ['slug' => 'danh-muc-dich-vu'],
    ]);

    // ---- Project (Dự án) ----
    register_post_type('project', [
        'label'         => 'Dự án',
        'public'        => true,
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-portfolio',
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'du-an'],
    ]);

    // ---- Taxonomy: Địa chỉ dự án ----
    register_taxonomy('project_category', 'project', [
        'label'             => 'Địa chỉ Dự án',
        'hierarchical'      => true,
        'public'            => true,
        'show_admin_column' => true,
        'rewrite'           => ['slug' => 'dia-chi-du-an'],
    ]);

});

add_action('after_setup_theme', function () {
    add_theme_support('post-thumbnails');
});