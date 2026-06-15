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
        fn($section) => (string) ($section['identifier'] ?? '') === 'opening-dealer',
    );

    // Query dealer aktif
    $dealers = \Statamic\Facades\Entry::query()
        ->where('collection', 'dealers')
        ->where('is_active', true)
        ->get()
        ->map(function ($dealer) {
            $cat = $dealer->dealer_categories?->first();
            return [
                'company' => $dealer->title,
                'address' => $dealer->address,
                'city' => $dealer->city,
                'region' => $dealer->region,
                'phone' => $dealer->phone_number,
                'whatsapp' => $dealer->whatsapp_number,
                'whatsapp_link' => $dealer->whatsapp_link,
                'maps_url' => $dealer->google_maps_url,
                'lat' => $dealer->location['latitude'] ?? null,
                'lng' => $dealer->location['longitude'] ?? null,
                'dealer-category' => $cat?->slug() ?? '',
            ];
        })
        ->filter(fn($d) => $d['lat'] && $d['lng'])
        ->values();

    // Label kategori
    $dealerCategories = \Statamic\Facades\Term::query()
        ->where('taxonomy', 'dealer_categories')
        ->get()
        ->mapWithKeys(fn($term) => [$term->slug() => $term->title]);

    // Cek component
    $hasHeader = view()->exists('components.layouts.header.header');
    $hasHeroPage = view()->exists('components.layouts.hero.heropage');
    $hasDealerMap = view()->exists('components.layouts.dealer-map');
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

        {{-- Halaman dealer --}}
        @if ($dealerSection && ($dealerSection['show'] ?? false))
            <section id="{{ $dealerSection['anchor'] ?? 'dealer-page' }}">
                <div class="container">
                    <div class="my-18 md:my-18 lg:my-30 flow flex flex-col gap-4 items-center">
                        <h2 class="text-left md:text-center lg:text-center">{{ $dealerSection['heading'] ?? '' }}</h2>
                        <div class="w-full lg:w-160 text-left md:text-center lg:text-center">
                            {!! $dealerSection['description'] ?? '' !!}
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Maps dealer --}}
        @if ($hasDealerMap)
            <x-layouts.dealer-map :dealers="$dealers" :categories="$dealerCategories" />
        @endif

    </main>

    @if ($hasFooter)
        <x-layouts.footer.footer />
    @endif
</x-layouts.main>
