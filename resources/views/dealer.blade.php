@php
    $bodyClass = collect([
        $is_entry ?? false ? 'entry' : null,
        isset($collection) ? 'entry-' . $collection : null,
        isset($collection) ? $collection : null,
        isset($slug) ? 'slug-' . $slug : null,
    ])
        ->filter()
        ->implode(' ');

    $dealerSection = collect($page->sections)->first(
        fn($section) => (string) $section['identifier'] === 'opening-dealer',
    );
@endphp

<x-layouts.main :body-class="$bodyClass">
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage :title="$page->title" :image="$page->featured_image" />

        {{-- Halaman dealer --}}
        @if ($dealerSection && $dealerSection['show'])
            <section id="dealer-page">
                <div class="container">
                    <div class="my-18 md:my-18 lg:my-30 flow flex flex-col gap-4 items-center">
                        <h2 class="text-left md:text-center lg:text-center">{{ $dealerSection['heading'] }}</h2>
                        <div class="w-full lg:w-160 text-left md:text-center lg:text-center">
                            {!! $dealerSection['description'] !!}
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Maps dealer --}}
        <x-layouts.dealer-map />

    </main>

    <x-layouts.footer.footer />
</x-layouts.main>
