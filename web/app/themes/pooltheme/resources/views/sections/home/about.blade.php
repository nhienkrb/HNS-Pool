  @php $about = $about @endphp
  <section class=" max-w-screen mx-auto py-16 bg-[url('/src/img/bg-hero.svg')]">
      <div class="container mx-auto">
          <div class="grid grid-cols-12 gap-8 items-center">

              <div class="col-span-12 lg:col-span-5 relative min-h-[500px] flex justify-center items-center">
                  <div
                      class="absolute w-[300px] h-[300px] bg-cover bg-center [clip-path:polygon(...)] z-10 top-[25%] left-[25%]">
                  </div>
                  <div
                      class="absolute w-[200px] h-[200px] bg-cover bg-center [clip-path:polygon(...)] z-20 top-0 left-0">
                  </div>
                  <div
                      class="absolute w-[350px] h-[350px] border-dashed border-2 border-blue-400 rotate-45 z-30 top-[20%] left-[20%]">
                  </div>
              </div>

              <div class="col-span-12 lg:col-span-7 lg:pl-16">
                  <h2 class="text-3xl lg:text-4xl font-serif italic text-[#2077EA]">{!! $about['subtitle'] !!}</h2>
                  <h1 class="text-4xl lg:text-5xl font-extrabold mb-6 text-[#0D4A9A] leading-snug">
                      {!! $about['title'] !!}
                  </h1>

                  <p class="mb-4 text-[#3F3F3F] leading-relaxed">
                      {!! $about['content1'] !!}
                  </p>
                  <p class="mb-6 text-[#3F3F3F] leading-relaxed">
                      {!! $about['content2'] !!}
                  </p>

                  <x-button href="{{ $about['button_link'] }}">
                      {{ $about['button_text'] }}
                  </x-button>
              </div>

          </div>
      </div>
  </section>
