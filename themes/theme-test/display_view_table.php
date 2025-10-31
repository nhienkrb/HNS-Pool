
<?php
/* Template Name: Checkin */
get_header();
?>
<div class="checkin-form">
    <?php
    if (isset($_GET['member_id'])) {
        $member_id = intval($_GET['member_id']);
        echo "<h2>Check-in cho Member ID: $member_id</h2>";
        // Form checkin ở đây
    } else {
        echo "<h2>Không có thành viên nào được chọn.</h2>";
    }
    ?>
    <label for="bib">BIB <span>*</span></label>
    <div class="bib-input">
        <input type="text" id="bib" placeholder="Nhập BIB..." />
        <button class="map-btn">
            <i class="bi bi-qr-code"></i> Map BIB
        </button>
    </div>

    <label>Chụp hình BIB <span>*</span></label>
    <div class="wrap-box">
        <div id="BIB-box" class="upload-box">
            <span class="dashicons dashicons-camera icon-check-in"></span>
        </div>
    </div>
    <label for="note">Ghi chú</label>
    <input type="text" id="note" placeholder="Nhập ghi chú..." />

    <label>Ký tên <span>*</span></label>
    <div class="wrap-box">
        <canvas id="signature-pad" width="400" height="200" style="border:1px solid #ccc;"></canvas><br>
        <button type="button" id="clear-signature" style="cursor: pointer;margin: 10px; padding: 5px 10px; background-color: #f44336; color: white; border: none; border-radius: 5px;">
            Xóa Chữ Ký
        </button>
    </div>
    <button type="button" id="submit-checkin" style="margin-top: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; font-size: 1.2em; border: none; border-radius: 5px; width: 100%; cursor: pointer;">
        HOÀN TẤT CHECK-IN
    </button>
</div>

<!-- Overlay -->
<div id="modal-overlay" style="display:none;"></div>
<!-- Popup Form -->
<div id="member-modal" style="display:none;">
    <h2 id="modal-title">CAMERA</h2>
    <form id="member-form">
        <p class="submit">

            <label>Chụp hình BIB*</label>
        <div id="camera-wrapper">
            <div id="my_camera"></div>
            <button type="button" id="capture-btn">📸 Chụp</button>
            <img id="preview" style="display:none; width:200px;">
        </div>
    </form>
</div>
<?php get_footer(); ?>