<?php

class Breadcrumbs {

    public static function generate() {

        $home_url = home_url('/');
        $items = [];

        $items[] = [
            'label' => 'Trang chủ',
            'url'   => $home_url
        ];

        if (is_front_page()) {
            return $items;
        }

        if (is_single() && get_post_type() === 'post') {
            $cats = get_the_category();
            if (!empty($cats)) {
                $cat = $cats[0];
                $items[] = [
                    'label' => $cat->name,
                    'url'   => get_category_link($cat->term_id)
                ];
            }

            $items[] = [
                'label' => get_the_title(),
                'url'   => ''
            ];
            return $items;
        }

        if (is_singular() && !is_single()) {
            $post_type = get_post_type_object(get_post_type());
            if ($post_type) {
                $items[] = [
                    'label' => $post_type->labels->singular_name,
                    'url'   => get_post_type_archive_link($post_type->name)
                ];
            }
            $items[] = [
                'label' => get_the_title(),
                'url'   => ''
            ];
            return $items;
        }

        if (is_category()) {
            $items[] = [
                'label' => single_cat_title('', false),
                'url'   => ''
            ];
            return $items;
        }

        if (is_tag()) {
            $items[] = [
                'label' => single_tag_title('', false),
                'url'   => ''
            ];
            return $items;
        }

        if (is_tax()) {
            $term = get_queried_object();
            $items[] = [
                'label' => $term->name,
                'url'   => ''
            ];
            return $items;
        }

        if (is_search()) {
            $items[] = [
                'label' => 'Tìm kiếm: ' . get_search_query(),
                'url'   => ''
            ];
            return $items;
        }

        if (is_404()) {
            $items[] = [
                'label' => 'Không tìm thấy trang',
                'url'   => ''
            ];
            return $items;
        }

        return $items;
    }
}
