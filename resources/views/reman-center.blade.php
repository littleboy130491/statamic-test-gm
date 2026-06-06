@php
    $bodyClass = collect([
        $is_entry ?? false ? 'entry' : null,
        isset($collection) ? 'entry-' . $collection : null,
        isset($collection) ? $collection : null,
        isset($slug) ? 'slug-' . $slug : null,
    ])
        ->filter()
        ->implode(' ');

    $remanSection = collect($page->sections)->first(fn($section) => (string) $section['identifier'] === 'reman');

    $imgRemanSection = collect($page->sections)->first(
        fn($section) => (string) $section['identifier'] === 'imgsection',
    );
@endphp

<x-layouts.main :body-class="$bodyClass">
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage :title="$page->title" :image="$page->featured_image" />

        {{-- Halaman REMAN Center --}}
        <section id="reman-center">
            <div class="container">
                <div class="flex flex-col items-center my-18 gap-18 lg:my-30 lg:gap-30">

                    @if ($remanSection && $remanSection['show'])
                        <div class="text-left md:text-center lg:text-center lg:w-240">{!! $remanSection['description'] !!}</div>
                    @endif

                    @if ($imgRemanSection && $imgRemanSection['show'])
                        <img src="{{ $imgRemanSection['section_images'] }}" alt=""
                            class="rounded-2xl w-full lg:h-150 object-cover">
                    @endif
                </div>
            </div>
        </section>

    </main>

    <x-layouts.footer.footer />
</x-layouts.main>
