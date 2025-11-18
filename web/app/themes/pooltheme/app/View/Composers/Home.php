<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Home extends Composer
{

    protected static $views = [
        'front-page',
        'sections.home.*'
    ];

    public function with()
    {
        return [
            'about' => $this->about(),
            'featuredProducts' => $this->featuredProducts(),
            'latestNews'       => $this->latestNews(),
            'featuredProjects' => $this->featuredProjects(),
        ];
    }

    private function about()
    {
        $subtitle = get_theme_mod('intro_subtitle', 'Giới thiệu');
        $title = get_theme_mod('intro_title', 'HÌNH THÀNH & PHÁT TRIỂN HNS');
        $content1 = get_theme_mod('intro_content', 'Lần đầu tiên tôi xin thay mặt công ty...');
        $content2 = get_theme_mod('intro_content2', 'Quý khách hàng lời chào trân trọng...');

        $button_text = get_theme_mod('intro_button_text', 'XEM THÊM VỀ CHÚNG TÔI');
        $button_link = get_theme_mod('intro_button_link', '#');

        return [
            'subtitle'    => $subtitle,
            'title'       => $title,
            'content1'     => wpautop($content1),
            'content2'     => wpautop($content2),
            'button_text' => $button_text,
            'button_link' => $button_link,
        ];
    }
    private function featuredProducts()
    {
        return get_posts([
            'post_type' => 'product',
            'posts_per_page' => 6,
            'orderBy' => 'date',
            'order' => 'DESC'
        ]);
    }
    private function latestNews()
    {
        return get_posts([
            'post_type' => 'post',
            'posts_per_page' => 6,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);
    }
    private function featuredProjects()
    {
        return get_posts([
            'post_type' => 'project',
            'posts_per_page' => 6,
            'orderBy' => 'date',
            'order' => 'DESC'
        ]);
    }
}
