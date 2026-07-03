@props(['entry', 'blog' => null])

@php
    $blog =
        $blog ??
        \Statamic\Facades\GlobalSet::findByHandle('blog_label_information')
            ?->in(\Statamic\Facades\Site::current()->handle())
            ?->toAugmentedArray();

    $displayCats = collect($entry->categories ?? [])->take(1);
@endphp

<article class="group">
    <a href="{{ $entry->url() }}">
        <div class="flex flex-col gap-3 uppercase text-(--color-primary) font-medium">

            {{-- Kategori - Tanggal --}}
            <div class="flex gap-5">
                @if ($displayCats->isNotEmpty())
                    <span>
                        @foreach ($displayCats as $category)
                            {{ $category->title }}
                            @unless ($loop->last)
                                ,
                            @endunless
                        @endforeach
                    </span>
                    @if ($entry->date)
                        <span>•</span>
                    @endif
                @endif
                @if ($entry->date)
                    <span>{{ $entry->date->format('d.m.Y') }}</span>
                @endif
            </div>

            {{-- Heading --}}
            <div class="richtext custom-heading-blog">
                <h2 class="text-(--color-heading) text-2xl title-display group-hover:text-(--color-primary)">
                    {{ $entry->title }}
                </h2>
            </div>
        </div>
    </a>
</article>
