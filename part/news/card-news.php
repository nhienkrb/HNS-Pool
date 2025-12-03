<?php
$featured = Queries::featured_news(4); 
if ($featured->have_posts()) :
?>
<section>
    <div class="max-w-7xl mx-auto px-4 mt-10 space-y-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <div class="lg:col-span-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php
                    $i = 0;
                    while ($featured->have_posts()) : $featured->the_post();
                        if ($i >= 2) {
                            break; 
                        }
                        $i++;
                    ?>
                        <a href="<?php the_permalink(); ?>">
                            <article class="bg-white rounded-lg font-hd">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large')); ?>"
                                         alt="<?php the_title_attribute(); ?>"
                                         class="rounded-lg w-full object-cover">
                                <?php else : ?>
                                    <img src="<?php echo esc_url(get_theme_file_uri('/assets/tin-tuc2-DDrApYYF.svg')); ?>"
                                         alt="<?php the_title_attribute(); ?>"
                                         class="rounded-lg w-full object-cover">
                                <?php endif; ?>

                                <div class="p-5 space-y-2">
                                    <div class="text-xs text-gray-500 flex items-center gap-2">
                                        <span class="text-main text-lg">•</span>
                                        <span><?php echo esc_html(get_the_date('d/m/Y')); ?></span>
                                    </div>
                                    <h3 class="font-semibold text-lg leading-snug line-clamp-2">
                                        <?php the_title(); ?>
                                    </h3>
                                    <p class="text-sm text-gray-500 line-clamp-2">
                                        <?php echo esc_html(wp_trim_words(get_the_excerpt(), 25, '...')); ?>
                                    </p>
                                </div>
                            </article>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="lg:col-span-4 flex flex-col gap-6">
                <?php
                if ($featured->post_count > 2 && $featured->have_posts()) :
                    while ($featured->have_posts()) : $featured->the_post();
                ?>
                    <article class="relative bg-white rounded-lg overflow-hidden shadow-sm font-hd">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large')); ?>"
                                 alt="<?php the_title_attribute(); ?>"
                                 class="w-full object-cover">
                        <?php else : ?>
                            <img src="<?php echo esc_url(get_theme_file_uri('/assets/img/tin-tuc1.svg')); ?>"
                                 alt="<?php the_title_attribute(); ?>"
                                 class="w-full object-cover">
                        <?php endif; ?>

                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 class="text-white font-semibold text-sm md:text-base leading-snug">
                                <?php the_title(); ?>
                            </h3>
                        </div>
                    </article>
                <?php
                    endwhile;
                endif;
                ?>
            </div>

        </div>
    </div>
</section>
<?php
wp_reset_postdata();
endif;
?>
