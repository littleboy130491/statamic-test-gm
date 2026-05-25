@extends('layouts.app')

@section('content')
    <article class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:py-16">
        <header class="text-center">
            @if ($page->hero_image)
                <div class="mb-10 flex justify-center">
                    @foreach ($page->hero_image as $image)
                        <img
                            src="{{ $image->url }}"
                            alt="{{ $page->title }}"
                            class="max-h-80 w-auto object-contain"
                        >
                    @endforeach
                </div>
            @endif

            @if ($page->product_categories)
                <p class="text-sm font-semibold uppercase tracking-widest text-emerald-600">
                    @foreach ($page->product_categories as $category)
                        {{ $category->title }}@unless($loop->last), @endunless
                    @endforeach
                </p>
            @endif

            <h1 class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 sm:text-4xl">
                {{ $page->title }}
            </h1>

            @if ($page->description)
                <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-zinc-600">
                    {{ $page->description }}
                </p>
            @endif

            @if ($page->cta_link)
                <div class="mt-8">
                    <a
                        href="{{ $page->cta_link }}"
                        class="inline-block rounded-full bg-emerald-500 px-8 py-3 text-sm font-semibold uppercase tracking-wide text-white transition hover:bg-emerald-600"
                    >
                        {{ $page->cta_label ?: 'Kontak Kami' }}
                    </a>
                </div>
            @endif
        </header>

        @if ($page->specifications)
            <section class="mt-16 rounded-lg bg-zinc-50 px-6 py-10 sm:px-10">
                <h2 class="text-center text-xl font-bold uppercase tracking-wide text-zinc-900">
                    Spesifikasi
                </h2>

                <dl class="mx-auto mt-8 grid max-w-3xl gap-x-12 sm:grid-cols-2">
                    @foreach ($page->specifications as $spec)
                        <div class="flex items-baseline justify-between gap-4 border-b border-zinc-200 py-4">
                            <dt class="shrink-0 font-semibold text-zinc-900">{{ $spec->label }}</dt>
                            <dd class="text-right text-zinc-700">{{ $spec->value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </section>
        @endif

        <p class="mt-12 text-center">
            <a href="/products" class="text-sm text-emerald-600 hover:underline">&larr; Back to products</a>
        </p>
    </article>
@endsection
