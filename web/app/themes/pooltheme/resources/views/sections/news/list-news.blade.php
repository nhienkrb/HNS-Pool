<!-- News -->
<section>
    <div class="grid grid-cols-12 my-10 gap-6" style="margin-top: 30px">
        @foreach ($posts as $post)
            <div class="col-span-12 sm:col-span-6 md:col-span-4 h-[480px] ">
                <x-card-news :post="$post" />
            </div>
        @endforeach
    </div>
</section>
<!-- End News -->
