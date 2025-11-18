 <!-- Start Chặng đường -->
 <section>
     <div class="space-y-4">
         <div class=" flex  justify-center mt-40">
             <h3 class="text-4xl font-bold text-[#0D4A9A]">
                 {!! $aboutJourney['title'] !!}
             </h3>
         </div>
         <div class="w-full">
             <div class="w-[964px] text-center mx-auto">
                 <p class="text-base leading-6 text-[#2D2D2D]">{!! $aboutJourney['intro_content'] !!}</p>
             </div>
         </div>
     </div>
 </section>
 <!-- End Chặng đường -->

 <!-- Start Content Chặng đường -->
 <section>
     <div class="w-full max-w-7xl mx-auto py-16 px-4">
         <!-- Timeline line -->
         <div class="relative">
             <div class="absolute top-1/2 left-0 w-full border-t border-gray-300"></div>
             <!-- 2019 -->
             <div class="grid grid-cols-3 gap-8 items-center mb-20">
                 <!-- Text left -->
                 <div>
                     <h2 class="text-4xl font-bold text-blue-800">{!! $aboutJourney['year'] !!}</h2>
                     <h3 class="text-lg font-semibold text-blue-700 mt-2">{!! $aboutJourney['title'] !!}</h3>
                     <p class="text-gray-600 mt-3"> {!! $aboutJourney['description'] !!}</p>
                     
                 </div>
                 <!-- Ảnh -->
                 <div>
                     <img src="{!!$aboutJourney['image_url'] !!}" class="rounded-lg shadow-lg" />
                 </div>

                 <!-- 2021 -->
                 <div>
                     <h2 class="text-4xl font-bold text-blue-800">2021</h2>
                     <h3 class="text-lg font-semibold text-blue-700 mt-2">THÀNH LẬP CÔNG TY</h3>
                     <p class="text-gray-600 mt-3">
                         Công ty chính thức được thành lập với định hướng cung cấp dịch vụ thiết kế và thi
                         công
                         hồ
                         bơi chất lượng
                         cao...
                     </p>
                 </div>
             </div>
             <div class="grid grid-cols-3 gap-8 items-center mb-20">
                 <!-- Text left -->

                 <!-- Ảnh -->
                 <div>
                     <img src="@asset('images/chang-duong-2019.png')" class="rounded-lg shadow-lg" />
                 </div>
                 <!-- Timeline Dot -->
                 <!-- <div class="flex justify-center">
                            <div class="w-5 h-5 bg-white border-4 border-blue-500 rounded-full"></div>
                        </div> -->

                 <div>
                     <h2 class="text-4xl font-bold text-blue-800">2020</h2>
                     <h3 class="text-lg font-semibold text-blue-700 mt-2">THÀNH LẬP CÔNG TY</h3>
                     <p class="text-gray-600 mt-3">
                         Công ty chính thức được thành lập với định hướng cung cấp dịch vụ thiết kế và thi
                         công
                         hồ
                         bơi chất lượng
                         cao...
                     </p>
                 </div>

                 <div>
                     <img src="@asset('images/chang-duong-2021.png')" class="rounded-lg shadow-lg" />
                 </div>

             </div>
         </div>
     </div>
 </section>
 <!-- End Content Chặng đường -->
