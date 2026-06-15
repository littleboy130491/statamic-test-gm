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

    // Query career published
    $careers = \Statamic\Facades\Entry::query()
        ->where('collection', 'careers')
        ->where('published', true)
        ->orderBy('date', 'desc')
        ->paginate(9);

    // Cek component
    $hasHeader = view()->exists('components.layouts.header.header');
    $hasHeroPage = view()->exists('components.layouts.hero.heropage');
    $hasCareerSkin = view()->exists('components.layouts.skin.career-skin');
    $hasFooter = view()->exists('components.layouts.footer.secondary-footer');
@endphp

<x-layouts.main :body-class="$bodyClass">

    @if ($hasHeader)
        <x-layouts.header.header />
    @endif

    <main>
        @if ($hasHeroPage)
            <x-layouts.hero.heropage :title="$title ?? 'Karier'" :image="$featured_image ?? null" />
        @endif

        <section id="careers-listing">
            <div class="container my-18 md:my-18 lg:my-30 flex flex-col gap-20">

                {{-- Grid 3 kolom --}}
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-x-4 md:gap-y-10 lg:gap-x-5 lg:gap-y-20">
                    @if ($hasCareerSkin)
                        @foreach ($careers as $entry)
                            <x-layouts.skin.career-skin :entry="$entry" :career="$career" />
                        @endforeach
                    @endif
                </div>

                {{-- Pagination --}}
                @if ($careers->hasPages())
                    <div class="careers-pagination">
                        {{ $careers->links() }}
                    </div>
                @endif

            </div>
        </section>
    </main>

    @if ($hasFooter)
        <x-layouts.footer.secondary-footer />
    @endif

</x-layouts.main>
