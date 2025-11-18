<?php

add_action('init', function () {
    register_post_type('project', [
        'label' => 'Dự án tiêu biểu',
        'public' => true,
        'menu_icon' => 'dashicons-archive',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'du-tieu-bieu'],
    ]);
});
