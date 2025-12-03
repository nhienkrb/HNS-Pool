<?php
/**
 * Template Name: Liên Hệ
 */
get_header();
?>

<main>
    <!-- SECTION: BANNER -->
    <section>
        <div class="relative">
            <?php
            $contact_banner_image = get_theme_mod(
                'contact_banner_image',
                get_theme_file_uri('/assets/img/banner-contact.svg')
            );
            $contact_banner_title = get_theme_mod('contact_banner_title', 'CONTACT US');
            ?>
            <img src="<?php echo esc_url($contact_banner_image); ?>"
                 class="w-full h-[260px] sm:h-80 md:h-[380px] lg:h-[450px] object-cover"
                 alt="<?php esc_attr_e('Contact banner', 'giaphan'); ?>">

            <!-- Text overlay -->
            <div class="max-w-7xl mx-auto">
                <div class="absolute inset-x-4 bottom-6 sm:bottom-10 lg:left-1/4 lg:bottom-[20%]">
                    <h1 class="
                        bg-linear-to-r from-[#7878787c] via-white to-[#7878787c]
                        bg-clip-text text-transparent
                        opacity-40
                        font-bold tracking-[0.25em]
                        leading-[130%]
                        text-3xl sm:text-5xl lg:text-[85px]
                    ">
                        <?php echo esc_html($contact_banner_title); ?>
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: Breadcrumb -->
    <!-- SECTION 2: Breadcrumb -->
    <section>
        <nav class="text-center font-hd space-x-2 my-8">
            <a href="#" class="text-main-title font-semibold text-base">Trang Chủ /</a>
            <a href="#" class="text-[#5C5C5C]">Liên Hệ</a>
        </nav>
    </section>

    <!-- SECTION: Intro title + text -->
    <?php
    $contact_intro_heading = get_theme_mod(
        'contact_intro_heading',
        'LIÊN HỆ VỚI NHÔM KÍNH GIA PHAN'
    );
    $contact_intro_text = get_theme_mod(
        'contact_intro_text',
        'Gia Phan rất mong nhận được phản hồi từ bạn và cùng nhau bắt đầu một điều gì đó đặc biệt. Hãy gọi cho chúng tôi nếu bạn có bất kỳ thắc mắc nào.'
    );
    ?>
    <section>
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 font-hd gap-5">
                <div class="sm:h-30 text-main-title leading-[130%] text-5xl font-semibold px-8 border-r border-gray-300">
                    <h1><?php echo esc_html($contact_intro_heading); ?></h1>
                </div>
                <div class="sm:h-30 pl-8">
                    <h3 class="text-2xl font-normal text-[#03010199] leading-[160%]">
                        <?php echo wp_kses_post($contact_intro_text); ?>
                    </h3>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: Contact info + image + form -->
    <?php
    $contact_company_name = get_theme_mod(
        'contact_company_name',
        'CÔNG TY TNHH MTV THƯƠNG MẠI DỊCH VỤ NHÔM KÍNH GIA PHAN'
    );
    $contact_phone = get_theme_mod('contact_phone', '08 6275 3239 - 093 5555 456');
    $contact_email = get_theme_mod('contact_email', 'nhomkinhgiaphan@gmail.com');
    $contact_address = get_theme_mod(
        'contact_address',
        '11/2 Đường liên khu 2 -10, P.Bình Hưng Hòa A, Q.Bình Tân, TP. HCM.'
    );
    $contact_side_image = get_theme_mod(
        'contact_side_image',
        get_theme_file_uri('/assets/img/banner2-contact.png')
    );
    ?>
    <section>
        <div class="max-w-7xl mx-auto px-4 mt-30">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 relative items-center">
                <div class="space-y-4 max-w-sm">
                    <h3 class="text-xl uppercase leading-[150%] font-semibold text-main">
                        <?php echo esc_html($contact_company_name); ?>
                    </h3>

                    <p class="text-main-title text-lg font-semibold">
                        <span class="text-sm text-[#5C5C5C]">Điện thoại</span> <br>
                        <?php echo esc_html($contact_phone); ?>
                    </p>

                    <p class="text-main-title text-lg font-semibold">
                        <span class="text-sm text-[#5C5C5C]">Email</span> <br>
                        <?php echo esc_html($contact_email); ?>
                    </p>

                    <p class="text-main-title text-lg font-semibold">
                        <span class="text-sm text-[#5C5C5C]">Văn phòng</span> <br>
                        <?php echo esc_html($contact_address); ?>
                    </p>

                    <div class="flex items-center gap-3 text-gray-600">
                        <button class="p-2 rounded border hover:bg-gray-100">
                            <i class="fa-solid fa-copy"></i>
                        </button>
                        <button class="p-2 rounded border hover:bg-gray-100">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>
                        <button class="p-2 rounded border hover:bg-gray-100">
                            <i class="fa-solid fa-print"></i>
                        </button>
                        <button class="p-2 rounded border hover:bg-gray-100">
                            <i class="fa-solid fa-download"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <img src="<?php echo esc_url($contact_side_image); ?>"
                         class="w-full object-cover"
                         alt="<?php esc_attr_e('Contact illustration', 'giaphan'); ?>">
                </div>

                <div class="md:absolute md:top-1/7 md:left-1/3">
                    <div class="max-w-[500px]">
                        <div class="w-full bg-linear-to-b from-[#093C62] to-[#031E33]
                                    rounded-2xl p-8 text-white shadow-xl font-hd">

                            <!-- TITLE -->
                            <h2 class="text-center text-2xl font-bold mb-6 tracking-wide">
                                GỬI THÔNG TIN LIÊN HỆ
                            </h2>

                            <!-- Form hiện tại vẫn là HTML tĩnh.
                                 Bạn có thể hook vào CF7, WPForms,... sau nếu muốn -->
                            <form class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <input type="text" placeholder="Họ tên"
                                           class="w-full p-3 rounded-md bg-transparent border border-white/30
                                                  text-white placeholder-white/60 focus:outline-none focus:border-white" />

                                    <input type="text" placeholder="Số điện thoại"
                                           class="w-full p-3 rounded-md bg-transparent border border-white/30
                                                  text-white placeholder-white/60 focus:outline-none focus:border-white" />
                                </div>

                                <div>
                                    <select class="w-full p-3 border border-white/30 rounded-md">
                                        <option class="text-black">Dịch vụ muốn Gia Phan tư vấn</option>
                                        <option class="text-black">Thi công nhôm kính công nghiệp</option>
                                        <option class="text-black">Thi công nhôm nhà ở</option>
                                    </select>
                                </div>

                                <textarea rows="5" placeholder="Yêu cầu khác"
                                          class="w-full p-3 rounded-md bg-transparent border border-white/30
                                                     text-white placeholder-white/60 focus:outline-none focus:border-white"></textarea>

                                <div class="text-center pt-2">
                                    <button class="px-8 py-3 rounded-lg border border-white text-white
                                            hover:bg-white hover:text-[#093C62] transition-all flex items-center gap-2 mx-auto">
                                        Gửi thông tin
                                        <i class="fa-regular fa-paper-plane text-sm"></i>
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: MAP -->
    <?php
    $map_url = get_theme_mod('contact_map_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4570165705354!2d106.6063701809902!3d10.77626648733133!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752c14c5a09755%3A0xdf8c9b3374896ec1!2zMzUyIMSQLiBMw6ogVsSDbiBRdeG7m2ksIELDrG5oIFRy4buLIMSQw7RuZyBBLCBCw6xuaCBUw6JuLCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1764579371734!5m2!1svi!2s');
    ?>
    <section>
        <div class="max-w-7xl mx-auto px-4 sm:mt-20 mt-10">
            <iframe class="w-full rounded-xl"
                    src="<?php echo esc_url($map_url); ?>"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
</main>

<?php get_footer(); ?>
