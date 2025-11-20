<?php


class Queries
{
    public static function latest_products($limit = 6)
    {
        return new \WP_Query([
            'post_type' => 'product',
            'posts_per_page' => $limit,
        ]);
    }

    public static function latest_projects($limit = 6)
    {
        return new \WP_Query([
            'post_type' => 'project',
            'posts_per_page' => $limit,
        ]);
    }

    public static function latest_news($limit = 6)
    {
        return new \WP_Query([
            'post_type' => 'post',
            'post_status'         => 'publish',
            'posts_per_page' => $limit,
        ]);
    }

    public static function latest_advisory($limit = 12)
    {
        return new \WP_Query([
            'post_type'      => 'post',
            'category_name'  => 'goc-tu-van', 
            'post_status'    => 'publish',
            'posts_per_page' => $limit,
        ]);
    }


    public static function sub_latest_news($limit = 4)
    {
        return new \WP_Query([
            'post_type' => 'post',
            'post_status'         => 'publish',
            'posts_per_page' => $limit,
        ]);
    }


    public static function get_all_category_product()
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

    // public static  function banner_pool()
    // {
    //     $image_banner_pool = get_field('banner_pool');
    //     return   $image_banner_pool ?  $image_banner_pool['url'] : false;
    // }
}
