@php
    $bodyClass = collect([
        'background-grey',
        $is_entry ?? false ? 'entry' : null,
        isset($collection) ? 'entry-' . $collection : null,
        isset($collection) ? $collection : null,
        isset($slug) ? 'slug-' . $slug : null,
    ])
        ->filter()
        ->implode(' ');

    // Cek component
    $hasHeader = view()->exists('components.layouts.header.header');
    $hasHeroPage = view()->exists('components.layouts.hero.heropage');
    $hasProductSkin = view()->exists('components.layouts.skin.product-skin');
    $hasFooter = view()->exists('components.layouts.footer.footer');

    // Global label product
    $product = \Statamic\Facades\GlobalSet::findByHandle('product_label_information')
        ?->in(\Statamic\Facades\Site::current()->handle())
        ?->toAugmentedArray();

    $isCategory = ($page->taxonomy ?? null) !== null;

    // Banner page
    $productMainImage = \Statamic\Facades\Entry::query()->where('collection', 'pages')->where('slug', 'produk')->first()
        ?->featured_image;

    // Banner category
    $heroImage = $page->hero_banner_image ?? ($page->featured_image ?? $productMainImage);

    // Content opening
    $opening = collect($page->sections ?? [])->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'opening-product',
    );

    // Grid produk
    $productsQuery = \Statamic\Facades\Entry::query()->where('collection', 'products')->whereStatus('published');

    if ($isCategory) {
        $productsQuery->whereTaxonomy('product_categories::' . $page->slug());
    }

    $products = $productsQuery->paginate(8);

    // Sidebar kategori produk
    $product_categories = \Statamic\Facades\Term::query()->where('taxonomy', 'product_categories')->get();

    // Sidebar industri
    $industries = \Statamic\Facades\Term::query()->where('taxonomy', 'industries')->get();
@endphp

<x-layouts.main :body-class="$bodyClass">
    @if ($hasHeader)
        <x-layouts.header.header />
    @endif

    <main>
        @if ($hasHeroPage)
            <x-layouts.hero.heropage :title="$page->title" :image="$heroImage" />
        @endif

        {{-- Text opening --}}
        @if ($opening && ($opening['show'] ?? false))
            <section id="{{ $opening['anchor'] ?? 'opening-product' }}">
                <div class="container">
                    <div class="flex flex-col items-center my-18 lg:my-30 richtext">
                        <h2 class="text-left md:text-center lg:text-center w-full md:w-[80%] lg:w-[50%]">
                            {{ $opening['heading'] ?? '' }}</h2>
                        <div class="text-left md:text-center lg:text-center w-full md:w-[80%] lg:w-[50%]">
                            {!! $opening['description'] ?? '' !!}</div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Product + sidebar --}}
        <section id="product-content">
            <div class="container my-18 md:my-18 lg:my-30">
                <div class="flex flex-col md:flex-row lg:flex-row gap-18 md:gap-5 lg:gap-5">

                    {{-- Sidebar (kiri) --}}
                    <aside class="w-full md:w-[40%] lg:w-[30%] flex flex-col gap-5">

                        {{-- Kategori produk --}}
                        @if ($product_categories->isNotEmpty())
                            <div id="sidebar-categories" class="bg-white rounded-3xl p-6 flex flex-col gap-8">
                                <p class="uppercase text-black font-medium">
                                    {{ $product['category_labels'] ?? 'Kategori' }}
                                </p>
                                <ul class="flex flex-col list-none pl-0 mb-0">
                                    @foreach ($product_categories as $category)
                                        <li
                                            class="py-4 border-b border-(--color-line) last:border-b-0 first:pt-0 last:pb-0">
                                            <a href="{{ $category->url() }}"
                                                class="text-(--color-body) hover:text-(--color-primary) transition-colors">
                                                {{ $category->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Industri --}}
                        @if ($industries->isNotEmpty())
                            <div id="sidebar-industries" class="bg-white rounded-3xl p-6 flex flex-col gap-8">
                                <p class="uppercase text-black font-medium">
                                    {{ $product['industry_labels'] ?? 'Industri' }}
                                </p>
                                <ul class="flex flex-col list-none pl-0 mb-0">
                                    @foreach ($industries as $industry)
                                        <li
                                            class="py-4 border-b border-(--color-line) last:border-b-0 first:pt-0 last:pb-0">
                                            <a href="{{ $industry->url() }}"
                                                class="text-(--color-body) hover:text-(--color-primary) transition-colors">
                                                {{ $industry->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </aside>

                    {{-- Grid card produk (kanan) --}}
                    <div class="w-full md:w-[60%] lg:w-[70%] flex flex-col gap-20">
                        <div id="product-grid"
                            class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6 md:ga p-x-4 md:gap-y-10 lg:gap-x-5 lg:gap-y-16">
                            @if ($hasProductSkin)
                                @foreach ($products as $entry)
                                    <x-layouts.skin.product-skin :entry="$entry" />
                                @endforeach
                            @endif
                        </div>

                        {{-- Pagination --}}
                        @if ($products->hasPages())
                            <div class="blog-pagination">
                                {{ $products->links() }}
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </section>

    </main>

    @if ($hasFooter)
        <x-layouts.footer.footer />
    @endif
</x-layouts.main>
