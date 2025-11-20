<?php

/**
 * Template Name: Góc tư vấn
 */; ?>
<?php get_header(); ?>

<?php get_template_part('parts/breadcrumbs'); ?>

<div class="container mx-auto px-4">
    <!-- Start Góc tư vấn -->
    <section>
        <div class="bg-[#F6FFFF]">
            <div class="header-gt flex justify-center my-10">
                <h3 class="text-4xl font-bold uppercase">Góc tư vấn</h3>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8 lg:gap-12">

            <div class="col-span-12 lg:col-span-7">
                <article class="space-y-2">
                    <img src=" <?php echo get_template_directory_uri(); ?>/assets/images/tin-tuc1.png" alt="Ảnh nổi bật" class="w-full h-auto rounded-lg shadow-lg">
                    <p class="text-base leading-5 font-medium text-[#115718]">29.07.2025</p>
                    <h2 class="text-2xl font-medium text-[#1E1E1E] ">
                        Hướng Dẫn Cách Làm Túi Vải Handmade Đơn Giản, Chi Tiết
                    </h2>
                    <p class="text-[#7C7C7C] leading-[150%]">
                        Những chiếc túi vải handmade xinh xắn là phụ kiện thời trang thể hiện cá tính của người
                        dùng. Bài viết hôm nay, Túi Thành Tiến sẽ hướng dẫn cách làm túi vải handmade đơn giản, chi
                        tiết nhất.
                    </p>
                </article>
            </div>

            <div class="col-span-12 lg:col-span-5 space-y-4">
                <?php
                $q = Queries::latest_advisory(4);
                if ($q->have_posts()):
                    while ($q->have_posts()):
                        $q->the_post();
                ?>
                        <?php get_template_part('parts/post/sub_card'); ?>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else:
                    echo '<p class="p-4 text-gray-600">Không có bài viết nào.</p>';
                endif;
                ?>
            </div>
        </div>

    </section>
    <!-- End Góc tư vấn -->

    <!-- News -->
    <section>
        <div class="grid grid-cols-12 mt-30 gap-6">

            <?php
            $q = Queries::latest_advisory(6);
            if ($q->have_posts()):
                while ($q->have_posts()):
                    $q->the_post();
            ?>
                    <div class="col-12  md:col-span-4 h-[480px] ">
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
    </section>
    <!-- End News -->

    <!-- Pagination Tin tuc  -->

    <section>
        <nav class="flex justify-end items-center space-x-2 my-13" aria-label="Pagination">

            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full 
                      border border-[#0D4A9A] text-[#0D4A9A] transition duration-200 
                      hover:bg-[#0D4A9A] hover:text-white" aria-label="Previous">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <a href="#" class="w-10 h-10 flex items-center justify-center text-sm font-medium 
                      text-gray-700 rounded-full transition duration-200 
                      hover:bg-gray-100">
                1
            </a>

            <a href="#" aria-current="page" class="w-10 h-10 flex items-center justify-center text-sm font-bold 
                      bg-[#0D4A9A] text-white rounded-full">
                2
            </a>

            <a href="#" class="w-10 h-10 flex items-center justify-center text-sm font-medium 
                      text-gray-700 rounded-full transition duration-200 
                      hover:bg-gray-100">
                3
            </a>
            <a href="#" class="w-10 h-10 flex items-center justify-center text-sm font-medium 
                      text-gray-700 rounded-full transition duration-200 
                      hover:bg-gray-100">
                4
            </a>

            <span class="text-gray-500 font-medium">...</span>

            <a href="#" class="w-10 h-10 flex items-center justify-center text-sm font-medium 
                      text-gray-700 rounded-full transition duration-200 
                      hover:bg-gray-100">
                10
            </a>

            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full 
                      border border-[#0D4A9A] text-[#0D4A9A] transition duration-200 
                      hover:bg-[#0D4A9A] hover:text-white" aria-label="Next">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

        </nav>
    </section>
    <!-- END Pagination Tin tuc  -->

</div>

<?php get_footer(); ?>