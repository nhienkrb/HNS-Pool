<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Project extends Composer
{

    protected static $views = [
        'pages.projects',
        'sections.projects.*',
    ];

    public function with()
    {
        return [
            'projects' => $this->getAllProject(),
        ];
    }
    private function getAllProject()
    {

        $args = [
            'post_type'      => 'project',
            'posts_per_page' => 12,
            'orderBy' => 'date',
            'order' => 'DESC'
        ];
        return  get_posts($args);
    }

}
