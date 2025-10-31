jQuery(document).ready(function ($) {
  let capturedImage = ""; // Lưu trữ dữ liệu ảnh Base64
  // Khởi tạo Signature Pad
  const canvas = document.getElementById("signature-pad");
  const signaturePad = new SignaturePad(canvas);
  const $select = $("#member-id");

  // Hàm  xóa ảnh, xóa trạng thái và khôi phục #BIB-box về ban đầu
  function resetCameraState() {
    capturedImage = "";

    // Khôi phục icon mặc định
    const defaultIcon = `<span class="dashicons dashicons-camera icon-check-in"></span>`;
    $("#BIB-box")
      .html(defaultIcon)
      .removeClass("has-image-captured")
      .css({ border: "", padding: "" });

    // Xóa nút Sửa/Chụp Lại
    $("#edit-capture-wrapper").remove();
  }

  // --- HÀM MODAL VÀ WEBCAM ---
  function openCameraModal() {
    $("#modal-title").text("CAMERA");
    $("#member-modal, #modal-overlay").fadeIn(200);

    Webcam.set({
      width: 320,
      height: 240,
      image_format: "jpeg",
      jpeg_quality: 90,
    });

    // Kích hoạt webcam
    Webcam.attach("#my_camera");
  }

  function closeModal() {
    $("#member-modal, #modal-overlay").fadeOut(200);
    Webcam.reset(); // Tắt luồng camera
  }

  //  SỰ KIỆN Clear CHỮ KÝ ---
  $("#clear-signature").click(function () {
    signaturePad.clear();
  });

  //  Chỉ mở khi chưa có ảnh
  $("#BIB-box").on("click", function () {
    if (!$(this).hasClass("has-image-captured")) {
      openCameraModal();
    }
  });

  //  Đóng Modal
  $(".close-modal, #modal-overlay").on("click", function () {
    closeModal();
  });

  $("#capture-btn")
    .off("click")
    .on("click", function () {
      Webcam.snap(function (data_uri) {
        capturedImage = data_uri;
        closeModal();
        const imageHtml = `<img src="${data_uri}" style="widtsh:100%; height:100%; object-fit:cover; border-radius: 5px;">`;
        $("#BIB-box").html(imageHtml);

        $("#BIB-box").addClass("has-image-captured");

        const editButtonHtml = `
                <div id="edit-capture-wrapper" style="text-align: center; margin-top: 10px;">
                    <button type="button" id="edit-capture-btn" 
                        class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-1 px-3 rounded-lg shadow-md transition duration-150">
                        ✏️ Sửa / Chụp Lại
                    </button>
                </div>`;

        $("#BIB-box").closest(".wrap-box").after(editButtonHtml);

        $("#edit-capture-btn")
          .off("click")
          .on("click", function () {
            resetCameraState();
            openCameraModal();
          });
      });
    });

  function getMemberIdFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get("member_id");
  }
  // Khi load trang, nếu có member_id trong URL thì xử lý luôn
  const memberIdFromURL = getMemberIdFromURL();

  if (memberIdFromURL) {
    checkMemberCheckinStatus(memberIdFromURL);
  }

  // Hàm kiểm tra tình trạng check-in
  function checkMemberCheckinStatus(memberId) {
    $.ajax({
      url: myAjax.ajaxurl,
      type: "POST",
      data: {
        action: "get_member_detail_checkin",
        member_id: memberId,
      },
      success: function (response) {
        if (response.success) {
          const { bib_photo, signature_data } = response.data;

          // Lưu tạm vào biến global để nếu memeber không sửa, ta gửi lại
          window.originalBIB = bib_photo || null;
          window.originalSignature = signature_data || null;

          // --- Nếu đã check-in ---
          if (bib_photo || signature_data) {
            if (bib_photo) {
              capturedImage = bib_photo; // Gán luôn ảnh cũ
              $("#BIB-box")
                .html(
                  `<img src="${bib_photo}" style="width:100%; height:100%; object-fit:cover;">`
                )
                .addClass("has-image-captured");

              const editButtonHtml = `
              <div id="edit-capture-wrapper" style="text-align: center; margin-top: 10px;">
                  <button type="button" id="edit-capture-btn" 
                      class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-1 px-3 rounded-lg shadow-md transition duration-150">
                      ✏️ Sửa / Chụp Lại
                  </button>
              </div>`;
              $("#BIB-box").closest(".wrap-box").after(editButtonHtml);

              $("#edit-capture-btn")
                .off("click")
                .on("click", function () {
                  resetCameraState();
                  openCameraModal();
                });
            }

            if (signature_data) {
              const sigImg = new Image();
              sigImg.onload = function () {
                const ctx = canvas.getContext("2d");
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(sigImg, 0, 0, canvas.width, canvas.height);
              };
              sigImg.src = signature_data;
            }

            $("#submit-checkin")
              .prop("disabled", false)
              .text("HOÀN TẤT CHECK-IN");
          } else {
            // --- Chưa check-in ---
            resetCameraState();
            signaturePad.clear();
            $("#submit-checkin")
              .prop("disabled", false)
              .text("HOÀN TẤT CHECK-IN");
          }
        } else {
          console.warn("Không tìm thấy thông tin member:", response.data);
        }
      },
      error: function (xhr) {
        console.error("Lỗi kiểm tra check-in:", xhr.responseText);
      },
    });
  }

  //handle submit save BIB & Signature
  $("#submit-checkin").click(function () {
    // Nếu người dùng chưa chụp lại thì dùng ảnh cũ
    const finalImage = capturedImage || window.originalBIB;

    // Nếu người dùng chưa ký lại thì lấy lại ảnh ký cũ
    const finalSignature = signaturePad.isEmpty()
      ? window.originalSignature
      : signaturePad.toDataURL();

    if (!finalImage) {
      alert("Vui lòng chụp hoặc giữ lại ảnh BIB.");
      return;
    }

    if (!finalSignature) {
      alert("Vui lòng ký tên hoặc giữ lại chữ ký cũ.");
      return;
    }

    const checkinData = {
      action: "handle_checkin_data",
      image: finalImage,
      signature: finalSignature,
      member_id: memberIdFromURL,
    };

    console.log("Dữ liệu Check-in gửi đi:", checkinData);

    $.ajax({
      url: myAjax.ajaxurl,
      type: "POST",
      data: checkinData,
      beforeSend: function () {
        $("#submit-checkin").text("Đang xử lý...").prop("disabled", true);
      },
      success: function (response) {
        if (response.success) {
          alert("Check-in thành công!");
           window.location.href = myAjax.home_url;
        } else {
          alert("Lỗi Check-in: " + response.data);
        }
      },
      error: function (xhr) {
        alert("Lỗi kết nối server hoặc lỗi PHP không mong muốn.");
        console.error(xhr.responseText);
      },
      complete: function () {
        $("#submit-checkin").text("HOÀN TẤT CHECK-IN").prop("disabled", false);
      },
    });
  });
});
