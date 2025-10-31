<?php
/* Template Name: Gửi Feedback */
get_header();

// Lấy bài viết (Posts) để hiển thị trong select box
$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 20,
    'post_status'    => 'publish',
);
$posts_query = new WP_Query($args);
?>

<div class="post-container" style="max-width: 800px; margin: 40px auto;">


    <hr>
    <h2>📝 Gửi Feedback cho bài viết</h2>

    <form id="feedback-form">
        <p>
            <label for="post_id">Chọn bài viết:</label><br>
            <select id="post_id" name="post_id" style="width:100%; padding:8px;">
                <option value="">-- Chọn bài viết --</option>

                <?php
                if ($posts_query->have_posts()) :
                    while ($posts_query->have_posts()) : $posts_query->the_post();
                ?>
                        <option value="<?php echo esc_attr(get_the_ID()); ?>">
                            <?php echo esc_html(get_the_title()); ?>
                        </option>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>

            </select>
        </p>
        <p>
            <label>Họ tên</label><br>
            <input type="text" name="name" required style="width:100%; padding:8px;">
        </p>
        <p>
            <label>Nội dung</label><br>
            <textarea name="message" rows="4" required style="width:100%; padding:8px;"></textarea>
        </p>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <p>
                <label>Đánh giá bài viết</label><br>
                <select name="rating" required>
                    <option value="5">⭐⭐⭐⭐⭐</option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="3">⭐⭐⭐</option>
                    <option value="2">⭐⭐</option>
                    <option value="1">⭐</option>
                </select>
            </p>
            <div id="average-rating">
                <label>Đánh giá trung bình bài viết</label><br>
                <span >Chưa có đánh giá trung bình</span>
            </div>
        </div>
        <button type="submit" class="button" style="padding: 10px 20px; background-color: #0073aa; color: white; border: none; border-radius: 4px; cursor: pointer;">Gửi Feedback</button>
    </form>

    <div id="feedback-result" style="margin-top:20px;"></div>
    <hr>
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
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    $("#feedback-result").html("⚠️ Có lỗi xảy ra: " + error);
                }
            });
        });

        function updateAverageRating(post_id) {
            if (!post_id) {
                $("#average-rating").html('<span >Chưa có đánh giá</span>');
                return;
            }

            $.ajax({
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                type: "POST",
                dataType: "json",
                data: {
                    action: "get_post_average_rating",
                    _ajax_nonce: "<?php echo wp_create_nonce('get_post_average_rating_nonce'); ?>",
                    post_id: post_id
                },
                success: function(res) {
                    if (res.success) {
                        $("#average-rating").html(res.data.html);
                    } else {
                        $("#average-rating").html('Chưa có đánh giá');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    $("#average-rating").html('⚠️ Lỗi khi lấy đánh giá');
                }
            });
        }

        // Khi select thay đổi
        $("#post_id").on("change", function() {
            var post_id = $(this).val();
            updateAverageRating(post_id);
        });


    });
</script>

<?php get_footer(); ?>