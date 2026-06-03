@php
    $purnaJual_desc = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'opening-purnajual',
    );

    $purnaJual_content = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'purnajual-content',
    );
@endphp

<x-layouts.main bodyClass="background-grey">
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage :title="$page->title" :image="$page->featured_image" />

        {{-- Deskripsi halaman purna jual --}}
        @if ($purnaJual_desc && $purnaJual_desc['show'])
            <section id="purna-jual-description">
                <div class="container flex flex-col items-center my-18 md:my-18 lg:my-30">
                    <div class="text-left md:text-center lg:text-center lg:w-250">{!! $purnaJual_desc['description'] !!}</div>
                </div>
            </section>
        @endif

        {{-- Grid layanan purna jual --}}
        @if ($purnaJual_content && $purnaJual_content['show'] && !empty($purnaJual_content['image_text_icon']))
            <section id="purna-jual-content">
                <div class="container my-18 md:my-18 lg:my-30">
                    <div id="purna-jual-content" class="reverse-div flex flex-col gap-20 w-full">
                        @foreach ($purnaJual_content['image_text_icon'] as $item)
                            <div class="flex flex-col gap-4 md:gap-4 lg:gap-6 lg:flex-row">
                                <img src="{{ $item['images'] }}" alt="{{ $item['heading'] ?? '' }}"
                                    class="w-full object-cover rounded-3xl h-50 md:h-60 lg:h-112 lg:w-[50%]">

                                <div
                                    class="flex flex-col justify-center flow bg-white rounded-3xl py-8 px-5 md:px-6 lg:p-10 lg:w-[50%]">
                                    @if (!empty($item['icon']))
                                        <img src="{{ $item['icon'] }}" alt="Icon"
                                            class="w-10 h-10 mb-8 md:mb-8 lg:mb-10 lg:w-12 lg:h-12">
                                    @endif
                                    <h3>{{ $item['heading'] ?? '' }}</h3>
                                    {!! $item['text'] !!}
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </main>

    <x-layouts.footer.footer />
</x-layouts.main>
