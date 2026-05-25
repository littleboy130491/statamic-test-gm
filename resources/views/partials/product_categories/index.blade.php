<div class="mx-auto w-full max-w-3xl px-4 py-8">
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Product Categories</h1>
        <p class="mt-2 text-zinc-600 dark:text-zinc-400">Browse products by category.</p>
    </header>

    <ul class="space-y-3">
        <s:taxonomy:product_categories>
            <li class="rounded-xl bg-white p-4 shadow dark:bg-zinc-950">
                <a href="{{ $url }}" class="text-lg font-medium text-indigo-700 hover:underline dark:text-indigo-400">{{ $title }}</a>
                @if ($content)
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ $content }}</p>
                @endif
            </li>
        </s:taxonomy:product_categories>
    </ul>

    <p class="mt-8">
        <a href="/products" class="text-indigo-700 hover:underline dark:text-indigo-400">&larr; Back to products</a>
    </p>
</div>
