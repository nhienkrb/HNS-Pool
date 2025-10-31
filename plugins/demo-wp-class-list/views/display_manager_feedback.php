<?php
require_once plugin_dir_path(__DIR__) . 'includes/list_table_feedback.php';
$user_feedback_table = new List_table_feedback();
$user_feedback_table->prepare_items();; ?>

<div class="wrap">
    <h1>Quản Lý Feedback</h1>
    <!-- Nút thêm mới -->
    <div style="margin-top: 10px;">
        <button id="export-excel-feedback" class="button button-primary">📤 Export Excel</button>
    </div>
    <form method="post" autocomplete="off" id="member-list-form">
        <?php $user_feedback_table->search_box('Tìm kiếm người dùng', 'user_feedback_search_id'); ?>
        <?php $user_feedback_table->display(); ?>
    </form>
</div>
<?php $nonce = wp_create_nonce('feedback_actions_nonce'); ?>

<script type="text/javascript">
    jQuery(document).ready(function($) {
    const nonce = '<?php echo $nonce; ?>';
        $("#export-excel-feedback").on("click", function(e) {
            e.preventDefault();
            let url = ajaxurl + "?action=export_feedback_excel&_ajax_nonce_excel_feedback=<?php echo wp_create_nonce('exportExcel_feedback_nonce'); ?>";
            window.location.href = url;
        });
        //Duyet
        $(document).on('click', '.approve-feedback', function(e) {
            e.preventDefault();
            const id = $(this).data('id');

            if (!confirm('Xác nhận duyệt feedback ID' + id + '?')) return;

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'approve_feedback',
                    id: id,
                    _ajax_nonce: nonce
                },
                success: function(res) {
                    if (res.success) {
                        alert(res.data.message);
                        location.reload(); // reload lại table
                    } else {
                        alert(res.data.message);
                    }
                },
                error: function(e) {
                    alert('Lỗi kết nối AJAX.', e);
                }
            });
        });

        //Xóa
        $(document).on('click', '.delete-feedback', function(e) {
            e.preventDefault();
            const id = $(this).data('id');

            if (!confirm('Bạn có chắc muốn xoá feedback #' + id + '?')) return;

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'delete_feedback',
                    id: id,
                    _ajax_nonce: nonce
                },
                success: function(res) {
                    if (res.success) {
                        alert(res.data.message);
                        location.reload();
                    } else {
                        alert(res.data.message);
                    }
                },
                error: function() {
                    alert('Lỗi kết nối AJAX.');
                }
            });
        });
    });
</script>