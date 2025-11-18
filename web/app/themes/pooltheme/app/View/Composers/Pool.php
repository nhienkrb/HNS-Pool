<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Pool extends Composer
{

    protected static $views = [
        'products.*',
        'sections.pool.*',
    ];

    public function with()
    {
        error_log("Pool Running");
        return [
            'product_category' => $this->product_category(),
            'banner_pool' => $this->banner_pool(),
            'products' => $this->getAllProduct(),

        ];
    }
    private function getAllProduct()
    {

        $args = [
            'post_type'      => 'product',
            'posts_per_page' => 12,
            'orderBy' => 'date',
            'order' => 'DESC'
        ];
        return  get_posts($args);
    }

    private function product_category()
    {
        $args = [
            'taxonomy' => 'product_category',
            'hide_empty' => false,
        ];

        $categories = get_terms($args);

        if (is_wp_error($categories) || empty($categories)) {
            return [];
        }
        return $categories;
    }

    private function banner_pool()
    {
        $image_banner_pool = get_field('banner_pool');
        return   $image_banner_pool ?  $image_banner_pool['url'] : false;
    }
}
