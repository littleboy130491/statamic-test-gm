@php
    $bodyClass = collect([
        'background-grey',
        isset($collection) ? 'entry-' . $collection : null,
        isset($collection) ? $collection : null,
        isset($slug) ? 'slug-' . $slug : null,
    ])
        ->filter()
        ->implode(' ');

    $acc = \Statamic\Facades\GlobalSet::findByHandle('industry_label_information')
        ?->in(\Statamic\Facades\Site::current()->handle())
        ?->toAugmentedArray();

    $industries = \Statamic\Facades\Term::query()->where('taxonomy', 'industries')->get();
@endphp

<x-layouts.main :body-class="$bodyClass">
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage :title="$title ?? 'Industri'" :image="$featured_image ?? null" />

        <section id="industries-accordion">
            <div class="container my-18 md:my-18 lg:my-30">
                <div class="flex flex-col gap-8 md:gap-10 lg:gap-16">

                    {{-- Accordion industri --}}
                    @foreach ($industries as $industry)
                        <details class="industry-item group overflow-hidden" {{ $loop->first ? 'open' : '' }}>

                            {{-- Header --}}
                            <summary class="flex items-center justify-between gap-4 cursor-pointer">
                                <div id="accordion-heading" class="flex items-center gap-4 md:gap-4 lg:gap-8">
                                    <p
                                        class="title-display text-xl bg-white border border-white w-14 h-14 md:w-14 md:h-14 lg:w-18 lg:h-18 flex justify-center items-center rounded-full transition-colors group-open:text-(--color-primary) group-open:border-(--color-primary) group-open:bg-white/0">
                                        {{ $loop->iteration . '.' }}
                                    </p>

                                    <h3>{{ $industry->title }}</h3>
                                </div>

                                @if (!empty($acc['icon_accordion']))
                                    <img src="{{ $acc['icon_accordion'] }}" alt=""
                                        class="w-6 h-6 md:w-6 md:h-6 lg:w-8 lg:h-8 shrink-0 group-open:hidden" />
                                @endif

                                @if (!empty($acc['icon_accordion_active']))
                                    <img src="{{ $acc['icon_accordion_active'] }}" alt=""
                                        class="w-6 h-6 md:w-6 md:h-6 lg:w-8 lg:h-8 shrink-0 hidden group-open:block" />
                                @endif
                            </summary>

                            {{-- Body --}}
                            <div
                                class="flex flex-col gap-10 md:gap-10 lg:gap-15 pt-6 md:pt-4 lg:pt-6 md:pl-18 lg:pl-26">

                                {{-- Content --}}
                                <div class="flex flex-col lg:flex-row lg:items-end gap-6">
                                    @if ($industry->featured_image)
                                        <div class="w-full">
                                            <img src="{{ $industry->featured_image->url() }}"
                                                alt="{{ $industry->title }}"
                                                class="w-full rounded-2xl md:rounded-3xl lg:rounded-3xl" />
                                        </div>
                                    @endif

                                    @if ($industry->content)
                                        <div class="w-full richtext">
                                            {!! $industry->content !!}
                                        </div>
                                    @endif
                                </div>

                                {{-- Label produk terkait --}}
                                <div class="flex items-center gap-5">
                                    <p class="uppercase text-(--color-primary) font-medium">
                                        {{ $acc['related_product_label'] ?? 'Produk Terkait' }}
                                    </p>
                                    <span class="flex-1 border-t border-[#E8E8E8] hidden md:flex lg:flex"></span>
                                </div>

                                {{-- Slot produk terkait --}}
                                <div class="flex lg:flex-row lg:justify-between">
                                    <div class="industry-products">
                                    </div>

                                    {{-- Button --}}
                                    <a href="{{ $industry->url() }}" class="button button--primary">
                                        {{ $acc['button_label'] ?? 'Semua Produk' }}
                                    </a>
                                </div>

                            </div>

                        </details>

                        @unless ($loop->last)
                            <hr class="border-0 border-t border-[#CECECE]">
                        @endunless
                    @endforeach

                </div>
            </div>
        </section>

    </main>

    <x-layouts.footer.footer />
</x-layouts.main>
