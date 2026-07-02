@php
    $bodyClass = collect([
        'background-grey',
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

    // Resolve link entry::ID jadi URL
    $resolveUrl = function ($value) {
        if (!$value) {
            return null;
        }
        if (is_string($value) && str_starts_with($value, 'entry::')) {
            return \Statamic\Facades\Entry::find(str_replace('entry::', '', $value))?->url();
        }
        return $value;
    };

    // Cek component
    $hasHeader = view()->exists('components.layouts.header.header');
    $hasSlider = view()->exists('components.layouts.hero.slider');
    $hasHeroPage = view()->exists('components.layouts.hero.heropage');
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

        {{-- Tentang GM --}}
        @if ($about && ($about['show'] ?? false))
            <section id="{{ $about['anchor'] ?? 'tentang-kami' }}">
                <div class="relative overflow-hidden -mt-14">

                    {{-- Background --}}
                    <div id="background-about"
                        class="overlay-section-about rounded-t-3xl lg:rounded-t-[60px] overflow-hidden">
                        <img src="{{ $about['section_images'] ?? '' }}" alt=""
                            class="w-full h-310 md:h-290 lg:h-260 object-cover pointer-events-none">
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
                                @php $aboutBtn = $resolveUrl($about['button']['link'] ?? null); @endphp
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


    </main>
    @if ($hasFooter)
        <x-layouts.footer.footer />
    @endif
</x-layouts.main>
