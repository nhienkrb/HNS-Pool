<?php


if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH  . "wp-admin/includes/class-wp-list-table.php");
}

class List_table_feedback extends WP_List_Table
{

    private $table_data;

    public function __construct()
    {
        parent::__construct([
            'singular' => 'Feedback',
            'plural'   => 'Feedbacks',
            'ajax'     => false
        ]);
    }

    function get_columns()
    {
        $columns = array(
            'cb'  => '<input type="checkbox" />',
            'id' => 'ID',
            'name' => 'Tên',
            'message' => 'Bình Luận',
            'rating' => 'Đánh giá',
            'status'    => 'Trạng thái',
            'created_at' => 'Ngày đánh giá',
            'actions'    => 'Hành động'

        );

        return $columns;
    }


    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
                return $item['id'];

            case 'name':
                return esc_html($item['name']);

            case 'message':
                $message = wp_trim_words(strip_tags($item['message']), 15, '...');
                return esc_html($message);

            case 'rating':
                $stars = intval($item['rating']);
                $output = str_repeat('⭐', $stars) . str_repeat('☆', 5 - $stars);
                return sprintf('<span style="color:#f5b301;">%s</span>', $output);

            case 'created_at':
                $date = date_i18n('d/m/Y H:i', strtotime($item['created_at']));
                return esc_html($date);
            case 'status':
                return $item['status'] == 1 ? '<span style="color:green;">Đã duyệt</span>' : '<span style="color:red;">Chưa duyệt</span>';
            case 'actions': // 👈 xử lý riêng cho cột này
                $approve_url = admin_url('admin-ajax.php?action=approve_feedback&id=' . $item['id']);
                $delete_url  = admin_url('admin-ajax.php?action=delete_feedback&id=' . $item['id']);
                $edit_url    = admin_url('admin.php?page=edit-feedback&id=' . $item['id']);

                return sprintf(
                '<a href="%1$s" class="button button-small approve-feedback" data-id="%4$d">Duyệt</a> 
                 <a href="%2$s" class="button button-small">Sửa</a> 
                 <a href="%3$s" class="button button-small delete-feedback" data-id="%4$d">Xoá</a>',
                    esc_url($approve_url),
                    esc_url($edit_url),
                    esc_url($delete_url),
                    $item['id']
                );
            default:
                return print_r($item, true);
        }
    }

    public function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            $this->_args['singular'],
            $item['id'] // Sử dụng khóa chính (ID) của bảng
        );
    }

    protected function get_sortable_columns()
    {
        $sort_table_columns = array(
            'id'           => array('id', false),
            'name'         => array('name', false),
            'rating'       => array('rating', false),
            'created_at'   => array('created_at', true)
        );
        return $sort_table_columns;
    }

    function usort_reorder($a, $b)
    {
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'ID';

        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';

        $result = strcmp($a[$orderby], $b[$orderby]);

        return ($order === 'asc') ? $result : -$result;
    }

    public function extra_tablenav($which)
    {
        if ($which == "top") {
            $rating = isset($_REQUEST['rating_filter']) ? intval($_REQUEST['rating_filter']) : '';
?>
            <div class="alignleft actions">
                <!-- Bộ lọc rating -->
                <select name="rating_filter">
                    <option value="">-- Tất cả đánh giá --</option>
                    <option value="1" <?php selected($rating, '1'); ?>>⭐</option>
                    <option value="2" <?php selected($rating, '2'); ?>>⭐⭐</option>
                    <option value="3" <?php selected($rating, '3'); ?>>⭐⭐⭐</option>
                    <option value="4" <?php selected($rating, '4'); ?>>⭐⭐⭐⭐</option>
                    <option value="5" <?php selected($rating, '5'); ?>>⭐⭐⭐⭐⭐</option>
                </select>
                <?php submit_button('Lọc', '', 'filter_action', false); ?>
            </div>
<?php
        }
    }



    public function prepare_items()
    {
        $search = isset($_POST['s']) ? sanitize_text_field($_POST['s']) : '';
        $rating = isset($_REQUEST['rating_filter']) ? intval($_REQUEST['rating_filter']) : '';

        if (!empty($search)) {
            $this->table_data = $this->get_table_data($search);
        } elseif (!empty($rating)) {
            $this->table_data = $this->get_table_data_filter($rating);
        } else {
            $this->table_data = $this->get_table_data();
        }

        //data
        $columns = $this->get_columns();
        $hidden =  array();

        $sortable = $this->get_sortable_columns();
        $primary  = 'name';
        $this->_column_headers = array($columns, $hidden, $sortable, $primary);
        usort($this->table_data, array(&$this, 'usort_reorder'));

        /* pagination */
        $per_page = $this->get_items_per_page('elements_per_page', 2);
        $current_page = $this->get_pagenum();
        $total_items = count($this->table_data);

        $this->table_data = array_slice($this->table_data, (($current_page - 1) * $per_page), $per_page);

        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => ceil($total_items / $per_page)
        ));

        $this->items = $this->table_data;
    }

    private function get_table_data($search = '')
    {
        global $wpdb;

        $table = 'wp_user_feedbacks';

        if (!empty($search)) {
            return $wpdb->get_results(
                "SELECT * from {$table} WHERE name Like '%{$search}%' OR rating Like '%{$search}%' OR created_at Like '%{$search}%'",
                ARRAY_A
            );
        } else {
            return $wpdb->get_results(
                "SELECT * from {$table} ORDER BY created_at ASC",
                ARRAY_A
            );
        }
    }

    private function get_table_data_filter($rating = '')
    {
        global $wpdb;
        $table = 'wp_user_feedbacks';

        $sql = "SELECT * FROM {$table} WHERE 1=1";

        if (!empty($rating)) {
            $sql .= $wpdb->prepare(" AND rating = %d ORDER BY created_at DESC", $rating);
        }
        return $wpdb->get_results($sql, ARRAY_A);
    }
};
