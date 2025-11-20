<?php

/**
 * Template Name: Trang Chủ
 */; ?>
<?php get_header(); ?>


<!-- Start Carousel -->
<section>
    <div class="swiper mySwiper w-full  mx-auto  max-w-screen">
        <div class="swiper-wrapper">

            <div class="swiper-slide">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner.png" class="w-full h-[646px] object-cover" />
            </div>

            <div class="swiper-slide">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner.png" class="w-full h-[646px] object-cover" />
            </div>

            <div class="swiper-slide">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner.png" class="w-full h-[646px] object-cover" />
            </div>

        </div>

        <div class="max-w-screen-5xl  ">
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

<section class=" max-w-screen mx-auto py-16 bg-[url('<?php echo get_template_directory_uri(); ?>/assets/images/bg-hero.svg')]">
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
                <h2 class="text-3xl lg:text-4xl font-serif italic text-[#2077EA]"><?php echo get_theme_mod('intro_subtitle', 'Giới Thiệu'); ?></h2>
                <h1 class="text-4xl lg:text-5xl font-extrabold mb-6 text-[#0D4A9A] leading-snug">
                    <?php echo get_theme_mod('intro_title', 'HÌNH THÀNH & PHÁT TRIỂN HNS');; ?>
                </h1>

                <p class="mb-4 text-[#3F3F3F] leading-relaxed">
                    <?php echo get_theme_mod('intro_content', 'Lần đầu tiên tôi xin thay mặt công ty...');; ?>
                </p>
                <p class="mb-6 text-[#3F3F3F] leading-relaxed">
                    <?php echo get_theme_mod('intro_content2', 'Lần đầu tiên tôi xin thay mặt công ty...');; ?>
                </p>

                <a href="#"
                    class="inline-block bg-[#0D4A9A] text-white font-bold py-3 px-8  rounded-tr-lg rounded-full mt-4 transition duration-300 hover:bg-[#254673]">
                    <?php echo get_theme_mod('intro_button_text', 'XEM THÊM VỀ CHÚNG TÔI'); ?>
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

                <?php
                $q = Queries::latest_products(6);

                if ($q->have_posts()):
                    while ($q->have_posts()) : $q->the_post();
                        get_template_part('parts/pool/card');
                    endwhile;
                    wp_reset_postdata();
                else:
                    echo '<p>Không có sản phẩm nào.</p>';
                endif;
                ?>


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

    <div class="relative container mx-auto px-4">
        <!-- Swiper Container -->
        <div class="swiper mySwiper2 ">
            <div class="swiper-wrapper">
                <!-- Slide Item -->
                <?php
                $q = Queries::latest_projects(6);

                if ($q->have_posts()):
                    while ($q->have_posts()):
                        $q->the_post();
                ?>
                        <div class="swiper-slide">

                            <?php get_template_part('parts/project/card'); ?>
                        </div>

                <?php
                    endwhile;
                    wp_reset_postdata();
                else:
                    echo '<p>Không có project nào.</p>';
                endif;
                ?>

            </div>
        </div>

        <!-- Nút điều hướng -->
        <div class="swiper-button-prev text-[#0D4A9A]! w-10 h-10! bg-white! rounded-full! shadow-md!"></div>
        <div class="swiper-button-next text-[#0D4A9A]! w-10 h-10! bg-white! rounded-full! shadow-md!"></div>
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
    <div class="relative container mx-auto px-4">
        <div class="swiper newsSwiper relative">
            <div class="swiper-wrapper ">

                <?php
                $q = Queries::latest_news(6);

                if ($q->have_posts()):
                    while ($q->have_posts()):
                        $q->the_post();
                ?>
                        <div class="swiper-slide h-[480px]">
                            <?php get_template_part('parts/post/card'); ?>
                        </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else:
                    echo '<p class="p-4 text-gray-600">Không có bài viết nào.</p>';
                endif;
                ?>

            </div>


            <!-- Navigation nằm bên trong -->
            <div class="swiper-button-prev news-prev w-10! h-10! rounded-full! bg-white shadow!"></div>
            <div class="swiper-button-next news-next w-10! h-10! rounded-full! bg-white shadow!"></div>
        </div>
    </div>
</section>

<?php get_footer(); ?>