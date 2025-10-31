<?php
/* Template Name: Gửi Feedback */
get_header();
?>

<div class="feedback-container" style="max-width: 600px; margin: 50px auto;">
    <h2>📝 Gửi Feedback của bạn</h2>
    <form id="feedback-form">
        <p>
            <label>Họ tên</label><br>
            <input type="text" name="name" required style="width:100%; padding:8px;">
        </p>
        <p>
            <label>Nội dung</label><br>
            <textarea name="message" rows="4" required style="width:100%; padding:8px;"></textarea>
        </p>
        <p>
            <label>Đánh giá</label><br>
            <select name="rating" required>
                <option value="5">⭐⭐⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="2">⭐⭐</option>
                <option value="1">⭐</option>
            </select>
        </p>
        <button type="submit" class="button">Gửi Feedback</button>
    </form>

    <div id="feedback-result" style="margin-top:20px;"></div>

    <hr>
    <h3>💬 Feedback mới nhất</h3>
    <div id="feedback-list">
        <?php
        global $wpdb;
        $rows = $wpdb->get_results("SELECT * FROM wp_user_feedbacks WHERE status='1' ORDER BY created_at DESC LIMIT 5");
        if ($rows) {
            foreach ($rows as $row) {
                echo '<div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">';
                echo '<strong>' . esc_html($row->name) . '</strong> - ' . str_repeat('⭐', intval($row->rating)) . '<br>';
                echo '<p>' . esc_html($row->message) . '</p>';
                echo '<small>' . esc_html($row->created_at) . '</small>';
                echo '</div>';
            }
        } else {
            echo '<p>Chưa có feedback nào.</p>';
        }
        ?>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    $("#feedback-form").on("submit", function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            type: "POST",
            dataType: "json",
            data: formData + "&action=submit_feedback&_ajax_nonce=<?php echo wp_create_nonce('submit_feedback_nonce'); ?>",
            beforeSend: function() {
                $("#feedback-result").html("⏳ Đang gửi...");
            },
            success: function(res) {
                if (res.success) {
                    $("#feedback-result").html("✅ Cảm ơn bạn đã gửi feedback!");
                    $("#feedback-form")[0].reset();
                } else {
                    $("#feedback-result").html("❌ " + res.data.message);
                }
            },
            error: function() {
                $("#feedback-result").html("⚠️ Có lỗi xảy ra, vui lòng thử lại.");
            }
        });
    });
});
</script>

<?php get_footer(); ?>
