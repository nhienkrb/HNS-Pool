<div class="container mx-auto px-4 py-4">
    <!-- Start dự án -->
    <section>
        <div class="header-gt flex justify-center my-[40px]">
            <h3 class="text-4xl font-bold uppercase">Dự án nổi bật</h3>
        </div>
        <div class="grid grid-cols-12 gap-6">
            <div class="col-12 md:col-span-6">
                <div class="relative rounded-lg overflow-hidden">
                    <img src="@asset('images/trip1.png')" class="w-full h-64 object-cover" />
                    <div
                        class="uppercase absolute font-semibold bottom-0 left-0 w-full bg-linear-to-t from-black/60 to-transparent text-white text-xl p-4">
                        RESORT OCEAN BAY PHÚ QUỐC
                    </div>
                </div>
            </div>

            @foreach ($projects as $project)
                <div class="col-12 md:col-span-6">
                    <x-card-project :project="$project" />
                </div>
            @endforeach

    </section>
    <!-- End dự án -->
</div>
