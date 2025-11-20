<?php

add_action('init', function () {
    
    //---- Product ----
    register_post_type('product', [
        'label' => 'Sản Phẩm',
        'public' => true,
        'menu_icon' => 'dashicons-cart',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'san-pham'],
    ]);

    register_taxonomy('product_category', 'product', [
        'label' => 'Danh mục sản phẩm',
        'hierarchical' => true,
        'rewrite' => ['slug' => 'danh-muc-san-pham']
    ]);


    //---- Project ----
    register_post_type('project', [
        'label' => 'Dự án tiêu biểu',
        'public' => true,
        'menu_icon' => 'dashicons-archive',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'du-tieu-bieu'],
    ]);

    register_taxonomy('project_category', 'project', [
        'label' => 'Danh mục tiêu biểu',
        'hierarchical' => true,
        'rewrite' => ['slug' => 'danh-muc-du-an-tieu-bieu']
    ]);
    add_theme_support('post-thumbnails');
});
