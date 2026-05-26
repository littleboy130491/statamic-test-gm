@php
    $entriesData = Statamic::tag('collection')->collection('products')->sort('title:asc')->paginate(12)->as('results')->fetch();
@endphp

<div class="mx-auto w-full max-w-3xl px-4 py-8">
    <header class="mb-8">
        @if ($page->featured_image)
            <div class="mb-6 overflow-hidden rounded-xl">
                @foreach ($page->featured_image as $image)
                    <img
                        src="{{ $image->url }}"
                        alt="{{ $page->title }}"
                        class="aspect-[21/9] w-full object-cover"
                    >
                @endforeach
            </div>
        @endif

        <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $page->title }}</h1>
        @if ($page->content)
            <div class="prose prose-zinc dark:prose-invert mt-4 max-w-none">
                {!! $page->content !!}
            </div>
        @endif
    </header>

    <section class="space-y-6">
        @foreach ($entriesData['results'] ?? [] as $entry)
            <article class="rounded-xl bg-white p-6 shadow dark:bg-zinc-950">
                <h2 class="text-xl font-semibold">
                    <a href="{{ $entry->url }}" class="text-indigo-700 hover:underline dark:text-indigo-400">{{ $entry->title }}</a>
                </h2>
                @if ($entry->sku)
                    <p class="mt-1 text-xs text-zinc-500">SKU: {{ $entry->sku }}</p>
                @endif
                @if ($entry->description)
                    <p class="mt-3 text-zinc-600 dark:text-zinc-400">{{ Str::limit(strip_tags($entry->description), 250) }}</p>
                @endif
            </article>
        @endforeach

        @include('partials.pagination', ['paginate' => $entriesData['paginate'] ?? null])
    </section>

    <p class="mt-8">
        <a href="/products" class="text-indigo-700 hover:underline dark:text-indigo-400">&larr; Back to products</a>
    </p>
</div>
