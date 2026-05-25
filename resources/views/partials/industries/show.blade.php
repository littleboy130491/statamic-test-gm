@php
    $entriesData = Statamic::tag('collection')->collection('products')->sort('title:asc')->paginate(12)->as('results')->fetch();
@endphp

<div class="mx-auto w-full max-w-3xl px-4 py-8">
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $page->title }}</h1>
        @if ($page->content)
            <p class="mt-2 text-zinc-600 dark:text-zinc-400">{{ $page->content }}</p>
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
                    <p class="mt-3 text-zinc-600 dark:text-zinc-400">{{ $entry->description }}</p>
                @endif
            </article>
        @endforeach

        @include('partials.pagination', ['paginate' => $entriesData['paginate'] ?? null])
    </section>

    <p class="mt-8">
        <a href="/products" class="text-indigo-700 hover:underline dark:text-indigo-400">&larr; Back to products</a>
    </p>
</div>
