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
@endphp

<x-layouts.main :body-class="$bodyClass">
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage :title="$title ?? 'Industri'" :image="$featured_image ?? null" />

        {{-- Industri konten --}}

    </main>

    <x-layouts.footer.footer />
</x-layouts.main>
