@php
    $remanSection = collect($page->sections)->first(fn($section) => (string) $section['identifier'] === 'reman');
@endphp

<x-layouts.main>
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage :title="$page->title" :image="$page->featured_image" />

        {{-- Halaman REMAN Center --}}
        <section id="reman-center">
            <div class="container">
                <div class="flex flex-col items-center my-18 gap-18 lg:my-30 lg:gap-30">
                    @if ($remanSection && $remanSection['show'])
                        <p class="text-left md:text-center lg:text-center lg:w-240">{!! $remanSection['description'] !!}</p>
                    @endif
                    <img src="" alt="" class="rounded-2xl w-full lg:h-150 object-cover">
                </div>
            </div>
        </section>

    </main>

    <x-layouts.footer.footer />
</x-layouts.main>
