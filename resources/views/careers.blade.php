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

    $career = \Statamic\Facades\GlobalSet::findByHandle('career_label_information')
        ?->in(\Statamic\Facades\Site::current()->handle())
        ?->toAugmentedArray();

    // Query career published, 9 per halaman
    $careers = \Statamic\Facades\Entry::query()
        ->where('collection', 'careers')
        ->whereStatus('published')
        ->orderBy('date', 'desc')
        ->paginate(9);
@endphp

<x-layouts.main :body-class="$bodyClass">

    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage :title="$title ?? 'Karier'" :image="$featured_image ?? null" />

        <section id="careers-listing">
            <div class="container my-18 md:my-18 lg:my-30 flex flex-col gap-20">

                {{-- Grid 3 kolom --}}
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-x-4 md:gap-y-10 lg:gap-x-5 lg:gap-y-20">
                    @foreach ($careers as $entry)
                        <x-layouts.skin.career-skin :entry="$entry" :career="$career" />
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($careers->hasPages())
                    <div class="careers-pagination flex flex-wrap items-center gap-2">
                        @foreach ($careers->getUrlRange(1, $careers->lastPage()) as $page => $url)
                            @if ($page == $careers->currentPage())
                                <p>{{ $page }}</p>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    </div>
                @endif

            </div>
        </section>
    </main>

    <x-layouts.footer.secondary-footer />

</x-layouts.main>
