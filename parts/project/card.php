<?php

/**
 * Card Dự án
 * Gọi trong WP Loop (have_posts())
 */
?>
<div class="relative rounded-lg overflow-hidden">

    <?php if (has_post_thumbnail()):; ?>
        <?php the_post_thumbnail('medium', ['class' => 'object-cover w-full h-64']); ?>
    <?php else: ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/trip1.png" class="w-full h-64 object-cover" />
    <?php endif; ?>
    <div
        class="absolute bottom-0 left-0 w-full bg-linear-to-tl from-black/60 to-transparent text-white text-md p-4 font-bold uppercase">
        <?php the_title(); ?>
    </div>
</div>