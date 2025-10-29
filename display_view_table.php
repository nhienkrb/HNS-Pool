<?php get_header(); ?>
<!-- Bảng hiển thị danh sách thành viên check-in -->
<div class="box-table" style="width: 80%; margin: 0 auto; text-align: center;">
    <h3 class="">Danh sách Check-in gần đây</h3>


    <table class="" id="members-table" style="width: 100%">
        <thead class="">
            <tr>
                <th class=" uppercase ">ID</th>
                <th class=" uppercase ">Name</th>
                <th class=" uppercase ">SĐT</th>
                <th class=" uppercase ">Địa Chỉ</th>
                <th class=" uppercase ">Giới Tính</th>
                <th class=" uppercase ">BIB Ảnh</th>
                <th class=" uppercase ">Chữ Ký</th>
                <th class=" uppercase ">Action</th>
            </tr>
        </thead>
        <tbody class="" id="members-table-body">
        </tbody>
    </table>
</div>

<script>
    jQuery(document).ready(function($) {
        const $button = $(this);
        const $tbody = $("#members-table-body");
        $.ajax({
            url: myAjax.ajaxurl,
            type: "POST",
            data: {
                action: "get_checkin_members", // Action đã định nghĩa trong PHP
            },
            success: function(response) {
                if (response.success && response.data.length > 0) {
                    // Xóa nội dung cũ
                    $tbody.empty();
                    // Duyệt qua dữ liệu và tạo hàng
                    $.each(response.data, function(index, member) {
                        // Tạo thẻ <img> cho Ảnh BIB (sử dụng Base64 trực tiếp)
                        const bibPhotoHtml = member.bib_photo ?
                            `<img src="${member.bib_photo}" style="height: 100px;">` :
                            "Không có";

                        // Tạo thẻ <img> cho Chữ Ký (sử dụng Base64 trực tiếp)
                        const signatureHtml = member.signature_data ?
                            `<img src="${member.signature_data}" style="height: 100px;" >` :
                            "Không có";

                        const row = `
                        <tr class="hover:bg-gray-50">
                            <td class=" whitespace-nowrap">
                            ${member.ID}
                            
                            </td>
                             <td class=" whitespace-normal text-sm text-gray-500">
                               ${member.name || ""}
                            </td>
                            <td class=" whitespace-normal text-sm text-gray-500">
                               ${member.sdt || ""}
                            </td>
                             <td class=" whitespace-nowrap text-sm text-gray-500">
                                ${member.dia_chi}
                             </td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${member.gioi_tinh === 1 ? "Nam" : "Nữ"}
                             </td>   
                                
                            <td class=" whitespace-nowrap" >${bibPhotoHtml}</td>
                            <td class=" whitespace-nowrap" style="height: 30px;">${signatureHtml}</td>
                             <td class=" whitespace-nowrap" style="height: 30px;">  
                               <a href="<?php echo home_url(); ?>?member_id=${member.ID}" >Checkin</a>
                             </td>
                        </tr>
                    `;
                        $tbody.append(row);
                    });
                } else {
                    $tbody.html(
                        '<tr><td colspan="6" class="p-4 text-center text-red-500">Không tìm thấy dữ liệu Check-in.</td></tr>'
                    );
                }
            },
            error: function() {
                $tbody.html(
                    '<tr><td colspan="6" class="p-4 text-center text-red-700">Lỗi: Không thể kết nối đến máy chủ.</td></tr>'
                );
            },
        });
    });
</script>
<?php get_footer(); ?>