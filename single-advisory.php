<?php get_header(); ?> 
<!-- Breadcrumbs  -->
<?php get_template_part('parts/breadcrumbs'); ?>
<!-- End Breadcrumbs  -->
<div class="container mx-auto px-4">
    <section>
        <div class="header-gt my-10">
            <h3 class="text-4xl font-medium leading-14"> <?php esc_html(the_title()); ?>
            </h3>
        </div>
        <hr class="text-gray-300">
    </section>

    <section>
        <div class="flex justify-start items-center mt-5 gap-2.5">
            <?php
            $cat = get_the_category();
            $cat_name = $cat ? $cat[0]->name : 'Tin tức';
            ?>
            <button class="text-white font-semibold text-sm px-8 py-1.5 bg-[#0D4A9A] rounded-md"><?php echo esc_html($cat_name);; ?></button>
            <div class="w-1 h-1 bg-black rounded-full"></div>
            <p class="font-semibold text-base leading-4 text-black"><?php echo get_the_date('d.m.Y'); ?></p>
            <div class="w-1 h-1 bg-black rounded-full"></div>
            <p class="font-semibold text-base leading-4 text-black"><?php echo get_the_author() ?></p>
        </div>
    </section>

    <section>
        <div class="mt-10 space-y-3">
            <img class="w-full h-[777px]" src="<?php echo get_template_directory_uri(); ?>/assets/images/tu-van-detail-1.png" alt="tu-van-detail-1">
            <p class="font-normal text-[#3A3A3A] leading-6">
                Từ công nghệ lọc nước tiên tiến, vật liệu chống thấm bền bỉ đến các mẫu hồ bơi thông minh đang được
                ưa chuộng, tất cả đều được cập nhật và phân tích chi tiết. Ngoài ra, bài viết còn chia sẻ kinh
                nghiệm thực tế, mẹo bảo dưỡng và tối ưu chi phí giúp khách hàng hiểu rõ hơn trước khi đầu tư xây
                dựng hồ bơi. Đây là nguồn thông tin hữu ích dành cho những ai quan tâm và muốn theo dõi sự phát
                triển của ngành hồ bơi tại Việt Nam.
            </p>
        </div>
    </section>

    <section>
        <div class="mt-10 space-y-3">
            <h2 class="font-medium text-3xl">Thiết Kế Kiến Trúc Hồ Bơi</h2>
            <p class="font-normal text-[#3A3A3A] leading-6">
                Từ công nghệ lọc nước tiên tiến, vật liệu chống thấm bền bỉ đến các mẫu hồ bơi thông minh đang được
                ưa chuộng, tất cả đều được cập nhật và phân tích chi tiết. Ngoài ra, bài viết còn chia sẻ kinh
                nghiệm thực tế, mẹo bảo dưỡng và tối ưu chi phí giúp khách hàng hiểu rõ hơn trước khi đầu tư xây
                dựng hồ bơi. Đây là nguồn thông tin hữu ích dành cho những ai quan tâm và muốn theo dõi sự phát
                triển của ngành hồ bơi tại Việt Nam.
            </p>
            <img class="w-full h-[777px]" src="<?php echo get_template_directory_uri(); ?>/assets/images/tu-van-detail-1.png" alt="tu-van-detail-1">


            <h2 class="font-medium text-3xl mt-10">Kết Cấu & Thi Công Hồ Bơi</h2>
            <p class="font-normal text-[#3A3A3A] leading-6">
                Giai đoạn thi công được thực hiện bởi đội ngũ kỹ sư và công nhân lành nghề, tuân thủ nghiêm ngặt các
                tiêu chuẩn kỹ thuật. Từ khâu xử lý nền móng, chống thấm đến hoàn thiện bề mặt, tất cả đều được kiểm
                soát chặt chẽ để đảm bảo độ bền và an toàn tuyệt đối. Quy trình thi công khoa học giúp rút ngắn thời
                gian thực hiện nhưng vẫn đảm bảo chất lượng vượt trội cho từng công trình.
            </p>


            <h2 class="font-medium text-3xl mt-10">Hệ Thống Lọc & Tuần Hoàn Nước</h2>
            <p class="font-normal text-[#3A3A3A] leading-6">
                Hệ thống lọc nước là yếu tố cốt lõi giúp hồ bơi luôn sạch đẹp, an toàn cho sức khỏe người sử dụng.
                Chúng tôi ứng dụng các công nghệ lọc hiện đại như lọc cát, lọc cartridge hoặc lọc muối điện phân,
                đảm bảo nước trong xanh, không bị nhiễm khuẩn và dễ bảo trì. Thiết kế hệ thống tuần hoàn thông minh
                còn giúp tiết kiệm điện năng, nâng cao hiệu suất vận hành và kéo dài tuổi thọ thiết bị.
            </p>

            <h2 class="font-medium text-3xl mt-10">Vật Liệu Hoàn Thiện & Trang Trí</h2>
            <p class="font-normal text-[#3A3A3A] leading-6">
                Chúng tôi sử dụng đa dạng vật liệu cao cấp như gạch mosaic, đá granite, đá tự nhiên hay composite,
                tùy theo phong cách thiết kế và ngân sách của khách hàng. Việc lựa chọn đúng vật liệu không chỉ tạo
                nên vẻ đẹp tinh tế, mà còn giúp hồ bơi chống thấm tốt, dễ vệ sinh và bền màu theo thời gian. Mỗi chi
                tiết trang trí đều góp phần tôn lên giá trị thẩm mỹ và đẳng cấp cho công trình.
            </p>


            <h2 class="font-medium text-3xl mt-10">Bảo Dưỡng & Vận Hành Hồ Bơi</h2>
            <p class="font-normal text-[#3A3A3A] leading-6">
                Sau khi hoàn thành, công trình hồ bơi cần được bảo dưỡng định kỳ để duy trì chất lượng nước và độ
                bền thiết bị. Chúng tôi cung cấp dịch vụ bảo dưỡng chuyên nghiệp – bao gồm kiểm tra hệ thống lọc, vệ
                sinh hồ, cân bằng hóa chất và sửa chữa khi cần thiết. Dịch vụ hậu mãi tận tâm giúp khách hàng luôn
                yên tâm khi sử dụng, đảm bảo hồ bơi vận hành ổn định, sạch đẹp và an toàn trong suốt quá trình sử
                dụng.
            </p>

            <p class="font-normal text-[#3A3A3A] leading-6">
                Với sự phát triển mạnh mẽ của nhu cầu nghỉ dưỡng và không gian sống hiện đại, lĩnh vực thiết kế và
                thi công hồ bơi ngày càng khẳng định vai trò quan trọng trong kiến trúc và đời sống con người. Một
                hồ bơi không chỉ là nơi thư giãn, rèn luyện sức khỏe mà còn là điểm nhấn sang trọng, thể hiện phong
                cách và gu thẩm mỹ của chủ nhân. Nắm bắt xu hướng đó, công ty chúng tôi ra đời với sứ mệnh mang đến
                những công trình hồ bơi chất lượng cao, bền vững và mang tính thẩm mỹ vượt trội.
            </p>

            <p class="font-normal text-[#3A3A3A] leading-6">
                Chúng tôi không ngừng đầu tư vào công nghệ, nâng cao tay nghề đội ngũ kỹ sư, kiến trúc sư và thợ
                thi công nhằm đáp ứng mọi yêu cầu khắt khe nhất của khách hàng. Từ việc lên ý tưởng, thiết kế, chọn
                vật liệu, thi công cho đến vận hành và bảo dưỡng, mỗi giai đoạn đều được thực hiện chuyên nghiệp, tỉ
                mỉ và tận tâm. Với kinh nghiệm thực hiện hàng trăm dự án lớn nhỏ trên toàn quốc, chúng tôi tự hào
                mang đến giải pháp toàn diện – nơi công nghệ hiện đại kết hợp hài hòa với nghệ thuật kiến trúc, tạo
                nên không gian hồ bơi đẳng cấp, an toàn và bền đẹp theo thời gian.
            </p>
        </div>
    </section>



    <section class="py-16 bg-white">
        <h2 class="text-3xl font-bold  text-start mb-10 uppercase">
            Tin tức liên quan
        </h2>
        <!-- Slider -->
        <div class="relative max-w-7xl mx-auto ">
            <div class="swiper newsSwiper relative">
                <div class="swiper-wrapper">
                    <!-- Slide -->
                    <div class="swiper-slide h-[480px] ">
                        <div
                            class="bg-white rounded-xl border border-[#C9C9C9] h-full overflow-hidden hover:shadow-lg transition">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tin-tuc-4.png"
                                class="w-full h-[305px] object-cover p-3 rounded-3xl" />
                            <div class="p-2 space-y-3">
                                <div class="flex text-xs  justify-start items-center mb-2 gap-1">
                                    <span
                                        class="bg-[#0D4A9A] text-base cursor-pointer font-semibold leading-4 text-white px-7 py-2 rounded-sm">Tin
                                        tức</span>
                                    <div class="w-1 h-1 bg-black rounded-full mx-2"></div>
                                    <span class="font-semibold text-base leading-4 text-black">15.10.2025</span>
                                </div>
                                <h3 class="text-lg font-semibold text-black leading-6 mt-1">
                                    Top 17 hồ bơi TPHCM đẹp và sang chảnh nhất | Vườn An Nam
                                </h3>
                                <div class="flex justify-between">
                                    <p class="text-[15px] text-[#3A3A3A] font-medium leading-5">
                                        Đèn hồ bơi Halogen của Sagocomposite được thiết kế riêng cho các hồ bơi nổi.
                                    </p>
                                    <a href="#" class="flex items-center">
                                        <span
                                            class="border rounded-full w-10 h-10 mx-1 text-[#909090]    flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide h-[480px] ">
                        <div
                            class="bg-white rounded-xl border border-[#C9C9C9] h-full overflow-hidden hover:shadow-lg transition">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tin-tuc-4.png"
                                class="w-full h-[305px] object-cover p-3 rounded-3xl" />
                            <div class="p-2 space-y-3">
                                <div class="flex text-xs  justify-start items-center mb-2 gap-1">
                                    <span
                                        class="bg-[#0D4A9A] text-base cursor-pointer font-semibold leading-4 text-white px-7 py-2 rounded-sm">Tin
                                        tức</span>
                                    <div class="w-1 h-1 bg-black rounded-full mx-2"></div>
                                    <span class="font-semibold text-base leading-4 text-black">15.10.2025</span>
                                </div>
                                <h3 class="text-lg font-semibold text-black leading-6 mt-1">
                                    Top 17 hồ bơi TPHCM đẹp và sang chảnh nhất | Vườn An Nam
                                </h3>
                                <div class="flex justify-between">
                                    <p class="text-[15px] text-[#3A3A3A] font-medium leading-5">
                                        Đèn hồ bơi Halogen của Sagocomposite được thiết kế riêng cho các hồ bơi nổi.
                                    </p>
                                    <a href="#" class="flex items-center">
                                        <span
                                            class="border rounded-full w-10 h-10 mx-1 text-[#909090]    flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide h-[480px] ">
                        <div
                            class="bg-white rounded-xl border border-[#C9C9C9] h-full overflow-hidden hover:shadow-lg transition">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tin-tuc-4.png"
                                class="w-full h-[305px] object-cover p-3 rounded-3xl" />
                            <div class="p-2 space-y-3">
                                <div class="flex text-xs  justify-start items-center mb-2 gap-1">
                                    <span
                                        class="bg-[#0D4A9A] text-base cursor-pointer font-semibold leading-4 text-white px-7 py-2 rounded-sm">Tin
                                        tức</span>
                                    <div class="w-1 h-1 bg-black rounded-full mx-2"></div>
                                    <span class="font-semibold text-base leading-4 text-black">15.10.2025</span>
                                </div>
                                <h3 class="text-lg font-semibold text-black leading-6 mt-1">
                                    Top 17 hồ bơi TPHCM đẹp và sang chảnh nhất | Vườn An Nam
                                </h3>
                                <div class="flex justify-between">
                                    <p class="text-[15px] text-[#3A3A3A] font-medium leading-5">
                                        Đèn hồ bơi Halogen của Sagocomposite được thiết kế riêng cho các hồ bơi nổi.
                                    </p>
                                    <a href="#" class="flex items-center">
                                        <span
                                            class="border rounded-full w-10 h-10 mx-1 text-[#909090]    flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide h-[480px] ">
                        <div
                            class="bg-white rounded-xl border border-[#C9C9C9] h-full overflow-hidden hover:shadow-lg transition">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tin-tuc-4.png"
                                class="w-full h-[305px] object-cover p-3 rounded-3xl" />
                            <div class="p-2 space-y-3">
                                <div class="flex text-xs  justify-start items-center mb-2 gap-1">
                                    <span
                                        class="bg-[#0D4A9A] text-base cursor-pointer font-semibold leading-4 text-white px-7 py-2 rounded-sm">Tin
                                        tức</span>
                                    <div class="w-1 h-1 bg-black rounded-full mx-2"></div>
                                    <span class="font-semibold text-base leading-4 text-black">15.10.2025</span>
                                </div>
                                <h3 class="text-lg font-semibold text-black leading-6 mt-1">
                                    Top 17 hồ bơi TPHCM đẹp và sang chảnh nhất | Vườn An Nam
                                </h3>
                                <div class="flex justify-between">
                                    <p class="text-[15px] text-[#3A3A3A] font-medium leading-5">
                                        Đèn hồ bơi Halogen của Sagocomposite được thiết kế riêng cho các hồ bơi nổi.
                                    </p>
                                    <a href="#" class="flex items-center">
                                        <span
                                            class="border rounded-full w-10 h-10 mx-1 text-[#909090]    flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide h-[480px] ">
                        <div
                            class="bg-white rounded-xl border border-[#C9C9C9] h-full overflow-hidden hover:shadow-lg transition">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tin-tuc-4.png"
                                class="w-full h-[305px] object-cover p-3 rounded-3xl" />
                            <div class="p-2 space-y-3">
                                <div class="flex text-xs  justify-start items-center mb-2 gap-1">
                                    <span
                                        class="bg-[#0D4A9A] text-base cursor-pointer font-semibold leading-4 text-white px-7 py-2 rounded-sm">Tin
                                        tức</span>
                                    <div class="w-1 h-1 bg-black rounded-full mx-2"></div>
                                    <span class="font-semibold text-base leading-4 text-black">15.10.2025</span>
                                </div>
                                <h3 class="text-lg font-semibold text-black leading-6 mt-1">
                                    Top 17 hồ bơi TPHCM đẹp và sang chảnh nhất | Vườn An Nam
                                </h3>
                                <div class="flex justify-between">
                                    <p class="text-[15px] text-[#3A3A3A] font-medium leading-5">
                                        Đèn hồ bơi Halogen của Sagocomposite được thiết kế riêng cho các hồ bơi nổi.
                                    </p>
                                    <a href="#" class="flex items-center">
                                        <span
                                            class="border rounded-full w-10 h-10 mx-1 text-[#909090]    flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation nằm bên trong -->
                <div class="swiper-button-prev news-prev w-10! h-10! rounded-full! bg-white shadow!"></div>
                <div class="swiper-button-next news-next w-10! h-10! rounded-full! bg-white shadow!"></div>
            </div>
        </div>
    </section>


</div>

<?php get_footer(); ?>