<?php
add_action('init', function () {
    register_taxonomy('product_category', 'product', [
        'label' => 'Danh mục sản phẩm',
        'hierarchical' => true,
        'rewrite' => ['slug' => 'danh-muc-san-pham']
    ]);
});
