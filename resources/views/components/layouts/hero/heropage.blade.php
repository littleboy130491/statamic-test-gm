@props(['title', 'image', 'height' => 'min-h-[300px] md:min-h-[300px] lg:min-h-[500px]'])

<section id="hero-page" class="overflow-hidden">
    <div class="relative {{ $height }}">
        <img src="{{ $image->url }}" alt="{{ $image->alt }}"
            class="absolute inset-0 h-full w-full pointer-events-none object-cover" />

        <div class="heropage-overlay absolute inset-0"></div>

        <div class="absolute inset-x-0 bottom-8 ld:bottom-10 z-10">
            <div class="container">
                <h1 class="text-left text-white md:text-center lg:text-center">
                    {{ $title }}
                </h1>
            </div>
        </div>
    </div>
</section>
