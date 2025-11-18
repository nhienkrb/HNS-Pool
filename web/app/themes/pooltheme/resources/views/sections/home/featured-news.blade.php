<section class="py-16 bg-[#F6FFFF]">
    <h2 class="text-3xl font-bold text-[#0D4A9A] text-center mb-10 uppercase">
        Tin tức nổi bật
    </h2>

    <div class="relative container mx-auto ">
        <div class="swiper newsSwiper relative">
            <div class="swiper-wrapper">

                @foreach ($latestNews as $post)
                    @php(setup_postdata($post))
                    <div class="swiper-slide h-[480px]">
                         <x-card-news :post="$post" />
                    </div>
                @endforeach

                @php(wp_reset_postdata())

                <div class="swiper-slide h-[480px] ">
                    <div
                        class="bg-white rounded-xl border border-[#C9C9C9] h-full overflow-hidden hover:shadow-lg transition">
                        <img src="@asset('images/tin-tuc-4.png')" class="w-full h-[305px] object-cover p-3 rounded-3xl" />
                        <div class="p-2 space-y-3">
                            <div class="flex text-xs justify-start items-center mb-2 gap-1">
                                <span
                                    class="bg-[#0D4A9A] text-base cursor-pointer font-semibold leading-4 text-white px-7 py-2 rounded-sm">Tin
                                    tức</span>
                                <div class="w-1 h-1 bg-black rounded-full mx-2"></div>
                                <span class="font-semibold text-base leading-4 text-black">15.10.2025</span>
                            </div>
                            <h3 class="text-lg font-semibold text-black leading-6 mt-1">
                                Top 17 hồ bơi TPHCM đẹp và sang chảnh nhất | Vườn An Nam
                            </h3>
                            <div class="flex justify-between">
                                <p class="text-[15px] text-[#3A3A3A] font-medium leading-5">
                                    Đèn hồ bơi Halogen của Sagocomposite được thiết kế riêng cho các hồ bơi nổi.
                                </p>
                                <a href="#" class="flex items-center">
                                    <span
                                        class="border rounded-full w-10 h-10 mx-1 text-[#909090] flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide h-[480px] ">
                    <div
                        class="bg-white rounded-xl border border-[#C9C9C9] h-full overflow-hidden hover:shadow-lg transition">
                        <img src="@asset('images/tin-tuc-4.png')" class="w-full h-[305px] object-cover p-3 rounded-3xl" />
                        <div class="p-2 space-y-3">
                            <div class="flex text-xs justify-start items-center mb-2 gap-1">
                                <span
                                    class="bg-[#0D4A9A] text-base cursor-pointer font-semibold leading-4 text-white px-7 py-2 rounded-sm">Tin
                                    tức</span>
                                <div class="w-1 h-1 bg-black rounded-full mx-2"></div>
                                <span class="font-semibold text-base leading-4 text-black">15.10.2025</span>
                            </div>
                            <h3 class="text-lg font-semibold text-black leading-6 mt-1">
                                Top 17 hồ bơi TPHCM đẹp và sang chảnh nhất | Vườn An Nam
                            </h3>
                            <div class="flex justify-between">
                                <p class="text-[15px] text-[#3A3A3A] font-medium leading-5">
                                    Đèn hồ bơi Halogen của Sagocomposite được thiết kế riêng cho các hồ bơi nổi.
                                </p>
                                <a href="#" class="flex items-center">
                                    <span
                                        class="border rounded-full w-10 h-10 mx-1 text-[#909090] flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide h-[480px] ">
                    <div
                        class="bg-white rounded-xl border border-[#C9C9C9] h-full overflow-hidden hover:shadow-lg transition">
                        <img src="@asset('images/tin-tuc-4.png')" class="w-full h-[305px] object-cover p-3 rounded-3xl" />
                        <div class="p-2 space-y-3">
                            <div class="flex text-xs justify-start items-center mb-2 gap-1">
                                <span
                                    class="bg-[#0D4A9A] text-base cursor-pointer font-semibold leading-4 text-white px-7 py-2 rounded-sm">Tin
                                    tức</span>
                                <div class="w-1 h-1 bg-black rounded-full mx-2"></div>
                                <span class="font-semibold text-base leading-4 text-black">15.10.2025</span>
                            </div>
                            <h3 class="text-lg font-semibold text-black leading-6 mt-1">
                                Top 17 hồ bơi TPHCM đẹp và sang chảnh nhất | Vườn An Nam
                            </h3>
                            <div class="flex justify-between">
                                <p class="text-[15px] text-[#3A3A3A] font-medium leading-5">
                                    Đèn hồ bơi Halogen của Sagocomposite được thiết kế riêng cho các hồ bơi nổi.
                                </p>
                                <a href="#" class="flex items-center">
                                    <span
                                        class="border rounded-full w-10 h-10 mx-1 text-[#909090] flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide h-[480px] ">
                    <div
                        class="bg-white rounded-xl border border-[#C9C9C9] h-full overflow-hidden hover:shadow-lg transition">
                        <img src="@asset('images/tin-tuc-4.png')" class="w-full h-[305px] object-cover p-3 rounded-3xl" />
                        <div class="p-2 space-y-3">
                            <div class="flex text-xs justify-start items-center mb-2 gap-1">
                                <span
                                    class="bg-[#0D4A9A] text-base cursor-pointer font-semibold leading-4 text-white px-7 py-2 rounded-sm">Tin
                                    tức</span>
                                <div class="w-1 h-1 bg-black rounded-full mx-2"></div>
                                <span class="font-semibold text-base leading-4 text-black">15.10.2025</span>
                            </div>
                            <h3 class="text-lg font-semibold text-black leading-6 mt-1">
                                Top 17 hồ bơi TPHCM đẹp và sang chảnh nhất | Vườn An Nam
                            </h3>
                            <div class="flex justify-between">
                                <p class="text-[15px] text-[#3A3A3A] font-medium leading-5">
                                    Đèn hồ bơi Halogen của Sagocomposite được thiết kế riêng cho các hồ bơi nổi.
                                </p>
                                <a href="#" class="flex items-center">
                                    <span
                                        class="border rounded-full w-10 h-10 mx-1 text-[#909090] flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-button-prev news-prev !w-10 !h-10 !rounded-full !bg-white !shadow"></div>
            <div class="swiper-button-next news-next !w-10 !h-10 !rounded-full !bg-white !shadow"></div>
        </div>
    </div>
</section>
