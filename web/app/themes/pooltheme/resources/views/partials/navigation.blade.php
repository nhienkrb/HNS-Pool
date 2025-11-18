  {{-- MAIN MENU --}}
  <nav class="bg-[#0D4A9A]">
      <div class="max-w-screen-xl px-4 py-3 mx-auto">
          <div class="flex items-center justify-center">

              {{-- NẾU DÙNG MENU WORDPRESS --}}
              @if (has_nav_menu('primary_navigation'))
                  {!! wp_nav_menu([
                      'theme_location' => 'primary_navigation',
                      'menu_class' => 'flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm',
                      'container' => false,
                      'echo' => false,
                      'link_before' => '',
                      'link_after' => '',
                  ]) !!}
              @else
                  {{-- FALLBACK nếu chưa tạo menu trong WP Admin --}}
                  <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                      <li><a href="{{ home_url('/') }}" class="text-white no-underline!">Trang chủ</a></li>
                      <li><a href="#" class="text-white no-underline!">Giới thiệu</a></li>
                      <li><a href="#" class="text-white no-underline!">Hồ bơi</a></li>
                      <li><a href="#" class="text-white no-underline!">Composite</a></li>
                      <li><a href="#" class="text-white no-underline!">Tin tức</a></li>
                      <li><a href="#" class="text-white no-underline!">Dự án tiêu biểu</a></li>
                      <li><a href="#" class="text-white no-underline!">Góc tư vấn</a></li>
                      <li><a href="#" class="text-white no-underline!">Liên hệ</a></li>
                  </ul>
              @endif

          </div>
      </div>
  </nav>
