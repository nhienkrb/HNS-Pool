 {{-- TOP NAV --}}
  <nav class="bg-[#F6FFFF] border-gray-200">
    <div class="flex flex-wrap justify-between items-center mx-auto container p-3 h-[77px]">

      {{-- Logo --}}
      <a href="{{ home_url('/') }}" class="flex items-center">
        <img src="@asset('/images/logo.svg')" alt="Logo" class="w-[97px] h-[58px] object-contain" />
      </a>

      {{-- Search --}}
      <div class="flex items-center space-x-6 rtl:space-x-reverse">
        <div class="relative w-full max-w-2xl mx-auto">
          <input type="text"
            placeholder="Tìm kiếm ..."
            class="w-[461px] h-[43px] pl-6 pr-14 rounded-full border border-blue-400 focus:ring-2 focus:ring-blue-300 outline-none" />

          <button
            class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full flex items-center justify-center">
            <img src="@asset('images/search-icon.svg')" alt="search">
          </button>
        </div>
      </div>

      {{-- Hotline --}}
      <div class="flex items-center space-x-6 rtl:space-x-reverse">
        <button
          class="w-[174px] h-[38px] flex justify-center items-center border rounded-3xl text-sm text-[#161A47]">
          <img src="@asset('images/phone-icon.svg')" alt="phone-icon">
          <span class="ml-2">0832700969</span>
        </button>
      </div>

    </div>
  </nav>
