 <!-- Start banner -->
 <section>
     <div class="grid grid-cols-1 md:grid-cols-4 gap-4  py-6">
         <!-- Sidebar -->
         <div class="md:col-span-1 bg-white rounded-lg shadow border border-gray-200">
             <div class="bg-[#0D4A9A] text-white font-semibold text-center py-3 rounded-t-lg">
                 DANH MỤC SẢN PHẨM
             </div>
             <ul class="divide-y divide-gray-300">
                 @if ($product_category)
                     @foreach ($product_category as $category)
                         <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                             {{ $category->name }}
                         </li>
                     @endforeach
                 @else
                     <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Thiết Bị Hệ Thống Lọc Hồ Bơi</li>
                     <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Thiết Bị Vệ Sinh Hồ Bơi</li>
                     <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Hoá Chất Xử Lý Nước Hồ Bơi</li>
                     <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Phụ Kiện Hồ Bơi</li>
                     <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Gạch Dán Hồ Bơi Và Phụ Gia</li>
                     <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Giải Pháp Công Nghệ Cho Hồ Bơi</li>
                     <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Hồ Bơi Composite</li>
                     <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Thiết Bị Spa</li>
                     <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Tư Vấn, Thiết Kế Và Xây Dựng Hồ Bơi</li>
                 @endif

             </ul>
         </div>

         <!-- Banner -->
         <div class="md:col-span-3 relative rounded-lg overflow-hidden">
             <img src="{{ $banner_pool ?: asset('images/banner_ho_boi.png') }}" alt="Hồ bơi"
                 class="w-full h-[420px] object-cover rounded-lg scale-x-[-1]">
             <h2 class="absolute top-12 left-20 transform -translate-x-1/2 text-3xl font-bold text-[#0D4A9A]">
                 HỒ BƠI
             </h2>
         </div>
     </div>
 </section>
 <!-- End banner -->
