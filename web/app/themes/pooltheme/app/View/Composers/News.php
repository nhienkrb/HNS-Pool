<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class News extends Composer
{

    protected static $views = [
         'single',
        'blog.*',
        'sections.news.*',
    ];

    public function with()
    {
        return ['posts' => $this->getAllPost(), 'featured_post' => $this->getOnePost()];
    }

    private function getAllPost()
    {
        return get_posts([
            'post_type'      => 'post',
            'orderBy' => 'date',
            'order' => 'DESC'
        ]);
    }

    private function getOnePost()
    {
        $args = [
            'post_type' => 'post',
            'posts_per_page' => 1,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'post_status'    => 'publish',

        ];
        $posts = get_posts($args);
        if (! empty($posts)) {
            return $posts[0];
        }

        return null;
    }
}
