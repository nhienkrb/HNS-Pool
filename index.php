<?php get_header(); ?>
 ;?>
  <!-- Start Carousel -->
    <section>
        <div class="swiper mySwiper w-full  mx-auto  max-w-screen">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <img src="<?php echo get_template_directory_uri() ;?>/assets/images/banner.png" class="w-full h-[646px] object-cover" />
                </div>

                <div class="swiper-slide">
                    <img src="<?php echo get_template_directory_uri() ;?>/assets/images/banner.png" class="w-full h-[646px] object-cover" />
                </div>

                <div class="swiper-slide">
                    <img src="<?php echo get_template_directory_uri() ;?>/assets/images/banner.png" class="w-full h-[646px] object-cover" />
                </div>

            </div>

            <div class="max-w-screen-lg  ">
                <!-- Nút điều hướng -->
                <div class="swiper-button-next 
            border-solid border border-white rounded-full 
            w-10 h-10 flex justify-center items-center">
                </div>
                <div class="swiper-button-prev 
            border-solid border border-white rounded-full 
            w-10 h-10 flex justify-center items-center">
                </div>
            </div>
            <!-- Dấu chấm (pagination) -->
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!-- END Carousel -->

    <section class=" max-w-screen mx-auto py-16 bg-[url('<?php echo get_template_directory_uri() ;?>/assets/images/bg-hero.svg')]">
        <div class="container mx-auto">
            <div class="grid grid-cols-12 gap-8 items-center">

                <div class="col-span-12 lg:col-span-5 relative min-h-[500px] flex justify-center items-center">
                    <div
                        class="absolute w-[300px] h-[300px] bg-cover bg-center [clip-path:polygon(...)] z-10 top-[25%] left-[25%]">
                    </div>
                    <div
                        class="absolute w-[200px] h-[200px] bg-cover bg-center [clip-path:polygon(...)] z-20 top-0 left-0">
                    </div>
                    <div
                        class="absolute w-[350px] h-[350px] border-dashed border-2 border-blue-400 rotate-45 z-30 top-[20%] left-[20%]">
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-7 lg:pl-16">
                    <h2 class="text-3xl lg:text-4xl font-serif italic text-[#2077EA]">Giới thiệu</h2>
                    <h1 class="text-4xl lg:text-5xl font-extrabold mb-6 text-[#0D4A9A] leading-snug">
                        HÌNH THÀNH &amp; PHÁT TRIỂN HNS
                    </h1>

                    <p class="mb-4 text-[#3F3F3F] leading-relaxed">
                        Lần đầu tiên tôi xin thay mặt công ty TNHH dịch vụ công nghệ HNS gửi tới quý khách hàng lời chào
                        trân trọng cùng lời chúc sức khỏe và thành công. Từ khi thành lập HNS tự hào là đơn vị đi tiên
                        phong
                        trong các giải pháp hiện đại, mang lại sự tối ưu nhất về công năng và chi phí, đồng thời cùng
                        nâng
                        tầm sự trải nghiệm và tiện ích cho hồ bơi của quý khách hàng.
                    </p>
                    <p class="mb-6 text-[#3F3F3F] leading-relaxed">
                        Quý khách hàng lời chào trân trọng cùng lời chúc sức khỏe và thành công. Từ khi thành lập HNS tự
                        hào
                        là đơn vị đi tiên phong trong các giải pháp hiện đại, mang lại sự tối ưu nhất về công năng và
                        chi
                        phí, đồng thời cùng nâng tầm sự trải nghiệm và tiện ích cho hồ bơi của quý khách hàng.
                    </p>

                    <a href="#"
                        class="inline-block bg-[#0D4A9A] text-white font-bold py-3 px-8  rounded-tr-lg rounded-full mt-4 transition duration-300 hover:bg-[#254673]">
                        XEM THÊM VỀ CHÚNG TÔI
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- Sản phẩm nổi bật -->
    <section class="bg-[#F6FFFF] py-10 px-4">
        <div class="container mx-auto">
            <!-- Tiêu đề -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-[#0D4A9A]">SẢN PHẨM NỔI BẬT</h2>
                <div class="space-x-2">

                    <button
                        class=" rounded-full w-[195px] h-[51px] border border-[#616161] bg-white text-[#0D4A9A] font-semibold">Hồ
                        bơi</button>
                    <button
                        class=" rounded-full w-[195px] h-[51px] border border-[#616161] bg-white text-[#0D4A9A] font-semibold">Composite</button>
                </div>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="relative mt-6 flex items-center">

                <!-- Danh sách sản phẩm -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 w-full">

                    <!-- Card sản phẩm -->
                    <div
                        class="bg-white border border-[#8D8D8D] rounded-2xl p-2 flex flex-col items-center hover:shadow-lg transition">
                        <div
                            class="w-full h-[322px] flex justify-center items-center bg-[#F4F4F4] rounded-2xl overflow-hidden">
                            <img src="<?php echo get_template_directory_uri() ;?>/assets/images/product1.png" alt="" class="object-cover" />
                        </div>
                        <h3 class="mt-3 text-sm text-center font-bold leading-[27px] uppercase text-[#0D4A9A]">
                            HALOGEN HAYWARD ĐÈN ÂM NƯỚC BỂ BƠI CHẤT LƯỢNG
                        </h3>
                    </div>

                    <!-- Card sản phẩm 2 -->
                    <div
                        class="bg-white border border-[#8D8D8D] rounded-2xl p-2 flex flex-col items-center hover:shadow-lg transition">
                        <div
                            class="w-full h-[322px] flex justify-center items-center bg-[#F4F4F4] rounded-2xl overflow-hidden">
                            <img src="<?php echo get_template_directory_uri() ;?>/assets/images/product2.png" alt="" class="object-cover" />
                        </div>
                        <h3 class="mt-3 text-sm text-center font-bold leading-[27px] uppercase text-[#0D4A9A]">
                            HALOGEN HAYWARD ĐÈN ÂM NƯỚC BỂ BƠI CHẤT LƯỢNG
                        </h3>
                    </div>

                    <!-- Card sản phẩm 3 -->
                    <div
                        class="bg-white border border-[#8D8D8D] rounded-2xl p-2 flex flex-col items-center hover:shadow-lg transition">
                        <div
                            class="w-full h-[322px] flex justify-center items-center bg-[#F4F4F4] rounded-2xl overflow-hidden">
                            <img src="<?php echo get_template_directory_uri() ;?>/assets/images/product3.png" alt="" class="object-cover" />
                        </div>
                        <h3 class="mt-3 text-sm text-center font-bold leading-[27px] uppercase text-[#0D4A9A]">
                            HALOGEN HAYWARD ĐÈN ÂM NƯỚC BỂ BƠI CHẤT LƯỢNG
                        </h3>
                    </div>

                    <!-- Card sản phẩm 4 -->
                    <div
                        class="bg-white border border-[#8D8D8D] rounded-2xl p-2 flex flex-col items-center hover:shadow-lg transition">
                        <div
                            class="w-full h-[322px] flex justify-center items-center bg-[#F4F4F4] rounded-2xl overflow-hidden">
                            <img src="<?php echo get_template_directory_uri() ;?>/assets/images/skimer-em0130-sc-500x500.png" alt="" class="object-cover" />
                        </div>
                        <h3 class="mt-3 text-sm text-center font-bold leading-[27px] uppercase text-[#0D4A9A] ">
                            HALOGEN HAYWARD ĐÈN ÂM NƯỚC BỂ BƠI CHẤT LƯỢNG
                        </h3>
                    </div>

                </div>

            </div>

            <!-- Button xem tất cả -->
            <div class="flex justify-center mt-4">
                <button
                    class="inline-block cursor-pointer bg-[#0D4A9A] text-white font-semibold py-2 px-8  rounded-tr-lg rounded-full mt-4 transition duration-300 hover:bg-[#254673]">
                    Xem tất cả
                </button>
            </div>
        </div>
        </div>

    </section>
    <!-- END Sản phẩm nổi bật -->

    <section class="bg-[#F6FFFF] py-16">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-[#0D4A9A] uppercase">Dự án tiêu biểu</h2>
        </div>

        <div class="relative px-6">
            <!-- Swiper Container -->
            <div class="swiper mySwiper2">
                <div class="swiper-wrapper">
                    <!-- Slide Item -->
                    <div class="swiper-slide">
                        <div class="relative rounded-lg overflow-hidden">
                            <img src="<?php echo get_template_directory_uri() ;?>/assets/images/trip1.png" class="w-full h-64 object-cover" />
                            <div
                                class="absolute bottom-0 left-0 w-full bg-linear-to-t from-black/60 to-transparent text-white text-sm p-4">
                                RESORT OCEAN BAY PHÚ QUỐC
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="relative rounded-lg overflow-hidden">
                            <img src="<?php echo get_template_directory_uri() ;?>/assets/images/trip1.png" class="w-full h-64 object-cover" />
                            <div
                                class="absolute bottom-0 left-0 w-full bg-linear-to-t from-black/60 to-transparent text-white text-sm p-4">
                                RESORT OCEAN BAY PHÚ QUỐC
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="relative rounded-lg overflow-hidden">
                            <img src="<?php echo get_template_directory_uri() ;?>/assets/images/trip1.png" class="w-full h-64 object-cover" />
                            <div
                                class="absolute bottom-0 left-0 w-full bg-linear-to-t from-black/60 to-transparent text-white text-sm p-4">
                                RESORT OCEAN BAY PHÚ QUỐC
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="relative rounded-lg overflow-hidden">
                            <img src="<?php echo get_template_directory_uri() ;?>/assets/images/trip1.png" class="w-full h-64 object-cover" />
                            <div
                                class="absolute bottom-0 left-0 w-full bg-linear-to-t from-black/60 to-transparent text-white text-sm p-4">
                                RESORT OCEAN BAY PHÚ QUỐC
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="relative rounded-lg overflow-hidden">
                            <img src="<?php echo get_template_directory_uri() ;?>/assets/images/trip1.png" class="w-full h-64 object-cover" />
                            <div
                                class="absolute bottom-0 left-0 w-full bg-linear-to-t from-black/60 to-transparent text-white text-sm p-4">
                                RESORT OCEAN BAY PHÚ QUỐC
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>

            <!-- Nút điều hướng -->
            <div class="swiper-button-prev !text-[#0D4A9A] !w-10 !h-10 !bg-white !rounded-full !shadow-md"></div>
            <div class="swiper-button-next !text-[#0D4A9A] !w-10 !h-10 !bg-white !rounded-full !shadow-md"></div>
        </div>

        <!-- Button xem tất cả -->
        <div class="flex justify-center mt-4">
            <button
                class="inline-block cursor-pointer bg-[#0D4A9A] text-white font-semibold py-2 px-8  rounded-tr-lg rounded-full mt-4 transition duration-300 hover:bg-[#254673]">
                Xem tất cả dự án
            </button>
        </div>
    </section>



    <section class="py-16 bg-[#F6FFFF]">
        <h2 class="text-3xl font-bold text-[#0D4A9A] text-center mb-10 uppercase">
            Tin tức nổi bật
        </h2>

        <!-- Slider -->
        <!-- Slider -->
        <div class="relative max-w-7xl mx-auto px-4">
            <div class="swiper newsSwiper relative">
                <div class="swiper-wrapper">
                    <!-- Slide -->
                    <div class="swiper-slide h-[480px] ">
                        <div
                            class="bg-white rounded-xl border border-[#C9C9C9] h-full overflow-hidden hover:shadow-lg transition">
                            <img src="<?php echo get_template_directory_uri() ;?>/assets/images/tin-tuc-4.png" class="w-full h-[305px] object-cover p-3 rounded-3xl" />
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
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
                            <img src="<?php echo get_template_directory_uri() ;?>/assets/images/tin-tuc-4.png" class="w-full h-[305px] object-cover p-3 rounded-3xl" />
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
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
                            <img src="<?php echo get_template_directory_uri() ;?>/assets/images/tin-tuc-4.png" class="w-full h-[305px] object-cover p-3 rounded-3xl" />
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
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
                            <img src="<?php echo get_template_directory_uri() ;?>/assets/images/tin-tuc-4.png" class="w-full h-[305px] object-cover p-3 rounded-3xl" />
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
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
                            <img src="<?php echo get_template_directory_uri() ;?>/assets/images/tin-tuc-4.png" class="w-full h-[305px] object-cover p-3 rounded-3xl" />
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation nằm bên trong -->
                <div class="swiper-button-prev news-prev !w-10 !h-10 !rounded-full !bg-white !shadow"></div>
                <div class="swiper-button-next news-next !w-10 !h-10 !rounded-full !bg-white !shadow"></div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>
