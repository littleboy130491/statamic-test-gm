@php
    $bodyClass = collect([
        $is_entry ?? false ? 'entry' : null,
        isset($collection) ? 'entry-' . $collection : null,
        isset($collection) ? $collection : null,
        isset($slug) ? 'slug-' . $slug : null,
    ])
        ->filter()
        ->implode(' ');

    // Cek component
    $hasHeader = view()->exists('components.layouts.header.header');
    $hasHeroPage = view()->exists('components.layouts.hero.heropage');
    $hasFooter = view()->exists('components.layouts.footer.footer');

    // Global label product
    $product = \Statamic\Facades\GlobalSet::findByHandle('product_label_information')
        ?->in(\Statamic\Facades\Site::current()->handle())
        ?->toAugmentedArray();

    $resolveUrl = function ($value) {
        if (!$value) {
            return null;
        }
        if (is_string($value) && str_starts_with($value, 'entry::')) {
            return \Statamic\Facades\Entry::find(str_replace('entry::', '', $value))?->url();
        }
        return $value;
    };

    $ctaUrl = $resolveUrl($page->cta_link);

    // Catalogue link
    $catalogue = $page->catalogue_link ?? null;
    $catalogueShow = $catalogue['displayed'] ?? false;
    $catalogueLabel = $catalogue['label'] ?? '';
    $catalogueUrl = $catalogue['url'] ?? '#';

    // Spesifikasi
    $specs = collect([
        ['label' => $product['power'] ?? '', 'value' => $page->power],
        ['label' => $product['fuel_tank_capacity'] ?? '', 'value' => $page->fuel_tank_capacity],
        ['label' => $product['torque'] ?? '', 'value' => $page->torque],
        ['label' => $product['dump_dimensions'] ?? '', 'value' => $page->dump_dimensions],
        ['label' => $product['gvw'] ?? '', 'value' => $page->gvw],
        ['label' => $product['gvc'] ?? '', 'value' => $page->gvc],
        ['label' => $product['transmission'] ?? '', 'value' => $page->transmission],
        ['label' => $product['standard_emission'] ?? '', 'value' => $page->standard_emission],
        ['label' => $product['brake_system'] ?? '', 'value' => $page->brake_system],
    ])
        ->concat(
            collect($page->product_specifications ?? [])->map(
                fn($s) => ['label' => $s['heading'] ?? '', 'value' => $s['short_description'] ?? ''],
            ),
        )
        ->filter(fn($s) => !empty($s['value']))
        ->values();

    // Features & Benefits
    $features = collect($page->features_and_benefits ?? [])
        ->filter(fn($f) => !empty($f['heading']) || !empty($f['image']))
        ->values();

    $featuresIsSlider = $features->count() > 1;

    // Product Gallery
    $gallery = collect($page->product_gallery ?? [])
        ->filter()
        ->values();

    // Background image + fallback placeholder
    $backgroundImage = $page->background_image;

    if (!$backgroundImage) {
        $placeholder = $product['background_image_placeholder'] ?? null;
        if ($placeholder) {
            $backgroundImage = is_object($placeholder)
                ? $placeholder
                : \Statamic\Facades\Asset::find('assets::' . ltrim($placeholder, '/'));
        }
    }

    //  Background pattern
    $backgroundPattern = $page->background_pattern_image;

    if (!$backgroundPattern) {
        $pattern = $product['background_pattern_image'] ?? null;
        if ($pattern) {
            $backgroundPattern = is_object($pattern)
                ? $pattern
                : \Statamic\Facades\Asset::find('assets::' . ltrim($pattern, '/'));
        }
    }
@endphp
<x-layouts.main :body-class="$bodyClass">
    @if ($hasHeader)
        <x-layouts.header.header />
    @endif

    <main>

        {{-- Produk informasi --}}
        <section id="product-information">
            <div class="relative">
                {{-- Background Hero Banner --}}
                @if ($backgroundImage)
                    <div id="background-hero-product" class="relative pointer-events-none select-none">
                        <div class="heropage-product-overlay absolute inset-0"></div>
                        <img src="{{ $backgroundImage->url() }}" alt="{{ $backgroundImage->alt ?? $page->title }}"
                            oncontextmenu="return false" draggable="false"
                            class="object-cover w-full h-[90vh] md:h-180 lg:h-185">
                    </div>
                @endif

                <article class="container absolute inset-0 z-10 flex items-start md:items-end lg:items-end">
                    <div class="flex flex-col lg:flex-row gap-15 md:gap-6 lg:gap-10 w-full">

                        {{-- Konten --}}
                        <div class="flex flex-col gap-8 lg:gap-10 w-full mt-35 md:mt-0 lg:mt-0">
                            <div class="flex flex-col gap-3">
                                @if ($page->product_categories && $page->product_categories->isNotEmpty())
                                    <p class="font-medium uppercase text-(--color-primary) text-left">
                                        @foreach ($page->product_categories as $category)
                                            {{ $category->title }}
                                            @unless ($loop->last)
                                                ,
                                            @endunless
                                        @endforeach
                                    </p>
                                @endif

                                <h1 class="heading-single text-left text-white">{{ $page->title }}</h1>
                                <div class="text-left richtext w-full text-cust">
                                    {!! $page->description !!}
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-3">

                                {{-- Button Kontak --}}
                                @if ($ctaUrl)
                                    <a href="{{ $ctaUrl }}" class="button button--primary">
                                        {{ $page->cta_label ?: '' }}
                                    </a>
                                @endif

                                {{-- Button Download Brosur --}}
                                @if ($catalogueShow)
                                    <a href="{{ $catalogueUrl }}" class="button button--secondary">
                                        {{ $catalogueLabel }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Featured Image --}}
                        @if ($page->featured_image)
                            <div class="flex justify-center md:justify-end w-full pointer-events-none">
                                <img src="{{ $page->featured_image->url() }}"
                                    alt="{{ $page->featured_image->alt ?? $page->title }}"
                                    class="w-full md:w-[50%] lg:w-[90%] object-contain md:-mb-16 lg:-mb-20" />
                            </div>
                        @endif

                    </div>

                </article>
            </div>
        </section>

        {{-- Features & Benefit --}}
        @if ($features->isNotEmpty())
            <section id="features-benefit">
                <div class="container">
                    <div class="mb-18 mt-24 md:mb-18 lg:my-30 flex flex-col gap-8 lg:gap-10">
                        <div class="flex items-center justify-between gap-4">
                            <h2>{{ $product['benefit_label'] ?? '' }}</h2>

                            @if ($featuresIsSlider)
                                {{-- Arrow navigation --}}
                                <div class="flex items-center gap-3 shrink-0">
                                    {{-- Arrow Prev --}}
                                    <button type="button" aria-label="Previous"
                                        class="features-prev rounded-full w-10 h-10 lg:w-11 lg:h-11 text-(--color-primary) hover:text-white bg-(--color-surface) hover:bg-(--color-primary) p-3 transition-colors">
                                        <svg class="rotate-180 w-full h-full" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>

                                    {{-- Arrow Next --}}
                                    <button type="button" aria-label="Next"
                                        class="features-next rounded-full w-10 h-10 lg:w-11 lg:h-11 text-(--color-primary) hover:text-white bg-(--color-surface) hover:bg-(--color-primary) p-3 transition-colors">
                                        <svg class="w-full h-full" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>

                        @if ($featuresIsSlider)
                            {{-- Slider mode --}}
                            <div class="swiper features-swiper">
                                <div class="swiper-wrapper">
                                    @foreach ($features as $feature)
                                        <div class="swiper-slide bg-(--color-surface) overflow-hidden rounded-xl">
                                            <div class="features-card flex flex-col h-full">
                                                @if (!empty($feature['image']))
                                                    <div class="features-card-image">
                                                        <img src="{{ $feature['image']->url() }}"
                                                            alt="{{ $feature['image']->alt ?? ($feature['heading'] ?? '') }}"
                                                            class="w-full aspect-video object-cover" />
                                                    </div>
                                                @endif
                                                <div class="p-5 flex flex-col gap-2">
                                                    @if (!empty($feature['heading']))
                                                        <h3 class="tracking-tight">
                                                            {{ $feature['heading'] }}</h3>
                                                    @endif
                                                    @if (!empty($feature['description']))
                                                        <div class="richtext text-(--color-body)">
                                                            {!! $feature['description'] !!}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            {{-- Static mode --}}
                            <div class="md:w-1/3">
                                @foreach ($features as $feature)
                                    <div
                                        class="bg-(--color-surface) overflow-hidden rounded-xl features-card flex flex-col h-full">
                                        @if (!empty($feature['image']))
                                            <div class="features-card-image">
                                                <img src="{{ $feature['image']->url() }}"
                                                    alt="{{ $feature['image']->alt ?? ($feature['heading'] ?? '') }}"
                                                    class="w-full aspect-video object-cover" />
                                            </div>
                                        @endif
                                        <div class="p-5 flex flex-col gap-2">
                                            @if (!empty($feature['heading']))
                                                <h3 class="tracking-tight">{{ $feature['heading'] }}</h3>
                                            @endif
                                            @if (!empty($feature['description']))
                                                <div class="richtext text-(--color-body)">
                                                    {!! $feature['description'] !!}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif

        {{-- Product Gallery --}}
        @if ($gallery->isNotEmpty())
            <section id="product-gallery">
                <div class="container overflow-hidden md:overflow-visible lg:overflow-visible">
                    <div class="mb-18 md:mb-18 lg:mb-30">
                        <div class="gallery-wrapper flex flex-col gap-4">

                            {{-- Gambar besar --}}
                            <div class="gallery-main rounded-2xl overflow-hidden">
                                @foreach ($gallery as $image)
                                    <div class="gallery-slide {{ $loop->first ? '' : 'hidden' }}">
                                        <img src="{{ $image->url() }}" alt="{{ $image->alt ?? $page->title }}"
                                            class="w-full h-90 object-contain" />
                                    </div>
                                @endforeach
                            </div>

                            {{-- Thumbnail slider --}}
                            @if ($gallery->count() > 1)
                                <div class="flex items-center gap-1 md:gap-1 lg:gap-0">

                                    {{-- Prev --}}
                                    <button type="button" aria-label="Previous"
                                        class="gallery-prev shrink-0 w-4 h-4 md:w-4 md:h-4 lg:w-6 lg:h-6 text-black -ml-4 md:-ml-4 lg:-ml-6">
                                        <svg class="rotate-180 w-full h-full" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>

                                    {{-- Track thumbnail --}}
                                    <div
                                        class="gallery-thumbs-track flex overflow-x-auto scroll-smooth flex-1 scrollbar-none [&::-webkit-scrollbar]:hidden">
                                        @foreach ($gallery as $image)
                                            <button type="button"
                                                class="gallery-thumb shrink-0 mr-3 last:mr-0 w-[calc((100%-3*0.75rem)/4)] rounded-xl overflow-hidden transition-opacity {{ $loop->first ? 'opacity-100' : 'opacity-50' }}">
                                                <img src="{{ $image->url() }}" alt="{{ $image->alt ?? $page->title }}"
                                                    class="w-full h-15 md:h-15 lg:h-30 object-contain" />
                                            </button>
                                        @endforeach
                                    </div>

                                    {{-- Next --}}
                                    <button type="button" aria-label="Next"
                                        class="gallery-next shrink-0 w-4 h-4 md:w-4 md:h-4 lg:w-6 lg:h-6 text-black -mr-4 md:-mr-4 lg:-mr-6">
                                        <svg class="w-full h-full" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>

                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Specification --}}
        @if ($specs->isNotEmpty())
            <section id="specification" class="bg-(--color-surface)">
                <div class="container">
                    <div class="py-18 md:py-18 lg:py-30 flex flex-col gap-4">
                        <h2>{{ $product['spesification_labels'] ?? '' }}</h2>
                        <div id="specification-grid">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:gap-x-6 lg:gap-x-10">
                                @foreach ($specs as $spec)
                                    <div
                                        class="flex justify-between gap-4 border-b border-[#CECECE] py-4 {{ $loop->remaining < 2 ? 'sm:border-b-0' : '' }} {{ $loop->last ? 'border-b-0' : '' }}">
                                        <p class="specifi-title w-[45%] font-medium">{{ $spec['label'] }}</p>
                                        <p class="w-[55%] text-(--color-body)">{{ $spec['value'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Comparison --}}
        <section id="comparison" class="relative overflow-hidden">

            @if ($backgroundPattern)
                <div class="absolute inset-0 z-0 pointer-events-none select-none">
                    <img src="{{ $backgroundPattern->url() }}" alt="{{ $backgroundPattern->alt ?? $page->title }}"
                        oncontextmenu="return false" draggable="false"
                        class="h-full w-[40%] md:w-[50%] lg:w-100 opacity-20 lg:opacity-10 object-cover">
                </div>
            @endif

            <div class="container relative z-10">
                <div class="py-18 md:py-18 lg:py-30">
                    <h2>{{ $product['comparison_labels'] ?? '' }}</h2>

                    {{-- Compare Grid --}}
                    <div></div>
                </div>
            </div>

        </section>

    </main>

    @if ($hasFooter)
        <x-layouts.footer.footer />
    @endif
</x-layouts.main>
