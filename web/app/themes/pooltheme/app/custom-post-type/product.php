<?php

add_action('init', function () {
    register_post_type('product', [
        'label' => 'Sản phẩm',
        'public' => true,
        'menu_icon' => 'dashicons-cart',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'san-pham'],
    ]);
});
