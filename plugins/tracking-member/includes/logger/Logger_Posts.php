<?php
class Logger_Posts
{
    public function __construct()
    {
        add_action('save_post', [$this, 'on_save'], 10, 3);
        add_action('before_delete_post', [$this, 'on_delete']);
    }

    public function on_save($post_id, $post, $update)
    {
        if (!in_array($post->post_type, ['post', 'page'])) return;
        $action = $update ? 'updated' : 'created';
        error_log('created post  chạy');
        Logger_DB::insert(get_current_user_id(), "{$post->post_type}_{$action}");
    }

    public function on_delete($post_id)
    {
        $post = get_post($post_id);
        if (!$post || !in_array($post->post_type, ['post', 'page'])) return;
        Logger_DB::insert(get_current_user_id(), "{$post->post_type}_deleted");
    }
}
