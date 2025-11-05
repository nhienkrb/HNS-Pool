<?php
class Logger_Categories
{
    public function __construct()
    {
        add_action('created_category', [$this, 'on_created'], 10, 2);
        add_action('edited_category', [$this, 'on_updated'], 10, 2);
        add_action('delete_category', [$this, 'on_deleted'], 10, 2);
    }

    public function on_created($term_id, $tt_id)
    {
        Logger_DB::insert(
            get_current_user_id(),
            "Category created"
        );
    }

    public function on_updated($term_id, $tt_id)
    {
        Logger_DB::insert(
            get_current_user_id(),
            "Category updated"
        );
    }

    public function on_deleted($term_id, $tt_id)
    {
        Logger_DB::insert(
            get_current_user_id(),
            "Category deleted"
        );
    }
}
