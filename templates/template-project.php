<?php

/**
 * Template Name: Dự án tiêu biểu
 */; ?>

<?php get_header(); ?>

<?php get_template_part('parts/breadcrumbs'); ?>

<div class="container mx-auto px-4">
    <!-- Start dự án -->
    <section>
        <div class="header-gt flex justify-center my-10">
            <h3 class="text-4xl font-bold uppercase">Dự án nổi bật</h3>
        </div>
        <div class="grid grid-cols-12 gap-4">
            <!-- Slide Item -->
            <?php
            $q = Queries::latest_projects(6);

            if ($q->have_posts()):
                while ($q->have_posts()):
                    $q->the_post();
            ?>
                    <div class="col-span-12 sm:col-span-6">
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
    </section>
    <!-- End dự án -->


    <!-- Pagination Tin tuc  -->
    <section>
        <nav class="flex justify-end items-center space-x-2 mt-13" aria-label="Pagination">

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