<?php

class Queries
{
    public static function services($limit = 6, $extra_args = [])
    {
        $defaults = [
            'post_type'      => 'service',
            'posts_per_page' => $limit,
            'order'          => 'ASC',
        ];

        $args = wp_parse_args($extra_args, $defaults);

        return new \WP_Query($args);
    }


    public static function services_by_term($term_id, $limit = 6, $extra_args = [])
    {
        $defaults = [
            'post_type'      => 'service',
            'posts_per_page' => $limit,
            'orderby'        => 'menu_order date',
            'order'          => 'ASC',
            'tax_query'      => [
                [
                    'taxonomy' => 'service_category',
                    'field'    => 'term_id',
                    'terms'    => (array) $term_id,
                ],
            ],
        ];

        $args = wp_parse_args($extra_args, $defaults);

        return new \WP_Query($args);
    }

    public static function projects($limit = 6, $extra_args = [])
    {
        $defaults = [
            'post_type'      => 'project',
            'posts_per_page' => $limit,
            'order'          => 'ASC',
        ];

        $args = wp_parse_args($extra_args, $defaults);

        return new \WP_Query($args);
    }


     public static function posts($limit = 6)
    {
        return new WP_Query([
            'post_type'           => 'post',
            'posts_per_page'      => $limit,
            'ignore_sticky_posts' => true,
            'orderby'             => 'date',
            'order'               => 'DESC',
        ]);
    }


    public static function featured_news($limit = 3)
    {
        return new WP_Query([
            'post_type'           => 'post',
            'posts_per_page'      => $limit,
            'orderby'        => 'menu_order date',
            'order'          => 'ASC',

            'ignore_sticky_posts' => true,
            'tax_query'           => [
                [
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => ['noi-bat'],
                ],
            ],
        ]);
    }
}
