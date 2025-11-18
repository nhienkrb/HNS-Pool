<?php
add_action('init', function () {
    register_taxonomy('project_category', 'project', [
        'label' => 'Danh mục tiêu biểu',
        'hierarchical' => true,
        'rewrite' => ['slug' => 'danh-muc-du-an-tieu-bieu']
    ]);
});
