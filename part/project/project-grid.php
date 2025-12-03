<?php
$projects = Queries::projects(6);
if (!$projects->have_posts()) {
    return;
}

$items = [];

while ($projects->have_posts()) {
    $projects->the_post();
    $items[] = get_the_ID();
}

wp_reset_postdata();
?>


<div class="max-w-7xl mx-auto px-4 mt-20 font-hd">

    <!-- ================= SECTION 1 ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 font-hd">

        <div class="lg:col-span-5">
            <?php
            if (!empty($items[0])) {
                $p = get_post($items[0]);
                setup_postdata($p);
                get_template_part('part/project/project-card', null, ['size' => 'small']);
                wp_reset_postdata();
            }
            ?>
        </div>

        <div class="lg:col-span-7">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php
                for ($i = 1; $i <= 4; $i++) {
                    if (!empty($items[$i])) {
                        $p = get_post($items[$i]);
                        setup_postdata($p);
                        get_template_part('part/project/project-card', null, ['size' => 'small']);
                        wp_reset_postdata();
                    }
                }
                ?>
            </div>
        </div>

    </div>


    <!-- ================= SECTION 2 ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 font-hd mt-20 lg:h-[450px]">

        <!-- Left big -->
        <div class="lg:col-span-7 h-full">
            <?php
            if (!empty($items[1])) {
                $p = get_post($items[1]);
                setup_postdata($p);
                get_template_part('part/project/project-card', null, ['size' => 'small']);
                wp_reset_postdata();
            }
            ?>
        </div>

        <!-- Right 2 medium stacked -->
        <div class="lg:col-span-5 h-full">
            <div class="flex flex-col gap-4 h-full">
                <?php
                for ($i = 2; $i <= 3; $i++) {
                    if (!empty($items[$i])) {
                        $p = get_post($items[$i]);
                        setup_postdata($p);
                        get_template_part('part/project/project-card', null, ['size' => 'small']);
                        wp_reset_postdata();
                    }
                }
                ?>
            </div>
        </div>

    </div>


    <!-- ================= SECTION 3 ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 font-hd mt-20 lg:h-[450px]">

        <!-- Left 2 stacked -->
        <div class="lg:col-span-5 h-full">
            <div class="flex flex-col gap-4 h-full">
                <?php
                for ($i = 3; $i <= 4; $i++) {
                    if (!empty($items[$i])) {
                        $p = get_post($items[$i]);
                        setup_postdata($p);
                        get_template_part('part/project/project-card', null, ['size' => 'small']);
                        wp_reset_postdata();
                    }
                }
                ?>
            </div>
        </div>

        <!-- Right big -->
        <div class="lg:col-span-7 h-full">
            <?php
            if (!empty($items[5])) {
                $p = get_post($items[5]);
                setup_postdata($p);
                get_template_part('part/project/project-card', null, ['size' => 'small']);
                wp_reset_postdata();
            }
            ?>
        </div>

    </div>

</div>