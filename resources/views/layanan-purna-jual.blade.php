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

    $purnaJual = collect($page->sections)->first(
        fn($section) => (string) ($section['type'] ?? '') === 'alternating_rows',
    );
@endphp

<x-layouts.main :body-class="$bodyClass">
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage :title="$page->title" :image="$page->featured_image" />

        @if ($purnaJual)
            {{-- Deskripsi halaman purna jual --}}
            @if (!empty($purnaJual['heading']) || !empty($purnaJual['intro']))
                <section id="purna-jual">
                    <div class="container flex flex-col items-center my-18 md:my-18 lg:my-30">
                        @if (!empty($purnaJual['heading']))
                            <h2 class="text-left md:text-center lg:text-center mb-2 md:mb-2 lg:mb-3">
                                {{ $purnaJual['heading'] }}
                            </h2>
                        @endif

                        @if (!empty($purnaJual['intro']))
                            <p class="text-left md:text-center lg:text-center lg:w-250">{!! $purnaJual['intro'] !!}</p>
                        @endif
                    </div>
                </section>
            @endif

            {{-- Konten layanan purna jual --}}
            @if (!empty($purnaJual['rows']))
                <section>
                    <div class="container my-18 md:my-18 lg:my-30">
                        <div id="purna-jual-content" class="reverse-div flex flex-col gap-20 w-full">
                            @foreach ($purnaJual['rows'] as $item)
                                <div class="flex flex-col gap-4 md:gap-4 lg:gap-6 lg:flex-row">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] ?? '' }}"
                                        class="w-full object-cover rounded-3xl h-50 md:h-60 lg:h-112 lg:w-[50%]">
                                    <div
                                        class="flex flex-col justify-center flow bg-white rounded-3xl py-8 px-5 md:px-6 lg:p-10 lg:w-[50%]">
                                        @if (!empty($item['icon']))
                                            <img src="{{ $item['icon'] }}" alt="Icon"
                                                class="w-10 h-10 mb-8 md:mb-8 lg:mb-10 lg:w-12 lg:h-12">
                                        @endif
                                        <h3>{{ $item['title'] ?? '' }}</h3>
                                        <p>{{ $item['text'] ?? '' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
        @endif
    </main>

    <x-layouts.footer.footer />
</x-layouts.main>
