<section>
    <div class="mt-[134px] container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12"> 
            <div class="col-span-1">
                <div>
                    <img src="{{ $aboutChooseUs['img_choose'] ?? asset('images/gioi-thieu-1.png') }}" alt="Hình ảnh vì sao chọn chúng tôi" class="rounded-2xl h-[411px] w-full object-cover">
                </div>
            </div>
            <div class="col-span-1 space-y-6"> 
                <h3 class="font-bold leading-[100%] text-4xl text-[#0D4A9A]">{{ $aboutChooseUs['title']}}</h3>
                <p class="text-sm leading-7 text-[#2D2D2D]">
                    {{ $aboutChooseUs['content1']}}
                </p>

                <p class="text-sm leading-7 text-[#2D2D2D]">
                 {{ $aboutChooseUs['content2']}}
                </p>
            </div>
        </div>
    </div>
</section>
<section class="container mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-20">
        
        <div class="flex">
            <div class="w-14 h-14 bg-[#0D4A9A] rounded-full flex items-center justify-center shrink-0">
                <img src="@asset('images/Group.svg')" alt="icon" class="w-7 h-7 block">
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-bold text-[#3B3B3B]">Thiết Kế Theo Nhu Cầu Riêng</h3>
                <p class="text-sm text-[#051B2E]">Mỗi hồ bơi được tạo nên dựa trên phong cách sống, diện
                    tích và
                    sở thích của khách hàng</p>
            </div>
        </div>

        <div class="flex">
            <div class="w-14 h-14 bg-[#0D4A9A] rounded-full flex items-center justify-center shrink-0">
                <img src="@asset('images/Group.svg')" alt="icon" class="w-7 h-7 block">
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-bold text-[#3B3B3B]">Kiến Trúc Sư Giỏi Nghề</h3>
                <p class="text-sm text-[#051B2E]">Được thực hiện bởi các chuyên gia giàu kinh nghiệm, đảm
                    bảo
                    thẩm mỹ, an toàn và công năng tối ưu.</p>
            </div>
        </div>

        <div class="flex">
            <div class="w-14 h-14 bg-[#0D4A9A] rounded-full flex items-center justify-center shrink-0">
                <img src="@asset('images/Group.svg')" alt="icon" class="w-7 h-7 block">
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-bold text-[#3B3B3B]">Công Nghệ Hiện Đại</h3>
                <p class="text-sm text-[#051B2E]">Sử dụng công nghệ lọc nước, chống thấm và chiếu sáng tiên
                    tiến, giúp hồ bơi vận hành bền bỉ và tiết kiệm.</p>
            </div>
        </div>

        <div class="flex">
            <div class="w-14 h-14 bg-[#0D4A9A] rounded-full flex items-center justify-center shrink-0">
                <img src="@asset('images/Group.svg')" alt="icon" class="w-7 h-7 block">
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-bold text-[#3B3B3B]">Đa Dạng Phong Cách</h3>
                <p class="text-sm text-[#051B2E]">Từ hồ bơi gia đình đến resort cao cấp — mọi ý tưởng đều
                    được
                    hiện thực hóa tinh tế.</p>
            </div>
        </div>

        <div class="flex">
            <div class="w-14 h-14 bg-[#0D4A9A] rounded-full flex items-center justify-center shrink-0">
                <img src="@asset('images/Group.svg')" alt="icon" class="w-7 h-7 block">
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-bold text-[#3B3B3B]">Tiết Kiệm Tối Ưu</h3>
                <p class="text-sm text-[#051B2E]">Quy trình làm việc chuyên nghiệp & tiết kiệm thời gian,
                    đảm
                    bảo chất lượng.</p>
            </div>
        </div>

        <div class="flex">
            <div class="w-14 h-14 bg-[#0D4A9A] rounded-full flex items-center justify-center shrink-0">
                <img src="@asset('images/Group.svg')" alt="icon" class="w-7 h-7 block">
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-bold text-[#3B3B3B]">Bảo Hành Chu Đáo</h3>
                <p class="text-sm text-[#051B2E]">Bảo hành công trình, hỗ trợ kỹ thuật lâu dài, đảm bảo hồ
                    bơi
                    vận hành an toàn.</p>
            </div>
        </div>
    </div>
</section>