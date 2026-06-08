@props(['title', 'image', 'height' => 'min-h-[300px] md:min-h-[300px] lg:min-h-[500px]'])

@php
    // Resolve URL gambar utama (kalau ada)
    $imageUrl = $image?->url ?? null;
    $imageAlt = $image?->alt ?? $title;

    // Fallback: placeholder dari global set
    if (!$imageUrl) {
        $placeholder = \Statamic\Facades\GlobalSet::findByHandle('hero_page_placeholder')?->inCurrentSite()?->data();
        $placeholderRaw = $placeholder['section_images'] ?? null;

        if ($placeholderRaw) {
            $placeholderAsset = \Statamic\Facades\Asset::find('assets::' . $placeholderRaw);
            $imageUrl = $placeholderAsset?->url() ?? asset('assets/' . $placeholderRaw);
        }
    }
@endphp

<section id="hero-page" class="overflow-hidden">
    <div class="relative {{ $height }}">
        @if ($imageUrl)
            <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}"
                class="absolute inset-0 h-full w-full pointer-events-none object-cover" />
        @endif

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
