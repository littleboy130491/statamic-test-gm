<x-layouts.app>
    @php
        $productsData = Statamic::tag('collection:products')->sort('title:asc')->paginate(12)->as('products')->fetch();
    @endphp

    <div class="mx-auto w-full max-w-3xl px-4 py-8">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $page->title }}</h1>
            @if ($page->content)
                <div class="prose prose-zinc dark:prose-invert mt-3">{!! $page->content !!}</div>
            @endif
        </header>

        <div class="mb-8 grid gap-4 sm:grid-cols-2">
            <aside class="rounded-xl bg-white p-4 shadow dark:bg-zinc-950">
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wide text-zinc-500">Product Categories</h2>
                <ul class="flex flex-wrap gap-2">
                    <s:taxonomy:product_categories>
                        <li>
                            <a href="{{ $url }}" class="rounded-full bg-zinc-100 px-3 py-1 text-sm text-zinc-700 hover:bg-indigo-100 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-indigo-900/40">
                                {{ $title }}
                            </a>
                        </li>
                    </s:taxonomy:product_categories>
                </ul>
            </aside>

            <aside class="rounded-xl bg-white p-4 shadow dark:bg-zinc-950">
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wide text-zinc-500">Industries</h2>
                <ul class="flex flex-wrap gap-2">
                    <s:taxonomy:industries>
                        <li>
                            <a href="{{ $url }}" class="rounded-full bg-zinc-100 px-3 py-1 text-sm text-zinc-700 hover:bg-indigo-100 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-indigo-900/40">
                                {{ $title }}
                            </a>
                        </li>
                    </s:taxonomy:industries>
                </ul>
            </aside>
        </div>

        <section class="space-y-6">
            @foreach ($productsData['products'] as $product)
                <article class="rounded-xl bg-white p-6 shadow dark:bg-zinc-950">
                    <h2 class="text-xl font-semibold">
                        <a href="{{ $product->url }}" class="text-indigo-700 hover:underline dark:text-indigo-400">{{ $product->title }}</a>
                    </h2>
                    @if ($product->sku)
                        <p class="mt-1 text-xs text-zinc-500">SKU: {{ $product->sku }}</p>
                    @endif
                    <p class="mt-2 text-sm text-zinc-500">
                        @if ($product->product_categories)
                            @foreach ($product->product_categories as $category)
                                <a href="{{ $category->url }}" class="hover:underline">{{ $category->title }}</a>@unless($loop->last), @endunless
                            @endforeach
                        @endif
                        @if ($product->product_categories && $product->industries)
                            &middot;
                        @endif
                        @if ($product->industries)
                            @foreach ($product->industries as $industry)
                                <a href="{{ $industry->url }}" class="hover:underline">{{ $industry->title }}</a>@unless($loop->last), @endunless
                            @endforeach
                        @endif
                    </p>
                    @if ($product->description)
                        <p class="mt-3 text-zinc-600 dark:text-zinc-400">{{ Str::limit(strip_tags($product->description), 250) }}</p>
                    @endif
                    <a href="{{ $product->url }}" class="mt-3 inline-block text-sm text-indigo-700 hover:underline dark:text-indigo-400">View product</a>
                </article>
            @endforeach

            @include('partials.pagination', ['paginate' => $productsData['paginate'] ?? null])
        </section>
    </div>
</x-layouts.app>
