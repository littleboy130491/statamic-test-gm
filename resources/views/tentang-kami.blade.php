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

    $opening = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'opening-about',
    );

    $visionMission = collect($page->sections)->first(
        fn($section) => (string) ($section['type'] ?? '') === 'section_vision_mission',
    );

    $fawText = collect($page->sections)->first(fn($section) => (string) ($section['type'] ?? '') === 'text_gallery');

    $fawValue = collect($page->sections)->first(fn($section) => (string) ($section['type'] ?? '') === 'feature_grid');

    $iconPlaceholderSection = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'placeholder-icon-faw-trucks',
    );

    $iconPlaceholder = $iconPlaceholderSection['section_images'] ?? null;

    // Visi & Misi
    $vision = $visionMission['content'][0] ?? null;
    $mission = $visionMission['content'][1] ?? null;

    // Jumlah kolom grid
    $columnClassMap = [
        '1' => 'lg:grid-cols-1',
        '2' => 'md:grid-cols-2 lg:grid-cols-2',
        '3' => 'md:grid-cols-2 lg:grid-cols-3',
        '4' => 'md:grid-cols-2 lg:grid-cols-4',
    ];

    $fawColumns = $columnClassMap[(string) ($fawValue['columns'] ?? '3')] ?? 'md:grid-cols-2 lg:grid-cols-3';

    // Cek component
    $hasHeader = view()->exists('components.layouts.header.header');
    $hasHeroPage = view()->exists('components.layouts.hero.heropage');
    $hasFooter = view()->exists('components.layouts.footer.footer');
@endphp

<x-layouts.main :body-class="$bodyClass">
    @if ($hasHeader)
        <x-layouts.header.header />
    @endif

    <main>
        @if ($hasHeroPage)
            <x-layouts.hero.heropage :title="$page->title" :image="$page->featured_image" />
        @endif

        {{-- Tentang perusahaan --}}
        @if ($opening && ($opening['show'] ?? false))
            <section id="{{ $opening['anchor'] ?? 'tentang-kami' }}">
                <div class="container">
                    <div class="flow flex flex-col items-center gap-4 my-18 md:my18 lg:mt-30 lg:mb-8">
                        <h2 class="text-left md:text-center lg:text-center w-full md:w-150 lg:w-180">
                            {{ $opening['heading'] ?? '' }}
                        </h2>
                        <div class="text-left md:text-center lg:text-center w-full md:w-full lg:w-250">
                            {!! $opening['description'] ?? '' !!}</div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Visi dan misi --}}
        @if ($visionMission && ($visionMission['show'] ?? false))
            <section id="{{ $visionMission['anchor'] ?? 'visi-misi' }}">
                <div class="container">
                    <div id="background-visi-misi" class="overlay-visimisi relative my-18 md:my-18 lg:my-30 rounded-3xl">
                        <img src="{{ $visionMission['photo_background'] ?? '' }}" alt="Visi Misi Background"
                            class="rounded-xl md:rounded-xl lg:rounded-3xl w-full h-245 md:h-260 lg:h-205 object-cover pointer-events-none">

                        <div id="visi-misi-content"
                            class="absolute bottom-0 inset-0 z-2 flex flex-col-reverse gap-10 md:gap-10 px-4 md:px-6 md:flex-col-reverse lg:flex-row lg:pr-16 lg:py-10">

                            {{-- Image truk --}}
                            <div class="w-full -mb-10 lg:mb-10 lg:w-[64%] lg:-ml-25 lg:-mr-45">
                                <img src="{{ $visionMission['photo'] ?? '' }}" alt="Visi Misi">
                            </div>

                            {{-- Teks visi misi --}}
                            <div
                                class="flex flex-col md:flex-row inset-0 lg:flex-col gap-4 md:gap-4 lg:gap-8 md:w-full lg:w-[60%] lg:-ml-20">
                                @if ($vision)
                                    <div id="vision"
                                        class="glass rounded-2xl p-5 w-full md:w-[40%] lg:w-full md:p-5 lg:p-8 flex flex-col gap-6">
                                        <h3>{{ $vision['title'] ?? '' }}</h3>
                                        <div>{!! $vision['description'] ?? '' !!}</div>
                                    </div>
                                @endif

                                @if ($mission)
                                    <div id="mission"
                                        class="glass rounded-2xl p-5 w-full md:w-[60%] lg:w-full md:p-5 lg:p-8 flex flex-col md:gap-0 lg:gap-6">
                                        <h3>{{ $mission['title'] ?? '' }}</h3>
                                        <div class="mission-list-content">{!! $mission['description'] ?? '' !!}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Sertifikasi --}}
        @if ($fawText && ($fawText['show'] ?? false))
            <section id="{{ $fawText['anchor'] ?? 'faw-trucks' }}">
                <div class="container">
                    <div
                        class="flex flex-col-reverse md:flex-col-reverse lg:flex-row gap-8 md:gap-10 lg:gap-30 my-18 md:my-18 lg:my-30">

                        {{-- Faw image --}}
                        @if (!empty($fawText['gallery_grid']))
                            <div id="certificate"
                                class="w-full md:w-[60%] lg:w-[23%] flex flex-row md:flex-row lg:flex-col gap-4">
                                @foreach ($fawText['gallery_grid'] as $cert)
                                    <div class="bg-white rounded-2xl p-4 md:p-4 lg:p-6 flex flex-col gap-2">
                                        @if (!empty($cert['label']))
                                            <p>{{ $cert['label'] }}</p>
                                        @endif
                                        <img src="{{ $cert['assets_field'] ?? '' }}" alt="{{ $cert['label'] ?? '' }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Faw konten --}}
                        <div id="faw-content" class="w-full md:w-full lg:w-[70%] flex flex-col gap-5">
                            <h3>{{ $fawText['heading'] ?? '' }}</h3>
                            <div class="w-full lg:w-170">{!! $fawText['description'] ?? '' !!}</div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Keunggulan Faw Trucks --}}
        @if ($fawValue && ($fawValue['show'] ?? false) && !empty($fawValue['features']))
            <section id="{{ $fawValue['anchor'] ?? 'faw-value' }}">
                <div class="container">
                    <div class="flex flex-col gap-8 md:gap-8 lg:gap-10 my-18 md:my-18 lg:my-30">
                        <div class="flow text-left md:text-left lg:text-center">
                            <h2>{{ $fawValue['heading'] ?? '' }}</h2>
                            @if (!empty($fawValue['subheading']))
                                <p>{{ $fawValue['subheading'] }}</p>
                            @endif
                        </div>

                        {{-- Grid keunggulan --}}
                        <div data-equal-height class="grid gap-5 {{ $fawColumns }}">
                            @foreach ($fawValue['features'] as $item)
                                <div
                                    class="flex flex-col gap-14 p-6 bg-white rounded-3xl md:p-6 md:gap-14 lg:p-6 lg:gap-10">
                                    <img src="{{ $item['icon'] ?: $iconPlaceholder }}" alt="Icon"
                                        class="w-10 h-10">
                                    <div class="flow">
                                        <h4 class="text-black w-full lg:w-70">{{ $item['title'] ?? '' }}</h4>
                                        <p>{{ $item['text'] ?? '' }}</p>
                                    </div>
                                </div>
                            @endforeach
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
