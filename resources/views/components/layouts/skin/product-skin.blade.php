@props(['entry', 'product' => null])

@php
    $product =
        $product ??
        \Statamic\Facades\GlobalSet::findByHandle('product_label_information')
            ?->in(\Statamic\Facades\Site::current()->handle())
            ?->toAugmentedArray();
@endphp

<article class="overflow-hidden">
    <a href="{{ $entry->url() }}" class="group/card flex flex-col gap-4 md:gap-4 lg:gap-5">

        {{-- Featured Image --}}
        <div class="overflow-hidden p-6 bg-white rounded-2xl lg:rounded-3xl">
            <img src="{{ $entry->featured_image?->url() ?? ($product['image_placeholders'] ?? '') }}"
                alt="{{ $entry->title }}" class="w-full aspect-square object-contain transition-transform duration-500" />
        </div>

        <div class="flex flex-col gap-1">

            {{-- Heading --}}
            <div class="richtext">
                <h2 class="text-(--color-heading) title-display text-xl">{{ $entry->title }}</h2>
            </div>

            {{-- Kategori produk --}}
            <div class="flex items-end justify-between">
                <div class="flex items-center">
                    @if ($entry->product_categories && $entry->product_categories->isNotEmpty())
                        <p
                            class="uppercase text-(--color-primary) font-medium group-hover/card:text-(--color-secondary)">
                            @foreach ($entry->product_categories as $category)
                                {{ $category->title }}
                                @unless ($loop->last)
                                    ,
                                @endunless
                            @endforeach
                        </p>
                    @endif
                </div>
            </div>

        </div>

    </a>
</article>
