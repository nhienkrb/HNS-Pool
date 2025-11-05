<?php
class Logger_Menu
{
    public function __construct()
    {
        add_action('wp_create_nav_menu', [$this, 'on_menu_created'], 10, 1);
        add_action('wp_update_nav_menu', [$this, 'on_menu_updated'], 10, 1);
        add_action('delete_nav_menu', [$this, 'on_menu_deleted'], 10, 1);
    }

    public function on_menu_created($menu_id)
    {
        Logger_DB::insert(
            get_current_user_id(),
            "Menu created (ID: $menu_id)"
        );

    }

    public function on_menu_updated($menu_id)
    {
        Logger_DB::insert(
            get_current_user_id(),
            "Menu updated (ID: $menu_id)"
        );

    }

    public function on_menu_deleted($menu_id)
    {
        Logger_DB::insert(
            get_current_user_id(),
            "Menu deleted (ID: $menu_id)"
        );

    }
}
