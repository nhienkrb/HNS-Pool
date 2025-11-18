<section>
    <div class="bg-[#F6FFFF] py-10"> {{-- Thêm padding dọc cho phần nền --}}
        <div class="header-gt flex justify-center mt-10">
            <h3 class="text-4xl font-bold">GIỚI THIỆU</h3>
        </div>
    </div>

    <div class="container mx-auto px-4 mt-[134px]">
        <div class=" flex justify-center mb-6">
            <h3 class="text-4xl font-bold text-[#0D4A9A]">{!! $aboutDevelop['intro'] !!}</h3>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <div class="col-span-1">
                <div>
                    <img src="{{ $aboutDevelop['image_gt'] ?? asset('images/gioi-thieu-1.png') }}" alt="Hình ảnh Giới thiệu" class="rounded-2xl h-[411px] w-full object-cover">
                        
                </div>
            </div>
            <div class="col-span-1 space-y-6"> {{-- Đã bỏ items-center không cần thiết --}}
                <h3 class="font-semibold leading-[100%] text-4xl">{!! $aboutDevelop['title'] !!}</h3>
                <p class="text-base leading-7 text-[#2D2D2D]"> {!! $aboutDevelop['content'] !!}</p>

                <p class="text-base leading-7 text-[#2D2D2D]">
                    Lời đầu tiên tôi xin thay mặt Công Ty TNHH Dịch vụ Công nghệ HNS gửi tới Quý khách hàng
                    lời
                    chào trân trọng cùng lời chúc sức khỏe và thành công. Từ khi thành lập HNS tự hào là đơn
                    vị
                    đi tiên phong trong các giải pháp hiện đại, mang lại sự tối ưu nhất về công năng và chi
                    phí,
                    đồng thời cũng nâng tầm sự trải nghiệm và tiện ích cho hồ bơi của Quý khách hàng.
                </p>
            </div>
        </div>
    </div>
</section>
