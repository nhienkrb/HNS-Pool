<?php
require_once plugin_dir_path(__DIR__) . 'includes/Product_List_Table.php';
require_once plugin_dir_path(__DIR__) . 'includes/handle_syn_sheet.php';

$table = new Product_List_Table();
$tabs = get_tabs_sheet();
$selected_tab = isset($_REQUEST['tabs-sheet']) ? sanitize_text_field($_REQUEST['tabs-sheet']) : '';
if (isset($_POST['sync_toggle_auto']) && check_admin_referer('sync_action', 'sync_nonce')) {
    $opts = sync_product_get_options();

    $opts['auto_sync'] = isset($_POST['auto_sync_to_db']) ? 1 : 0;      // Sheet → DB
    $opts['auto_sync_to_sheet'] = isset($_POST['auto_sync_to_sheet']) ? 1 : 0; // DB → Sheet
    update_option('sync_options', $opts);
    $msg = 'Đã lưu cấu hình tự động đồng bộ.';
    echo '<div class="notice notice-success is-dismissible"><p>' . esc_html($msg) . '</p></div>';
}


if (isset($_POST['sync_run']) && check_admin_referer('sync_action', 'sync_nonce')) {
    $res = sync_products(); // Sheet → DB
    $message = sprintf(
        'Đồng bộ Google Sheets → Web: <b>%d thêm mới</b>, <b>%d cập nhật</b>, <b>%d bỏ qua</b>, <b>%d lỗi</b>.',
        $res['inserted'],
        $res['updated'],
        $res['skipped'],
        $res['failed']
    );
    echo '<div class="notice notice-success is-dismissible"><p>' . $message . '</p></div>';
}

$table->prepare_items();
?>
<style>
    .wp-list-table .column-price {
        text-align: right;
        width: 100px;
    }

    .wp-list-table .column-category {
        width: 150px;
    }

    pre {
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    /* Switch cron*/
    .switch {
        position: relative;
        display: inline-block;
        width: 56px;
        height: 30px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cfcfcf;
        transition: background-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        border-radius: 34px;
        box-shadow: inset 0 0 4px rgba(0, 0, 0, 0.2);
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 24px;
        width: 24px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        border-radius: 50%;
        transition: transform 0.3s ease-in-out, background-color 0.3s ease-in-out;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .switch input:checked+.slider {
        background-color: #2196f3;
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }

    .switch input:checked+.slider:before {
        transform: translateX(26px);
    }

    .switch:hover .slider {
        box-shadow: inset 0 0 8px rgba(33, 150, 243, 0.3);
    }

    .slider.round {
        border-radius: 34px;
    }

    #modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 999999;
    }

    #product-modal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000000;
        background: #fff;
        padding: 25px 30px;
        border-radius: 10px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
        width: 480px;
        max-width: 95%;
    }
</style>
<div class="wrap">
    <h1 class="wp-heading-inline">Danh sách sản phẩm đã đồng bộ</h1>
    <hr class="wp-header-end">

    <form method="post">
        <?php wp_nonce_field('sync_action', 'sync_nonce'); ?>

        <?php
        $opts = sync_product_get_options();
        $is_auto = !empty($opts['auto_sync']);
        ?>

        <div style="display:flex;align-items:center;gap:10px;margin-top:10px;">
            <label class="switch">
                <input type="checkbox" name="auto_sync_to_db" value="1" <?php checked(!empty($opts['auto_sync']), true); ?> />
                <span class="slider round"></span>
            </label>
            <span><b>Tự động Đồng bộ từ Google Sheets → DB (ưu tiên Sheet)</b></span>
        </div>

        <div style="display:flex;align-items:center;gap:10px;margin-top:10px; margin-bottom:10px;">
            <label class="switch">
                <input type="checkbox" name="auto_sync_to_sheet" value="1" <?php checked(!empty($opts['auto_sync_to_sheet']), true); ?> />
                <span class="slider round"></span>
            </label>
            <span><b>Tự động Đồng bộ từ DB → Google Sheets</b></span>
        </div>

        <?php submit_button(' Lưu thiết lập', 'secondary', 'sync_toggle_auto', false); ?>
</div>

<hr>

<div style="margin: 15px 0;">
    <select name="tabs-sheet">
        <option value="">-- Tất cả Tab Sheet --</option>
        <?php
        if (!empty($tabs)) {
            foreach ($tabs as $tab) {
                printf(
                    '<option value="%s" %s>%s</option>',
                    esc_attr($tab),
                    selected($selected_tab,$tab,false),
                    esc_html($tab)
                );  
            }
        }
        ?>
    </select>

    <?php submit_button('Đồng bộ ngay Sheets → DB', 'primary', 'sync_run', false); ?>
    <a href="<?php echo esc_url(add_query_arg(['page' => $_REQUEST['page']])); ?>" class="button">Làm mới</a>
</div>


<p><b>Google Sheet:</b>
    <code><?php
            echo esc_html($opts['sheet_id'] ?: 'Chưa cấu hình');
            ?></code>
</p>
<hr>
<input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']); ?>" />
<?php $table->display(); ?>
</form>

<!-- Overlay -->
<div id="modal-overlay" style="display:none;"></div>

<!-- Modal Popup -->
<div id="product-modal" style="display:none;">
    <h2 id="modal-title">Thêm sản phẩm</h2>
    <form id="product-form">
        <input type="hidden" name="id" id="product_id">

        <table class="form-table">
            <tr>
                <th><label for="external_id">External Id</label></th>
                <td><input type="text" id="external_id" name="external_id" required></td>
            </tr>
            <tr>
                <th><label for="name">Tên sản phẩm</label></th>
                <td><input type="text" id="name" name="name" required></td>
            </tr>
            <tr>
                <th><label for="category">Danh mục</label></th>
                <td><input type="text" id="category" name="category"></td>
            </tr>
            <tr>
                <th><label for="price">Giá</label></th>
                <td><input type="number" id="price" name="price" step="0.01"></td>
            </tr>
            <tr>
                <th><label for="description">Mô tả</label></th>
                <td><textarea id="description" name="description"></textarea></td>
            </tr>
            <tr>
                <th><label for="content">Nội dung</label></th>
                <td><textarea id="content" name="content"></textarea></td>
            </tr>
        </table>

        <p class="submit">
            <button type="submit" class="button button-primary">💾 Lưu</button>
            <button type="button" class="button close-modal">Đóng</button>
        </p>
    </form>
</div>


<?php
add_action('admin_footer', function () { ?>
    <script>
        jQuery(document).ready(function($) {

            function getSelectedTab() {
                return $("select[name='tabs-sheet']").val() || "";
            }

            //  Mở popup 
            function openModal(title, data = null) {
                $("#modal-title").text(title);
                $("#product-modal, #modal-overlay").fadeIn(200);

                if (data) {
                    $("input#product_id").val(data.id || "");
                    $("input#external_id").val(data.external_id || "");
                    $("input#name").val(data.name || "");
                    $("input#category").val(data.category || "");
                    $("input#price").val(data.price || "");
                    $("textarea#description").val(data.description || "");
                    $("#content").val(data.content || "");
                } else {
                    $("#product-form")[0].reset();
                    $("#product_id").val("");
                }
            }

            //  Đóng popup 
            function closeModal() {
                $("#product-modal, #modal-overlay").fadeOut(200);
            }

            //  Nút thêm mới 
            $("#btn-add-product").on("click", function() {
                openModal("Thêm sản phẩm mới");
            });

            //  Nút chỉnh sửa
            $(document).on("click", ".edit-product", function() {
                const productJson = $(this).attr("data-product");
                let product = {};
                try {
                    product = JSON.parse(productJson);
                } catch (e) {
                    console.warn("JSON parse lỗi:", e);
                }
                openModal("Chỉnh sửa sản phẩm", product);
            });

            //  Nút xóa  
            $(document).on("click", ".delete-product", function(e) {
                e.preventDefault();
                const button = $(this);
                const id = button.data("id");
                const currentTab = getSelectedTab();

                if (!currentTab) {
                    alert("Vui lòng chọn Tab Sheet trước khi xóa sản phẩm.");
                    return;
                }

                if (!confirm(" Bạn có chắc chắn muốn xóa sản phẩm này và đồng bộ Google Sheet?")) {
                    return;
                }
                button.prop("disabled", true).text(" Xóa...");
                $.ajax({
                    url: ajaxurl,
                    type: "POST",
                    dataType: "json",
                    data: {
                        action: "sync_delete_product",
                        id: id,
                        tab: currentTab,
                        _ajax_nonce: "<?php echo wp_create_nonce('sync_delete_nonce'); ?>"
                    },
                    success: function(res) {
                        if (res.success) {
                            // Xóa dòng khỏi bảng
                            button.closest("tr").fadeOut(300, function() {
                                $(this).remove();
                            });

                            $("<div class='notice notice-success inline'><p>" + res.data.message + "</p></div>")
                                .appendTo(".wrap")
                                .delay(3000)
                                .fadeOut(500, function() {
                                    $(this).remove();
                                });
                        } else {
                            alert((res.data?.message || "Lỗi khi xóa sản phẩm!"));
                        }
                    },
                    error: function() {
                        alert("Lỗi kết nối máy chủ!");
                    },
                    complete: function() {
                        button.prop("disabled", false).text("🗑️");
                    }
                });
            });

            $(".close-modal, #modal-overlay").on("click", closeModal);

            //  Gửi AJAX khi lưu sản phẩm 
            $("#product-form").on("submit", function(e) {
                e.preventDefault();

                const formData = $(this).serialize();
                const currentTab = getSelectedTab();

                if (!currentTab) {
                    alert("Vui lòng chọn Tab Sheet trước khi lưu sản phẩm.");
                    return;
                }

                $.ajax({
                    url: ajaxurl,
                    type: "POST",
                    dataType: "json",
                    data: {
                        action: "sync_save_product",
                        data: formData,
                        tab: currentTab,
                        _ajax_nonce: "<?php echo wp_create_nonce('sync_save_nonce'); ?>"
                    },
                    success: function(res) {
                        if (res.success) {

                            // Hiển thị thông báo thành công
                            $("<div class='notice notice-success inline'><p>" + res.data.message + "</p></div>")
                                .appendTo(".wrap")
                                .delay(2000)
                                .fadeOut(500, function() {
                                    $(this).remove();
                                });
                            location.reload();
                            closeModal();
                        } else {
                            alert(+(res.data?.message || "Lỗi không xác định"));
                        }
                    },
                    error: function(err) {
                        console.error(err);
                        alert("Lỗi kết nối máy chủ!");
                    }
                });
            });
        });
    </script>
<?php });
