<?php
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'admin/includes/class-wp-list-table.php');
}

class Tracking_List_Table extends WP_List_Table
{

    private $table_data;


    public function __construct()
    {
        parent::__construct([
            'singular' => 'log_entry',
            'plural'   => 'log_entries',
            'ajax'     => false
        ]);
    }


    function get_columns()
    {
        $columns = array(
            'cb'            => '<input type="checkbox" />',
            'id'          => "ID",
            'name'         => "Tên",
            'email'   => "Email",
            'role'        => "Vai trò",
            'action_name'        => "Hành động gần đây",
            'date' => "Thời gian"
        );
        return $columns;
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
            case 'name':
            case 'email':
            case 'role':
            case 'action_name':
            case 'date':
                return esc_html($item[$column_name]);
            default:
                print_r($item, true);
        }
    }

    public function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            $this->_args['singular'],
            $item['id']
        );
    }


    protected function get_sortable_columns()
    {
        $sort_table_columns = array(
            'id' => array('id', false),
            'name' => array('name', false),
            'email' => array('email', false),
            'role' => array('role', false),
            'action_name' => array('action_name', false),
            'date' => array('date', false)
        );
        return $sort_table_columns;
    }

    function usort_reorder($a, $b)
    {
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'id';

        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';

        $result = strcmp($a[$orderby], $b[$orderby]);

        return ($order === 'asc') ? $result : -$result;
    }

    public function extra_tablenav($which)
    {
        if ($which == "top") {

            $roles = $this->getRole();
            $actions = $this->getActionName();
            $selected_role = isset($_REQUEST['role_filter']) ? sanitize_text_field($_REQUEST['role_filter']) : '';
            $selected_action = isset($_REQUEST['action_filter']) ? sanitize_text_field($_REQUEST['action_filter']) : '';
?>
            <div class="alignleft actions">
                <!-- Bộ lọc vai trò -->
                <select name="role_filter">
                    <option value="">-- Tất cả vai trò --</option>
                    <?php
                    if (!empty($roles)) {
                        foreach ($roles as $role) {
                            $role_label = ucfirst(esc_html($role));
                            $is_selected = selected($selected_role, $role, false);
                            printf(
                                '<option value="%s" %s>%s</option>',
                                esc_attr($role),
                                $is_selected,
                                $role_label
                            );
                        }
                    }
                    ?>
                </select>

                <!-- Bộ lọc hành động -->
                <select name="action_filter">
                    <option value="">-- Tất cả hành động --</option>
                    <?php
                    if (!empty($actions)) {
                        foreach ($actions as $action) {
                            $action_label = ucfirst(esc_html($action));
                            $is_selected = selected($selected_action, $action, false);
                            printf(
                                '<option value="%1$s" %2$s>%1$s</option>',
                                esc_attr($action_label),
                                $is_selected,
                                $action_label
                            );
                        }
                    }
                    ?>
                </select>

                <?php submit_button('Lọc', '', 'filter_action', false); ?>

                <button type="submit" name="delete_all_action" class="button button-primary "
                    onclick="return confirm('Bạn có chắc muốn xóa TẤT CẢ log không? Hành động này không thể hoàn tác!');">
                Xóa tất cả
                </button>
                
            </div>
<?php
        }
    }



    public function prepare_items()
    {
        $this->removeAllLog();
        // Search
        $this->table_data = $this->get_table_data();
        //data
        $columns = $this->get_columns();
        $hidden =  array();

        $sortable = $this->get_sortable_columns();
        $primary  = 'name';
        $this->_column_headers = array($columns, $hidden, $sortable, $primary);
        usort($this->table_data, array(&$this, 'usort_reorder'));

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


    private function get_table_data()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'user_action_logger';

        $where = [];
        $params = [];

        if (!empty($_REQUEST['role_filter'])) {
            $where[] = 'role = %s';
            $params[] = sanitize_text_field($_REQUEST['role_filter']);
        }

        if (!empty($_REQUEST['action_filter'])) {
            $where[] = 'action_name = %s';
            $params[] = sanitize_text_field($_REQUEST['action_filter']);
        }

        $where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $query = $wpdb->prepare("SELECT * FROM {$table} {$where_sql} ORDER BY id DESC", $params);
        return $wpdb->get_results($query, ARRAY_A);
    }

    private function getRole()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'user_action_logger';
        return $wpdb->get_col("SELECT DISTINCT role FROM {$table} ORDER BY role ASC");
    }

    private function getActionName()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'user_action_logger';
        return $wpdb->get_col("SELECT DISTINCT action_name FROM {$table} ORDER BY action_name ASC");
    }

    private function removeAllLog()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'user_action_logger';
        if (isset($_REQUEST['delete_all_action'])) {
            $wpdb->query("TRUNCATE TABLE {$table}");
            echo '<div class="updated notice"><p><strong>Đã xóa toàn bộ log!</strong></p></div>';
        }
    }
}
