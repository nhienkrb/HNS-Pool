<?php
namespace StoryMgr\Taxonomies;

final class Taxonomies {
    public static function register(): void {
        $labels = [
            'name'              => __('Story Authors', 'storymgr'),
            'singular_name'     => __('Story Author', 'storymgr'),
            'search_items'      => __('Search Authors', 'storymgr'),
            'all_items'         => __('All Authors', 'storymgr'),
            'edit_item'         => __('Edit Author', 'storymgr'),
            'update_item'       => __('Update Author', 'storymgr'),
            'add_new_item'      => __('Add New Author', 'storymgr'),
            'new_item_name'     => __('New Author Name', 'storymgr'),
            'menu_name'         => __('Authors', 'storymgr'),
        ];

        register_taxonomy('story_author', ['post'], [
            'labels'            => $labels,
            'public'            => true,
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'rewrite'           => ['slug' => 'tac-gia'],
        ]);
    }
}
