  <!-- Start Sản phẩm -->
  <section class="">
      <div class="mb-12 mt-17">
          <h2 class="text-3xl font-bold leading-[100%] text-[#0D4A9A] relative pl-6">
              <span class=" absolute left-1 top-1/2 -translate-y-1/2 w-[2px] h-6 bg-[#0D4A9A] rounded-full"></span>
              Thiết bị hệ thống lọc hồ bơi
          </h2>
      </div>

      <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">

          @foreach ($products as $product)
              <x-card :post="$product" />
          @endforeach
      </div>
  </section>
  <!-- End Sản phẩm -->
