      <!-- Sản Phẩm Của Chúng tôi -->

      <section class=" w-full mx-auto py-16 px-4">
          <div class="mb-16">
              <div class="flex justify-center text-[#0D4A9A]">
                  <h3 class="text-4xl font-bold uppercase">SẢN PHẨM CỦA CHÚNG TÔI</h3>
              </div>
          </div>

          <div class="space-y-32">

              <div class="grid grid-cols-1 md:grid-cols-2 gap-[48px] items-center">

                  <div class="col-span-1 space-y-6">
                      <h3 class="font-semibold leading-[100%] text-4xl text-[#0D4A9A] uppercase lg:text-left">
                        {!!$aboutOurProduct['title']!!}
                      </h3>
                      <p class="text-base leading-8 text-[#2D2D2D] lg:text-left">
                          {!!$aboutOurProduct['content1']!!}
                      </p>
                      <p class="text-base leading-8 text-[#2D2D2D] lg:text-left">
                     {!!$aboutOurProduct['content2']!!}
                      </p>
                  </div>

                  <div class="col-span-1">
                      <img src=" {!!$aboutOurProduct['img_product']!!} ?? @asset('images/gioi-thieu-1.png')!!}" alt="Hình ảnh Hồ Bơi"  class="rounded-2xl h-[396px] w-full object-cover shadow-xl">
                        
                  </div>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-[48px] items-center">
                  <div class="col-span-1 space-y-6 lg:order-1">
                      <h3 class="font-semibold leading-[100%] text-4xl text-[#0D4A9A] uppercase">COMPOSITE</h3>
                      <p class="text-base leading-8 text-[#2D2D2D]">
                          Hồ bơi composite là giải pháp mới được ưa chuộng nhờ độ bền vượt trội, khả năng chống
                          thấm
                          tuyệt đối và thời gian thi công nhanh chóng. Sản phẩm được chế tạo từ vật liệu composite
                          cao
                          cấp, có khả năng chịu nhiệt, chống ăn mòn và dễ bảo trì. Với thiết kế linh hoạt, màu sắc
                          đa
                          dạng và tính thẩm mỹ cao, hồ bơi composite không chỉ tiết kiệm chi phí mà còn mang đến
                          vẻ
                          đẹp sang trọng, phù hợp với mọi không gian sử dụng.
                      </p>
                      <p class="text-base leading-8 text-[#2D2D2D]">
                          Hồ bơi composite nổi bật với độ bền cao, khả năng chống thấm tuyệt đối và thi công nhanh
                          chóng. Đây là giải pháp hiện đại, tiết kiệm và phù hợp cho cả gia đình, khu nghỉ dưỡng
                          hay
                          công trình thương mại.
                      </p>
                  </div>

                  <div class="col-span-1 lg:order-2">
                      {{-- ĐÃ SỬA ĐƯỜNG DẪN --}}
                      <img src="@asset('images/gioi-thieu-1.png')" alt="Hình ảnh Composite"
                          class="rounded-2xl h-[396px] w-full object-cover shadow-xl">
                  </div>
              </div>
          </div>
      </section>
      <!-- End Sản Phẩm Của Chúng tôi  -->
