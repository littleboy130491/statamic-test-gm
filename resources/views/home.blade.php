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

    // Cek component
    $hasHeader = view()->exists('components.layouts.header.header');
    $hasSlider = view()->exists('components.layouts.hero.slider');
    $hasFooter = view()->exists('components.layouts.footer.footer');

    $posts = \Statamic\Facades\Entry::query()
        ->where('collection', 'posts')
        ->whereStatus('published')
        ->orderBy('date', 'desc')
        ->limit(3)
        ->get();
@endphp

<x-layouts.main :body-class="$bodyClass">
    @if ($hasHeader)
        <x-layouts.header.header />
    @endif
    <main>
        @if ($hasSlider)
            <x-layouts.hero.slider />
        @endif

        <div class="container my-30 grid grid-cols-3 gap-6">
            @foreach ($posts as $entry)
                <x-layouts.skin.blog-skin :entry="$entry" />
            @endforeach
        </div>

    </main>
    @if ($hasFooter)
        <x-layouts.footer.footer />
    @endif
</x-layouts.main>
