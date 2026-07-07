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
    // Slider dipakai kalau ada lebih dari 1 item. Swiper otomatis berhenti
    // scroll & menyembunyikan arrow per-breakpoint saat semua slide muat
    // (desktop: 3, tablet: 2, mobile: 1) lewat watchOverflow.
    $featuresIsSlider = $features->count() > 1;

    // Product Gallery
    $gallery = collect($page->product_gallery ?? [])
        ->filter()
        ->values();
@endphp

<x-layouts.main :body-class="$bodyClass">
    @if ($hasHeader)
        <x-layouts.header.single-header />
    @endif

    <main>

        {{-- Produk informasi --}}
        <section id="product-information">
            <article class="container">
                <div class="flex flex-col gap-10 lg:gap-15 pt-10 pb-18 lg:pt-20 lg:pb-30">

                    {{-- Featured Image --}}
                    @if ($page->featured_image)
                        <div class="flex justify-center">
                            <img src="{{ $page->featured_image->url() }}"
                                alt="{{ $page->featured_image->alt ?? $page->title }}"
                                class="w-full md:w-[80%] lg:w-[60%] aspect-video object-contain" />
                        </div>
                    @endif

                    {{-- Konten --}}
                    <div class="flex flex-col gap-3 lg:gap-6">
                        <div class="flex flex-col gap-4">
                            @if ($page->product_categories && $page->product_categories->isNotEmpty())
                                <p
                                    class="font-medium uppercase text-(--color-primary) text-left md:text-center lg:text-center">
                                    @foreach ($page->product_categories as $category)
                                        {{ $category->title }}
                                        @unless ($loop->last)
                                            ,
                                        @endunless
                                    @endforeach
                                </p>
                            @endif
                            <h1 class="heading-single text-left md:text-center lg:text-center">{{ $page->title }}</h1>
                        </div>


                        <div
                            class="flex flex-col gap-8 lg:gap-10 md:justify-center md:items-center lg:justify-center lg:items-center">
                            <div class="text-left md:text-center lg:text-center richtext w-full md:w-[80%] lg:w-[60%]">
                                {!! $page->description !!}
                            </div>

                            <div class="flex flex-wrap gap-3  md:justify-center lg:justify-center">

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
                    </div>
                </div>
            </article>
        </section>

        {{-- Features & Benefit --}}
        @if ($features->isNotEmpty())
            <section id="features-benefit">
                <div class="container">
                    <div class="py-18 md:py-18 lg:py-30 flex flex-col gap-8 lg:gap-10">
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

        {{-- Product Gallery --}}
        @if ($gallery->isNotEmpty())
            <section id="product-gallery" class="bg-(--color-surface)">
                <div class="container">
                    <div class="py-18 md:py-18 lg:py-30">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 lg:gap-6">
                            @foreach ($gallery as $image)
                                <div class="product-gallery-item">
                                    <img src="{{ $image->url() }}" alt="{{ $image->alt ?? $page->title }}"
                                        class="w-full aspect-square object-cover rounded-lg" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Comparison --}}
        @if (!empty($page->comparison))
            <section id="comparison">
                <div class="container">
                    <div class="py-18 md:py-18 lg:py-30">
                        <h2>{{ $product['comparison_labels'] ?? '' }}</h2>
                    </div>
                </div>
            </section>
        @endif

    </main>

    @if ($hasFooter)
        <x-layouts.footer.footer />
    @endif
</x-layouts.main>
