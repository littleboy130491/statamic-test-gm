@props(['entry', 'blog' => null, 'currentCategory' => null])

@php
    $blog =
        $blog ??
        \Statamic\Facades\GlobalSet::findByHandle('blog_label_information')
            ?->in(\Statamic\Facades\Site::current()->handle())
            ?->toAugmentedArray();

    // Prioritas: 1 tag. Kalau tag kosong, fallback ke 1 kategori (aktif diprioritaskan)
    $tags = collect($entry->tags ?? []);
    $cats = collect($entry->categories ?? []);

    if ($tags->isNotEmpty()) {
        $displayTerm = $tags->first();
    } elseif ($currentCategory) {
        $displayTerm = $cats->firstWhere(fn($c) => (string) $c->slug() === (string) $currentCategory) ?? $cats->first();
    } else {
        $displayTerm = $cats->first();
    }
@endphp

<article class="group overflow-hidden rounded-3xl bg-(--color-surface) flex flex-col">
    <a href="{{ $entry->url() }}" class="flex flex-col">

        {{-- Featured Image --}}
        <div class="overflow-hidden">
            <img src="{{ $entry->featured_image?->url() ?? ($blog['image_placeholders'] ?? '') }}"
                alt="{{ $entry->title }}"
                class="w-full h-60 object-cover group-hover:scale-110 transition-transform duration-500" />
        </div>

        <div class="p-5 flex flex-col gap-10">

            {{-- Heading --}}
            <div class="richtext flex flex-col gap-4">
                <div class="flex items-center gap-5 uppercase text-(--color-primary) font-medium justify-between">
                    @if ($displayTerm)
                        <span>{{ $displayTerm->title }}</span>
                    @endif

                    @if ($entry->date)
                        <span>{{ $entry->date->format('d.m.Y') }}</span>
                    @endif
                </div>

                <div class="custom-heading-blog">
                    <h2 class="text-(--color-heading) title-display">{{ $entry->title }}</h2>
                </div>

                @if ($entry->excerpt)
                    <p>{{ \Illuminate\Support\Str::words($entry->excerpt, 18, '...') }}</p>
                @endif
            </div>

            {{-- Button --}}
            <a href="{{ $entry->url() }}"
                class="rounded-full py-2 pr-2 pl-6 flex items-center justify-between bg-white group-hover:bg-(--color-primary)">
                <p class="uppercase title-display text-(--color-primary) tracking-widest group-hover:text-white -mb-1">
                    {{ $blog['label_button'] ?? 'Selengkapnya' }}
                </p>
                <span
                    class="w-9 h-9 rounded-full bg-(--color-primary) group-hover:bg-white flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-white group-hover:text-(--color-primary)" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            </a>

        </div>

    </a>
</article>
