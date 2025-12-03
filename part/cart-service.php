<?php

$services = Queries::services(3); 

if ( ! $services->have_posts() ) {
    return;
}
error_log($services->have_posts());
?>

<div class="grid grid-cols-12 gap-4 mt-20">
    <?php
    $i = 1;

    while ( $services->have_posts() ) :
        $services->the_post();

        $number    = str_pad((string) $i, 2, '0', STR_PAD_LEFT); // 1 -> 01
        $title     = get_the_title();
        $permalink = get_permalink();
        $thumb     = get_the_post_thumbnail_url(get_the_ID(), 'large');

        if ( ! $thumb ) {
            $thumb = get_template_directory_uri() . '/assets/img/img-linh-vuc1.svg'; // fallback ảnh
        }
        ?>
        <div class="col-span-12 md:col-span-4">
            <a href="<?php echo esc_url( $permalink ); ?>">
                <div class="p-4 cart bg-white rounded-xl shadow font-hd">
                    <div>
                        <img src="<?php echo esc_url( $thumb ); ?>"
                             class="w-full"
                             alt="<?php echo esc_attr( $title ); ?>">
                    </div>

                    <h3 class="mt-4 font-bold leading-[130%] text-main text-5xl">
                        <?php echo esc_html( $number ); ?>
                    </h3>

                    <div class="mt-2 flex gap-3">
                        <p class="leading-[130%] text-xl font-hd flex-1 line-clamp-3">
                            <?php echo esc_html( $title ); ?>
                        </p>

                        <div class="flex items-center justify-center w-10 h-10 border border-main rounded-full bg-white/80">
                            <svg width="166px" height="166px" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg" stroke="#A41E22">
                                <path d="M16.3891 8.11096L8.61091 15.8891" stroke="#A41E22"
                                      stroke-width="0.744" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M16.3891 8.11096L16.7426 12" stroke="#A41E22" stroke-width="0.744"
                                      stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M16.3891 8.11096L12.5 7.75741" stroke="#A41E22"
                                      stroke-width="0.744" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
        $i++;
    endwhile;

    wp_reset_postdata();
    ?>
</div>
