<?php

/**
 * Template Name: Hồ Bơi
 */; ?>

<?php get_header(); ?>
<?php $categories = Queries::get_all_category_product(); ?>
<?php get_template_part('parts/breadcrumbs'); ?>

<div class="container  mx-auto px-4  wrap-content">
    <!-- Start banner -->
    <section>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4  py-6">
            <!-- Sidebar -->
            <div class="md:col-span-1 bg-white rounded-lg shadow border border-gray-200">
                <div class="bg-[#0D4A9A] text-white font-semibold text-center py-3 rounded-t-lg">
                    DANH MỤC SẢN PHẨM
                </div>
                <ul class="divide-y divide-gray-300">
                    <?php foreach ($categories as $cat): ?>
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer"><?php echo esc_html($cat->name); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Banner -->
            <div class="md:col-span-3 relative rounded-lg overflow-hidden">
                <img src="<?= esc_url(get_theme_mod('banner_image')); ?>" alt="banner"
                    class="w-full h-[420px] object-cover rounded-lg scale-x-[-1]">
                <h2 class="absolute top-12 left-20 transform -translate-x-1/2 text-3xl font-bold text-[#0D4A9A]">
                    <?= get_theme_mod('banner_sb', 'Hồ Bơi'); ?>
                </h2>
            </div>
        </div>
    </section>
    <!-- End banner -->

    <!-- Start Sản phẩm -->
    <section class="">
        <div class="mb-12 mt-17">
            <h2 class="text-3xl font-bold leading-[100%] text-[#0D4A9A] relative pl-6">
                <span
                    class=" absolute left-1 top-1/2 -translate-y-1/2 w-0.5 h-6 bg-[#0D4A9A] rounded-full"></span>
                Thiết bị hệ thống lọc hồ bơi
            </h2>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
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
    </section>
    <!-- End Sản phẩm -->


    <!-- Pagination Sản phẩm  -->

    <section>
        <nav class="flex justify-center items-center space-x-2 my-13 " aria-label="Pagination">

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
    <!-- END Pagination Sản phẩm  -->

</div>
<?php get_footer(); ?>