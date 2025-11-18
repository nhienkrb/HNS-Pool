
<footer class="bg-[#0D4A9A] text-white pt-12">

  <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-10 ">

    {{-- Logo + Info --}}
    <div>
      <img src="@asset('images/logo.svg')" class="w-40 mb-4" alt="Logo" />

      <p class="uppercase font-bold">POOL & COMPOSITE</p>

      <ul class="mt-5 text-base space-y-2">
        <li>📍 Địa chỉ: 30 Hoa Lan, Phường Cầu Kiệu, TP.HCM</li>
        <li>📧 Email: pooltech.hns@gmail.com</li>
        <li>☎️ Hotline: 0983 804 445</li>
      </ul>

      {{-- Register email --}}
      <div class="register-email space-y-3 mt-2 w-full max-w-md">
        <h3 class="text-xl font-semibold">Đăng ký nhận email của chúng tôi</h3>

        <div class="relative">
          <input 
            type="email"
            class="placeholder:text-gray-500 text-gray-500 w-full border border-gray-300 py-2 pl-4 pr-28 rounded focus:outline-none bg-white focus:border-blue-500"
            placeholder="Email address..."
          >

          <button
            class="absolute right-1 top-1/2 transform -translate-y-1/2 bg-[#0D4A9A] text-white py-2 px-3 cursor-pointer rounded transition text-sm"
          >
            <img src="@asset('images/Vector-right.svg')" class="h-[17px]" alt="Vector-right">
          </button>
        </div>
      </div>

    </div>

    {{-- Quick links --}}
    <div class="mx-auto">
      <h3 class="font-bold mb-4 text-xl">Liên kết nhanh</h3>

      <ul class="space-y-2 text-base">
        <li><a href="#" class="no-underline!">Giới thiệu</a></li>
        <li><a href="#" class="no-underline!">Hồ bơi</a></li>
        <li><a href="#" class="no-underline!">Composite</a></li>
        <li><a href="#" class="no-underline!">Tin tức</a></li>
        <li><a href="#" class="no-underline!">Dự án tiêu biểu</a></li>
        <li><a href="#" class="no-underline!">Liên hệ</a></li>
      </ul>
    </div>

    {{-- Fanpage --}}
    <div class="h-[149px]">
      <h4 class="font-bold mb-4 text-xl">Fanpage</h4>
      <img src="@asset('images/page-web.png')" class="rounded-md h-[149px] w-full object-cover" alt="Fanpage">
    </div>

  </div>

  <div class="mt-8">
    <hr />
  </div>

  <div class="flex justify-center items-center text-sm h-[50px] w-full">
    Copyright © 2025 Sagocomposite. Powered by HD Agency
  </div>

</footer>
