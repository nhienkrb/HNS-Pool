<section class="bg-[#F6FFFF] py-16">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-[#0D4A9A] uppercase">Dự án tiêu biểu</h2>
    </div>

    <div class="relative  mx-auto  container">
        <div class="swiper mySwiper2">
            <div class="swiper-wrapper">
                @foreach ($featuredProjects as $project)
                    <div class="swiper-slide">
                        <div class="relative rounded-lg overflow-hidden">
                            @if (has_post_thumbnail($project->ID))
                                {!! get_the_post_thumbnail($project->ID, 'medium', ['class' => 'w-full h-64 object-cover']) !!}
                            @else
                            @endif
                            <div
                                class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/60 to-transparent text-white text-sm p-4">
                                {!! Str::upper($project->post_title) !!} </div>
                        </div>
                    </div>
                @endforeach
                <div class="swiper-slide">
                    <div class="relative rounded-lg overflow-hidden">
                        <img src="@asset('images/trip1.png')" class="w-full h-64 object-cover" />
                        <div
                            class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/60 to-transparent text-white text-sm p-4">
                            RESORT OCEAN BAY PHÚ QUỐC
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="relative rounded-lg overflow-hidden">
                        <img src="@asset('images/trip1.png')" class="w-full h-64 object-cover" />
                        <div
                            class="absolute bottom-0 left-0 w-full bg-gradient-to-tr from-black/60 to-transparent text-white text-sm p-4">
                            RESORT OCEAN BAY PHÚ QUỐC
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="relative rounded-lg overflow-hidden">
                        <img src="@asset('images/trip1.png')" class="w-full h-64 object-cover" />
                        <div
                            class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/60 to-transparent text-white text-sm p-4">
                            RESORT OCEAN BAY PHÚ QUỐC
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="relative rounded-lg overflow-hidden">
                        <img src="@asset('images/trip1.png')" class="w-full h-64 object-cover" />
                        <div
                            class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/60 to-transparent text-white text-sm p-4">
                            RESORT OCEAN BAY PHÚ QUỐC
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="swiper-button-prev text-[#0D4A9A]! w-10 h-10! bg-white! rounded-full! shadow-md!"></div>
        <div class="swiper-button-next text-[#0D4A9A]! w-10 h-10! bg-white! rounded-full! shadow-md!"></div>
    </div>

    <div class="flex justify-center mt-4">
        <button
            class="inline-block cursor-pointer bg-[#0D4A9A] text-white font-semibold py-2 px-8  rounded-tr-lg rounded-full mt-4 transition duration-300 hover:bg-[#254673]">
            Xem tất cả dự án
        </button>
    </div>
</section>
