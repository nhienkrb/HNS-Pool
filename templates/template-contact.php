<?php

/**
 * Template Name: Liên hệ
 */
?>

<?php get_header(); ?>
<!-- Breadcrumbs  -->
<?php get_template_part('parts/breadcrumbs'); ?>

<div class="container mx-auto px-4">
    <section class="mb-10">
        <div class="header-gt flex justify-center my-10">
            <h3 class="text-4xl font-bold uppercase">Liên Hệ</h3>
        </div>
        <div class="grid grid-cols-12 gap-4 ">

            <div class="col-span-12 md:col-span-6 lg:col-span-5">
                <div class="shadow-xl rounded-lg overflow-hidden border border-[#0D4A9A] ">

                    <div class="bg-[#0D4A9A] p-6">
                        <div class="flex justify-center items-center space-x-2 p-3 bg-white rounded-t-2xl">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="HNS Logo">
                        </div>
                    </div>

                    <div class="relative bg-[#0D4A9A] text-white">
                        <div class="flex justify-center">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contract-model.png" alt="Nhân viên hỗ trợ"
                                class="h-[300px] w-auto object-cover">
                        </div>

                        <div class="p-6 bg-[#2D5DA7] space-y-3 px-3 py-10">
                            <p class="font-semibold">Giờ làm việc: 8:00 – 17:00 (Monday – Saturday)</p>
                            <p class="font-semibold">Email: <a href="mailto:pooltech.hns@gmail.com"
                                    class="hover:no-underline!">pooltech.hns@gmail.com</a></p>
                            <p class="font-semibold">Đường dây nóng đặt hàng và tư vấn: 0983 804 445</p>

                            <div class="pt-4 ">
                                <p class="font-semibold">Theo Dõi Chúng Tôi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 md:col-span-6 lg:col-span-7">
                <form class="space-y-6 w-full">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 ">
                        <div>
                            <label for="name" class="block text-gray-700 font-medium mb-1">Họ tên*</label>
                            <input type="text" id="name" placeholder="Lê Hạ Anh"
                                class="w-full border border-gray-300 p-3 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-1">Email*</label>
                            <input type="email" id="email" placeholder="Your Email"
                                class="w-full border border-gray-300 p-3 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="phone" class="block text-gray-700 font-medium mb-1">Số điện thoại*</label>
                            <input type="tel" id="phone" placeholder="Phone number"
                                class="w-full border border-gray-300 p-3 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="service" class="block text-gray-700 font-medium mb-1">Dịch vụ*</label>
                            <select id="service"
                                class="w-full border border-gray-300 p-3 rounded-lg appearance-none focus:ring-blue-500 focus:border-blue-500">
                                <option>The service 1 </option>
                                <option>The service 2</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block text-gray-700 font-medium mb-1">Yêu cầu bổ sung</label>
                        <textarea id="message" rows="5" placeholder="Hãy cho chúng tôi biết thêm về yêu cầu của bạn..."
                            class="w-full border h-[276px] border-gray-300 p-3 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div class="pt-2">
                        <p class="text-sm mb-3">Để không bỏ lỡ bất kỳ thông tin nào, vui lòng cung cấp cho tôi thông
                            tin liên lạc của bạn!</p>
                        <div class="flex space-x-4">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" checked class="text-blue-600 rounded">
                                <span class="text-gray-700">Email</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="text-blue-600 rounded">
                                <span class="text-gray-700">Số điện thoại</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                        class="bg-[#0D4A9A] text-white font-bold py-3 px-8 rounded-lg 
                            transition duration-300 hover:bg-[#2D5DA7]">
                        GỬI NGAY
                    </button>

                </form>
            </div>

        </div>
    </section>

    <section>
        <div class="my-7 w-full">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.039958638669!2d106.61668727355233!3d10.808251558608916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752be5b80227f5%3A0x2d1f6fe0c5567d14!2zMzkwIEzDqiBUcuG7jW5nIFThuqVuLCBTxqFuIEvhu7MsIFTDom4gUGjDuiwgVGjDoG5oIHBo4buRIEjhu5MgQ2jDrSBNaW5oIDcwMDAwMCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1761119010207!5m2!1svi!2s"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
</div>



<?php get_footer(); ?>