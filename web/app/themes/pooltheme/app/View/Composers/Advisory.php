<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Advisory extends Composer
{

    protected static $views = [
        'page.advisory',
        'sections.advisory.*',
    ];

    public function with()
    {
        return ['posts' => $this->getAllPost()];
    }

    private function getAllPost()
    {
        return get_posts([
            'post_type'      => 'post',
            'orderBy' => 'date',
            'order' => 'DESC'
        ]);
    }
}
