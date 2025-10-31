<?php
require_once plugin_dir_path(__DIR__) . 'includes/My_List_Table.php';
require_once plugin_dir_path(__DIR__) . 'includes/ajax-handler.php';

$member_list_table = new My_List_Table();
$member_list_table->prepare_items();
?>

<style>
    #member-modal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 100002;
        /* cao hơn overlay */
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
    }

    #modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 100001;
        /* thấp hơn modal */
    }
</style>

<div class="wrap">
    <h1>Quản Lý Thành Viên Shop</h1>
    <!-- Nút thêm mới -->
    <button id="btn-add-member" class="button button-primary " style="margin-top: 10px;">➕ Thêm thành viên</button>
    <div style="margin-top: 10px;">
        <button id="export-excel" class="button button-primary">📤 Export Excel</button>
    </div>
    <form method="post" autocomplete="off" id="member-list-form">
        <?php $member_list_table->search_box('Tìm kiếm Thành viên', 'member_search_id'); ?>
        <?php $member_list_table->display(); ?>
    </form>
</div>


<!-- Overlay -->
<div id="modal-overlay" style="display:none;"></div>

<!-- Popup Form -->
<div id="member-modal" style="display:none;">
    <h2 id="modal-title">Thêm Thành Viên</h2>
    <form id="member-form">
        <input type="hidden" name="ID" id="member_id">

        <table class="form-table">
            <tr>
                <th><label for="name">Tên</label></th>
                <td><input type="text" id="name" name="name" class="regular-text" required /></td>
            </tr>
            <tr>
                <th><label for="sdt">SĐT</label></th>
                <td><input type="text" id="sdt" name="sdt" class="regular-text" required /></td>
            </tr>
            <tr>
                <th><label for="dia_chi">Địa chỉ</label></th>
                <td><input type="text" id="dia_chi" name="dia_chi" class="regular-text" required /></td>
            </tr>
            <tr>
                <th><label for="gioi_tinh">Giới tính</label></th>
                <td>
                    <select id="gioi_tinh" name="gioi_tinh">
                        <option value="1">Nam</option>
                        <option value="0">Nữ</option>
                    </select>
                </td>
            </tr>
        </table>

        <p class="submit">
            <button type="submit" class="button button-primary">💾 Lưu</button>
            <button type="button" class="button close-modal">Đóng</button>
        </p>
    </form>
</div>


<?php
add_action('admin_footer', function () {
?>
    <script>
        jQuery(document).ready(function($) {
            function openModal(title, data = null) {
                $("#modal-title").text(title);
                $("#member-modal, #modal-overlay").fadeIn(200);
                if (data) {
                    $("input#member_id").val(data.ID);
                    $("input#name").val(data.name);
                    $("input#sdt").val(data.sdt);
                    $("input#dia_chi").val(data.dia_chi);
                    $("input#gioi_tinh").val(data.gioi_tinh);
                } else {
                    $("#member-form")[0].reset();
                    $("input#member_id").val('');
                }
            }

            function closeModal() {
                $("#member-modal, #modal-overlay").fadeOut(200);
            }

            // Thêm mới
            $("#btn-add-member").on("click", function() {
                openModal("Thêm Thành Viên");
            });

            // Đóng popup
            $(".close-modal, #modal-overlay").on("click", function() {
                closeModal();
            });

            // Sửa
            $(document).on("click", ".edit-member", function() {
                let member = $(this).data("member");
                openModal("Sửa Thành Viên", member);
            });

            // Xóa
            $(document).on("click", ".delete-member", function() {
                if (!confirm("Bạn có chắc chắn muốn xóa thành viên này?")) return;

                let id = $(this).data("id");

                $.post(ajaxurl, {
                    action: "delete_member",
                    id: id,
                    _ajax_nonce: "<?php echo wp_create_nonce('member_nonce'); ?>"
                }, function(response) {
                    alert(response.data);
                    location.reload();
                });
            });

            $("#export-excel").on("click", function(e) {
                e.preventDefault();
                let url = ajaxurl + "?action=export_members_excel&_ajax_nonce=<?php echo wp_create_nonce('member_nonce'); ?>";
                window.location.href = url;
            });

            // Submit form (add/edit)
            $("#member-form").on("submit", function(e) {
                e.preventDefault();

                try {
                    $.post(ajaxurl, {
                            action: "save_member",
                            data: $(this).serialize(),
                            _ajax_nonce: "<?php echo wp_create_nonce('member_nonce'); ?>"
                        })
                        .done(function(response) {
                            if (response.success) {
                                alert(response.data);
                            } else {
                                alert("❌ Lỗi xử lý: " + response.data);
                                console.error(response.data);
                            }
                            closeModal();
                            location.reload();
                        })
                        .fail(function(xhr, status, error) {
                            console.error("AJAX Error:", error, xhr.responseText);
                            alert("❌ AJAX lỗi: " + error);
                        });
                } catch (error) {
                    console.error("Try-catch lỗi:", error);
                    alert("❌ Lỗi không mong muốn trong AJAX!");
                }
            });

        });
    </script>
<?php
});
?>