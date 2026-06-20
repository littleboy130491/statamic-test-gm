@props(['entry', 'blog' => null])

@php
    $blog =
        $blog ??
        \Statamic\Facades\GlobalSet::findByHandle('blog_label_information')
            ?->in(\Statamic\Facades\Site::current()->handle())
            ?->toAugmentedArray();
@endphp

<article class="group">
    <a href="{{ $entry->url() }}">
        <div class="flex flex-col gap-2 uppercase text-(--color-primary) font-medium">

            {{-- Kategori - Tanggal --}}
            <div class="flex gap-5">
                @if ($entry->categories && $entry->categories->isNotEmpty())
                    <span>
                        @foreach ($entry->categories as $category)
                            {{ $category->title }}
                            @unless ($loop->last)
                                ,
                            @endunless
                        @endforeach
                    </span>
                @endif
                @if ($entry->date)
                    <span>•</span>
                    <span>{{ $entry->date->format('d.m.Y') }}</span>
                @endif
            </div>

            {{-- Heading --}}
            <div class="richtext">
                <h4 class="text-(--color-heading) title-display group-hover:text-(--color-primary)">{{ $entry->title }}
                </h4>
            </div>
        </div>
    </a>
</article>
