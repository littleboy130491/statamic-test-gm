<article class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
    <a href="{{ $entry->url }}" class="block">
        @if ($entry->featured_image ?? null)
            @foreach ($entry->featured_image as $image)
                <x-asset-figure
                    :asset="$image"
                    :alt="$entry->title"
                    class="aspect-video w-full object-cover"
                />
            @endforeach
        @endif
        <div class="p-5">
            <div class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-wide text-emerald-600">
                @if ($entry->categories ?? null)
                    @foreach ($entry->categories as $category)
                        <span>{{ $category->title }}</span>
                    @endforeach
                @endif
                @if ($entry->date ?? null)
                    <time datetime="{{ $entry->date }}">{{ $entry->date->format('d.m.Y') }}</time>
                @endif
            </div>
            <h3 class="mt-2 font-semibold text-zinc-900 dark:text-zinc-100">{{ $entry->title }}</h3>
            @if ($entry->excerpt ?? null)
                <p class="mt-2 line-clamp-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $entry->excerpt }}</p>
            @endif
        </div>
    </a>
</article>
