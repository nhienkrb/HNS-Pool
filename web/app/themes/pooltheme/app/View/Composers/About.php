<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class About extends Composer
{

    protected static $views = [
        'pages.about',
        'sections.about.*'
    ];

    public function with()
    {
        return [
            'aboutDevelop' => $this->aboutDevelop(),
            'aboutJourney' => $this->aboutJourney(),
            'aboutOurProduct'       => $this->aboutOurProduct(),
            'aboutChooseUs' => $this->aboutChooseUs(),
        ];
    }

    private function aboutDevelop()
    {
        $layout_group = get_field('layout');

        return [
            'intro' => $layout_group ? $layout_group['intro_gioi_thieu_gt'] : 'intro GT',
            'title' => $layout_group ? $layout_group['title_about_gt'] : 'Tiêu đề mặc định',
            'content' => $layout_group['content_about_gt'],
            'image_gt' => $layout_group ? $layout_group['img_about_gt'] : false,
        ];
    }

    private function aboutJourney()
    {
        $image_arr_1 = get_field('journey_image_1');
        return [
            'title' => get_field('tieu_de_chinh'),
            'intro_content' => get_field('intro_chang_duong'),
            'year'        => get_field('journey_year_1'),
            'title'       => get_field('journey_title_1'),
            'description' => get_field('journey_description_1'),
            'image_url'   => $image_arr_1 ? $image_arr_1['url'] : false,
        ];
    }
    private function aboutOurProduct()
    {
        $layout_group = get_field('layout_product');
           return [
            'title' => $layout_group ? $layout_group['title_product1'] : 'Tiêu đề mặc định',
            'content1' => $layout_group['content1_product'],
            'content2' => $layout_group['content2_product'],
            'img_product' => $layout_group ? $layout_group['img_product'] : false,
        ];
    }
    private function aboutChooseUs()
    {
        $layout_group = get_field('layout_choose');
        return [
            'title' => $layout_group ? $layout_group['title_choose'] : 'Tiêu đề mặc định',
            'content1' => $layout_group['content1_choose'],
            'content2' => $layout_group['content2_choose'],
            'img_choose' => $layout_group ? $layout_group['img_choose'] : false,
        ];
    }
}
