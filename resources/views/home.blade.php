@php
    $bodyClass = collect([
        $is_entry ?? false ? 'entry' : null,
        isset($collection) ? 'entry-' . $collection : null,
        isset($collection) ? $collection : null,
        isset($slug) ? 'slug-' . $slug : null,
    ])
        ->filter()
        ->implode(' ');

    $about = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'section-about',
    );

    $productCategory = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'section-product-category',
    );

    $productCategories = \Statamic\Facades\Term::query()->where('taxonomy', 'product_categories')->get();

    $services = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'section-services',
    );

    $marketplace = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'section-marketplace',
    );

    $blogSosmed = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'section-blog-sosmed',
    );

    $dealer = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'section-dealer',
    );

    $groupGm = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'section-group-gm',
    );

    $blogSection = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'section-blog',
    );

    // Resolve link
    $resolveUrl = function ($value) {
        if (!$value) {
            return null;
        }
        if (is_string($value) && str_starts_with($value, 'entry::')) {
            return \Statamic\Facades\Entry::find(str_replace('entry::', '', $value))?->url();
        }
        return $value;
    };

    // Link button
    $aboutBtn = $resolveUrl($about['button']['link'] ?? null);
    $productCategoryUrl = $resolveUrl($productCategory['link'] ?? null);

    //  Blog kategori media sosial
    $sosmedPosts = \Statamic\Facades\Entry::query()
        ->where('collection', 'posts')
        ->whereStatus('published')
        ->whereTaxonomyIn(['categories::sosial-media'])
        ->orderBy('date', 'desc')
        ->limit(3)
        ->get();

    // Cek component
    $hasHeader = view()->exists('components.layouts.header.header');
    $hasSlider = view()->exists('components.layouts.hero.slider');
    $hasHeroPage = view()->exists('components.layouts.hero.heropage');
    $hasCatProductSkin = view()->exists('components.layouts.skin.category-product-skin');
    $hasFlipService = view()->exists('components.layouts.skin.flip-service-skin');
    $hasFooter = view()->exists('components.layouts.footer.footer');
@endphp

<x-layouts.main :body-class="$bodyClass">
    @if ($hasHeader)
        <x-layouts.header.header />
    @endif

    <main>
        @if ($hasSlider)
            <x-layouts.hero.slider />
        @endif

        {{-- Tentang --}}
        @if ($about && ($about['show'] ?? false))
            <section id="{{ $about['anchor'] ?? 'about-us' }}">
                <div class="relative overflow-hidden -mt-14">

                    {{-- Background --}}
                    <div id="background-about"
                        class="overlay-section-about rounded-t-3xl lg:rounded-t-[60px] overflow-hidden">
                        <img src="{{ $about['section_images'] ?? '' }}" alt=""
                            class="w-full h-310 md:h-290 lg:h-240 object-cover pointer-events-none">
                    </div>

                    {{-- Konten --}}
                    <div class="absolute inset-0 z-10 flex items-center lg:-mt-30">
                        <div id="content-about"
                            class="container flex flex-col md:flex-col lg:flex-row gap-15 md:gap-0 lg:gap-0">

                            {{-- Kolom kiri: konten --}}
                            <div class="w-full md:w-full lg:w-[50%] flex flex-col gap-4">

                                {{-- Heading --}}
                                @if (!empty($about['heading']))
                                    <h2 class="text-(--color-heading)">{{ $about['heading'] }}</h2>
                                @endif

                                {{-- Text --}}
                                @if (!empty($about['text']))
                                    <div class="richtext">{!! $about['text'] !!}</div>
                                @endif

                                {{-- Counter grid --}}
                                @if (!empty($about['counter_grid']))
                                    <div
                                        class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-2 gap-3 lg:gap-5 my-8 w-full lg:w-[70%]">
                                        @foreach ($about['counter_grid'] as $counter)
                                            <div
                                                class="flex flex-col gap-1 items-start lg:items-center p-4 rounded-xl blur-cus bg-(--color-surface)/50 lg:bg-(--color-surface)/0">
                                                <p class="text-4xl font-medium text-(--color-primary)">
                                                    <span>{{ $counter['prefix'] ?? '' }}</span><span
                                                        class="counter-number"
                                                        data-target="{{ $counter['number'] ?? 0 }}">0</span><span>{{ $counter['suffix'] ?? '' }}</span>
                                                </p>
                                                <p class="text-(--color-body)">{{ $counter['caption'] ?? '' }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Button --}}
                                @if ($aboutBtn && !empty($about['button']['label']))
                                    <a href="{{ $aboutBtn }}" class="button button--primary w-fit">
                                        {{ $about['button']['label'] }}
                                    </a>
                                @endif

                            </div>

                            {{-- Kolom Kanan: image --}}
                            <div
                                class="w-full md:w-full lg:w-[50%] flex flex-col md:items-end lg:items-stretch justify-between gap-10">

                                {{-- Sertifikat --}}
                                @if (!empty($about['images']))
                                    <div class="flex justify-end items-center gap-2 lg:gap-6 md:-mt-18 lg:mt-0">
                                        @foreach ($about['images'] as $img)
                                            <div class="flex flex-col gap-1 bg-white p-3 rounded-xl">
                                                @if ($img->caption)
                                                    <p>{{ $img->caption }}</p>
                                                @endif
                                                <img src="{{ $img->url() }}" alt="{{ $img->alt }}"
                                                    class="w-full md:w-40 lg:w-50 object-contain">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Truk --}}
                                @if (!empty($about['image']))
                                    <div class="md:w-full lg:w-[145%]">
                                        <img src="{{ $about['image']->url() }}" alt="{{ $about['heading'] ?? '' }}"
                                            class="w-full object-cover lg:-ml-60 lg:-mr-40 lg:-mb-50" />
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </section>
        @endif

        {{-- Produk Kategori --}}
        @if ($productCategory && ($productCategory['show'] ?? false))
            <section id="{{ $productCategory['anchor'] ?? 'category-product' }}">
                <div class="bg-white relative rounded-t-3xl lg:rounded-t-[60px] -mt-10 lg:-mt-12">
                    <div class="container pt-18 pb-32 md:pt-18 md:pb-32 lg:pt-30 lg:pb-45">
                        <div
                            class="flex flex-col md:flex-row lg:flex-row justify-between items-start md:items-end lg:items-end flex-wrap gap-8 md:gap-8 lg:gap-10">

                            {{-- Heading --}}
                            <div id="heading-product-category" class="flex flex-col gap-2 w-full md:w-[65%] lg:w-[55%]">
                                @if (!empty($productCategory['heading']))
                                    <h2 class="text-(--color-heading)">{{ $productCategory['heading'] }}</h2>
                                @endif
                                @if (!empty($productCategory['description']))
                                    <p class="color-(--color-text)">{{ $productCategory['description'] }}</p>
                                @endif
                            </div>

                            {{-- Button --}}
                            <div id="button-product-category" class="order-last md:order-0 lg:order-0">
                                @if ($productCategoryUrl && !empty($productCategory['label']))
                                    <a href="{{ $productCategoryUrl }}" class="button button--primary">
                                        {{ $productCategory['label'] }}
                                    </a>
                                @endif
                            </div>

                            {{-- Kategori Produk --}}
                            @if ($hasCatProductSkin && $productCategories->isNotEmpty())
                                <div class="category-slider relative w-full">

                                    {{-- Arrow Prev --}}
                                    <button type="button"
                                        class="category-prev rounded-full absolute -left-3 lg:-left-7 top-[45%] z-10 w-10 h-10 md:w-10 md:h-10 lg:w-14 lg:h-14 text-(--color-primary) hover:text-white bg-(--color-surface) hover:bg-(--color-primary) p-3 md:p-3 lg:p-4">
                                        <svg class="rotate-180 w-full h-full" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>

                                    {{-- Arrow Next --}}
                                    <button type="button"
                                        class="category-next rounded-full absolute -right-3 lg:-right-7 top-[45%] z-10 w-10 h-10 md:w-10 md:h-10 lg:w-14 lg:h-14 text-(--color-primary) hover:text-white bg-(--color-surface) hover:bg-(--color-primary) p-3 md:p-3 lg:p-4">
                                        <svg class="w-full h-full" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>

                                    <div class="swiper category-swiper">
                                        <div class="swiper-wrapper">
                                            @foreach ($productCategories as $term)
                                                <div class="swiper-slide h-auto">
                                                    <x-layouts.skin.category-product-skin :term="$term" />
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Layanan --}}
        @if ($services && ($services['show'] ?? false))
            <section id="{{ $services['anchor'] ?? 'layanan' }}">
                <div class="relative overflow-hidden -mt-14">

                    {{-- Background --}}
                    <div id="background-services"
                        class="overlay-section-services rounded-t-3xl lg:rounded-t-[60px] overflow-hidden">
                        <img src="{{ $services['background_image'] ?? '' }}" alt=""
                            class="w-full h-300 md:h-220 lg:h-190 object-cover pointer-events-none">
                    </div>

                    {{-- Konten --}}
                    <div class="absolute inset-0 z-10 flex items-center">
                        <div id="content-services" class="container flex flex-col gap-8 lg:gap-10">

                            <div id="content-service"
                                class="flex flex-col gap-2 items-start md:items-center lg:items-center">
                                {{-- Heading --}}
                                @if (!empty($services['heading']))
                                    <h2 class="text-(--color-heading) text-start md:text-center lg:text-center">
                                        {{ $services['heading'] }}</h2>
                                @endif

                                {{-- Text --}}
                                @if (!empty($services['description']))
                                    <div
                                        class="richtext text-start md:text-center lg:text-center w-full md:w-[60%] lg:w-[55%]">
                                        {!! $services['description'] !!}</div>
                                @endif
                            </div>

                            @if ($hasFlipService && !empty($services['flip_content']))
                                <div id="flip-services" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                                    @foreach ($services['flip_content'] as $flip)
                                        <x-layouts.skin.flip-service-skin :flip="$flip" />
                                    @endforeach
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
            </section>
        @endif

        {{-- Marketplace --}}
        @if ($marketplace && ($marketplace['show'] ?? false))
            <section id="{{ $marketplace['anchor'] ?? 'marketplace' }}">
                <div class="container">
                    <div class="mb-18 md:mb-18 lg:mb-30 flex flex-col gap-6 md:gap-8 lg:gap-10">

                        <div class="flex gap-6 items-center">
                            {{-- Heading --}}
                            @if (!empty($marketplace['heading']))
                                <p class="text-(--color-primary) uppercase">
                                    {{ $marketplace['heading'] }}</p>
                                <span class="flex-1 border-t border-[#E8E8E8] flex"></span>
                            @endif
                        </div>

                        {{-- Marketplace --}}
                        @if (!empty($marketplace['marketplace']))
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-2 md:gap-6 lg:gap-6">
                                @foreach ($marketplace['marketplace'] as $item)
                                    @php
                                        $mpUrl = trim($item['marketplace_url'] ?? '');
                                        $mpValid = $mpUrl && $mpUrl !== '#';
                                    @endphp

                                    @if (!empty($item['marketplace_logo']))
                                        @if ($mpValid)
                                            <a href="{{ $mpUrl }}" target="_blank" rel="noopener noreferrer"
                                                class="transition-opacity hover:opacity-70 border border-(--color-surface) md:border-0 lg:border-0 rounded-xl p-4">
                                                <img src="{{ $item['marketplace_logo']?->url() }}" alt=""
                                                    class="h-10 lg:h-14 object-contain mx-auto">
                                            </a>
                                        @else
                                            <div
                                                class="border border-(--color-surface) md:border-0 lg:border-0 rounded-xl p-4">
                                                <img src="{{ $item['marketplace_logo']?->url() }}" alt=""
                                                    class="h-10 lg:h-14 object-contain mx-auto">
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </section>
        @endif

        {{-- Blog Katagori Media Sosial --}}
        @if ($blogSosmed && ($blogSosmed['show'] ?? false))
            <section id="{{ $blogSosmed['anchor'] ?? 'social-media-blog' }}">
                <div class="container">
                    <div class="my-18 md:my18 lg:my-30 flex flex-col gap-8 lg:gap-10">

                        {{-- Heading --}}
                        <div class="flex flex-col gap-2">
                            @if (!empty($blogSosmed['heading']))
                                <h2 class="text-(--color-heading)">{{ $blogSosmed['heading'] }}</h2>
                            @endif

                            {{-- Text --}}
                            @if (!empty($blogSosmed['description']))
                                <div class="richtext w-full md:w-full lg:w-[50%]">
                                    {!! $blogSosmed['description'] !!}</div>
                            @endif
                        </div>

                        {{-- Konten --}}
                        @if ($sosmedPosts->isNotEmpty())
                            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6">
                                @foreach ($sosmedPosts as $entry)
                                    <x-layouts.skin.sosmed-blog-skin :entry="$entry" />
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </section>
        @endif


    </main>
    @if ($hasFooter)
        <x-layouts.footer.footer />
    @endif
</x-layouts.main>
