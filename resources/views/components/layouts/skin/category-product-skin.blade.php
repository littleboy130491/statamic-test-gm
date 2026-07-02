@props(['term', 'product' => null])

@php
    $product =
        $product ??
        \Statamic\Facades\GlobalSet::findByHandle('product_label_information')
            ?->in(\Statamic\Facades\Site::current()->handle())
            ?->toAugmentedArray();
@endphp

<a href="{{ $term->url() }}"
    class="group/card flex flex-col gap-4 rounded-2xl lg:rounded-3xl border border-(--color-line) overflow-hidden p-4 md:p-4 lg:p-6 hover:bg-(--color-surface) hover:border-(--color-surface)">

    {{-- Image --}}
    <div>
        <img src="{{ $term->images?->url() ?? ($product['image_placeholders'] ?? '') }}" alt="{{ $term->title }}"
            class="w-full aspect-square object-contain transition-transform duration-500" />
    </div>

    {{-- Title --}}
    <p
        class="text-center title-display text-(--color-heading) md:text-sm lg:text-xl tracking-tight group-hover/card:text-(--color-primary) transition-colors">
        {{ $term->title }}
    </p>

</a>
