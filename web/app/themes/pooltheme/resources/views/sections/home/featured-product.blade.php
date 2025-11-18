<section class="bg-[#F6FFFF] py-10 px-4">
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-[#0D4A9A]">SẢN PHẨM NỔI BẬT</h2>
            <div class="space-x-2">

                <button
                    class=" rounded-full w-[195px] h-[51px] border border-[#616161] bg-white text-[#0D4A9A] font-semibold">Hồ
                    bơi</button>
                <button
                    class=" rounded-full w-[195px] h-[51px] border border-[#616161] bg-white text-[#0D4A9A] font-semibold">Composite</button>
            </div>
        </div>

        <div class="relative mt-6 flex items-center">

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 w-full">

                @foreach ($featuredProducts as $product)
                    <x-card :post="$product" />
                @endforeach

            </div>
        </div>

        <div class="flex justify-center mt-4">
            <button
                class="inline-block cursor-pointer bg-[#0D4A9A] text-white font-semibold py-2 px-8  rounded-tr-lg rounded-full mt-4 transition duration-300 hover:bg-[#254673]">
                Xem tất cả
            </button>
        </div>
    </div>
</section>
