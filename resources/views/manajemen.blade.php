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

    $bgDireksi = asset('assets/manajemen-back.jpg');

    $opening = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'opening-management',
    );

    $direkturUtama = collect($page->sections)->first(
        fn($section) => (string) ($section['type'] ?? '') === 'team_primary',
    );

    $teamGrids = collect($page->sections)->filter(fn($section) => (string) ($section['type'] ?? '') === 'team_grid');

    $placeholderSection = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'placeholder-tim',
    );

    $placeholderTim = $placeholderSection['section_images'] ?? null;

    // Cek component
    $hasHeader = view()->exists('components.layouts.header.header');
    $hasHeroPage = view()->exists('components.layouts.hero.heropage');
    $hasFooter = view()->exists('components.layouts.footer.footer');
@endphp

<x-layouts.main :body-class="$bodyClass">
    @if ($hasHeader)
        <x-layouts.header.header />
    @endif

    {{-- Manajemen halaman --}}
    <main>
        @if ($hasHeroPage)
            <x-layouts.hero.heropage :title="$page->title" :image="$page->featured_image" />
        @endif

        {{-- Judul halaman --}}
        @if ($opening && ($opening['show'] ?? false))
            <section id="manajemen">
                <div class="container">
                    <div class="my-18 md:my18 lg:my-30 flow flex flex-col gap-4 items-center">
                        <h2 class="text-left md:text-center lg:text-center w-full md:w-120 lg:w-155">
                            {{ $opening['heading'] ?? '' }}
                        </h2>
                        <div class="text-left md:text-center lg:text-center w-full lg:w-220">{!! $opening['description'] ?? '' !!}
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Manajemen section --}}
        <section id="manajemen-content">
            <div class="container">

                {{-- Kata sambutan --}}
                @if ($direkturUtama && ($direkturUtama['show'] ?? false))
                    <div id="highlight-management"
                        class="flex flex-col-reverse gap-6 bg-white rounded-3xl p-5 md:p-6 lg:p-10 md:flex-row lg:flex-row my-18 md:my-18 lg:my-30">
                        <div class="flex flex-col justify-between gap-8 md:gap-2 lg:gap-2 w-full md:w-[60%] lg:w-[60%]">
                            <div class="flow flex flex-col">
                                {!! $direkturUtama['bio'] ?? '' !!}
                            </div>
                            <div class="flex flex-col gap-1">
                                <p class="title-display text-xl md:text-xl lg:text-2xl">
                                    {{ $direkturUtama['name'] ?? '' }}</p>
                                <p class="uppercase text-(--color-primary)">{{ $direkturUtama['role'] ?? '' }}</p>
                            </div>
                        </div>
                        <div class="w-full md:w-[40%] lg:w-[40%] relative">
                            <img src="{{ $bgDireksi }}" alt="{{ $direkturUtama['name'] ?? '' }}"
                                class="image-grayscale pointer-events-none rounded-xl w-full md:h-105 lg:h-120 object-cover">
                            <div class="overlay-bg-management"></div>
                            <div class="flex justify-center">
                                <img src="{{ $direkturUtama['image'] ?: $placeholderTim }}"
                                    alt="{{ $direkturUtama['name'] ?? '' }}"
                                    class="w-[48%] md:w-[90%] lg:w-[52%] absolute bottom-0 z-3">
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Card manajemen --}}
                @if ($teamGrids->isNotEmpty())
                    <div id="card-manajemen" class="flex flex-col gap-18 md:gap-18 lg:gap-30 my-18 md:my-18 lg:my-30">
                        @foreach ($teamGrids as $grid)
                            @if (($grid['show'] ?? true) && !empty($grid['members']))
                                <div class="flex flex-col gap-6 md:gap-6 lg:gap-10">
                                    <h2>{{ $grid['heading'] ?? '' }}</h2>
                                    <div
                                        class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-y-8 gap-x-4 md:gap-y-10 md:gap-x-6 lg:gap-y-14 lg:gap-x-6">
                                        @foreach ($grid['members'] as $member)
                                            <div class="flex flex-col gap-4 md:gap-4 lg:gap-6 w-full">
                                                <div class="relative w-full overflow-hidden rounded-xl">
                                                    <img src="{{ $bgDireksi }}" alt=""
                                                        class="image-grayscale pointer-events-none w-full h-60 md:h-70 lg:h-140 object-cover">
                                                    <div class="overlay-bg-management"></div>
                                                    <img src="{{ $member['image'] ?: $placeholderTim }}"
                                                        alt="{{ $member['name'] ?? '' }}"
                                                        class="absolute bottom-0 left-1/2 -translate-x-1/2 h-full w-[70%] md:w-[64%] lg:w-[50%] object-contain object-bottom z-3">
                                                </div>
                                                <div class="flex flex-col gap-1">
                                                    <p class="title-display text-xl md:text-xl lg:text-2xl">
                                                        {{ $member['name'] ?? '' }}</p>
                                                    <p class="text-(--color-primary) uppercase">
                                                        {{ $member['role'] ?? '' }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

    </main>
    @if ($hasFooter)
        <x-layouts.footer.footer />
    @endif
</x-layouts.main>
