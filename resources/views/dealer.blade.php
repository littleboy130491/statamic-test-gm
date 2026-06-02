@php
    $dealerSection = collect($page->sections)->first(fn($section) => (string) $section['identifier'] === 'dealer');
@endphp

<x-layouts.main>
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage :title="$page->title" :image="$page->featured_image" />

        {{-- Halaman dealer --}}
        @if ($dealerSection && $dealerSection['show'])
            <section id="dealer-page">
                <div class="container">
                    <div class="my-18 md:my-18 lg:my-30 flow flex flex-col items-center">
                        <h2 class="text-left md:text-center lg:text-center">{{ $dealerSection['heading'] }}</h2>
                        <p class="w-full lg:w-160 text-left md:text-center lg:text-center">
                            {!! $dealerSection['description'] !!}
                        </p>
                    </div>
                </div>
            </section>
        @endif

        {{-- Maps dealer --}}
        <x-layouts.dealer-map />

    </main>

    <x-layouts.footer.footer />
</x-layouts.main>
