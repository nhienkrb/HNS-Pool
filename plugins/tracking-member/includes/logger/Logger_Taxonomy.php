<?php
class Logger_Taxonomy {
    public function __construct() {
        add_action('created_term', [$this, 'on_term_created'], 10, 3);
        add_action('edited_term', [$this, 'on_term_updated'], 10, 3);
        add_action('delete_term', [$this, 'on_term_deleted'], 10, 4);
    }

    public function on_term_created($term_id, $tt_id, $taxonomy) {
        $term = get_term($term_id);
        Logger_DB::insert(
            get_current_user_id(),
            "Taxonomy created"
        );
    }

    public function on_term_updated($term_id, $tt_id, $taxonomy) {
        $term = get_term($term_id);
        Logger_DB::insert(
            get_current_user_id(),
            "Taxonomy updated"
        );
    }

    public function on_term_deleted($term, $tt_id, $taxonomy, $deleted_term) {
        Logger_DB::insert(
            get_current_user_id(),
            "Taxonomy deleted"
        );
    }
}
