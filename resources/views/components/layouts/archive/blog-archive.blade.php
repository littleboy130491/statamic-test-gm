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
    $hasBlogSkin = view()->exists('components.layouts.skin.blog-skin');
    $hasBlogNewSkin = view()->exists('components.layouts.skin.blog-new-skin');
    $hasFooter = view()->exists('components.layouts.footer.footer');

    $isCategory = ($page->taxonomy ?? null) !== null;

    // Banner page
    $blogMainImage = \Statamic\Facades\Entry::query()
        ->where('collection', 'pages')
        ->where('slug', 'berita-dan-artikel')
        ->first()?->featured_image;

    // Banner category
    $heroImage = $page->hero_banner_image ?? ($page->featured_image ?? (null ?? $blogMainImage));

    // Content opening
    $opening = collect($page->sections ?? [])->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'opening-blog',
    );

    // Grid post
    $postsQuery = \Statamic\Facades\Entry::query()
        ->where('collection', 'posts')
        ->whereStatus('published')
        ->orderBy('date', 'desc');

    if ($isCategory) {
        $postsQuery->whereTaxonomy('categories::' . $page->slug());
    }

    $posts = $postsQuery->paginate(8);

    // Sidebar 3 post terbaru
    $latestPosts = \Statamic\Facades\Entry::query()
        ->where('collection', 'posts')
        ->whereStatus('published')
        ->orderBy('date', 'desc')
        ->limit(3)
        ->get();

    // Sidebar kategori
    $categories = \Statamic\Facades\Term::query()->where('taxonomy', 'categories')->get();
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
            <section id="{{ $opening['anchor'] ?? 'opening-blog' }}">
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

        {{-- Article + sidebar --}}
        <section id="article-content">
            <div class="container my-18 md:my-18 lg:my-30">
                <div class="flex flex-col md:flex-row lg:flex-row gap-18 md:gap-6 lg:gap-6">

                    {{-- Grid card blog --}}
                    <div class="w-full md:w-[60%] lg:w-[70%] flex flex-col gap-20">
                        <div id="article-grid"
                            class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-6 md:gap-x-4 md:gap-y-10 lg:gap-x-6 lg:gap-y-16">
                            @if ($hasBlogSkin)
                                @foreach ($posts as $post)
                                    <x-layouts.skin.blog-skin :entry="$post" />
                                @endforeach
                            @endif
                        </div>

                        {{-- Pagination --}}
                        @if ($posts->hasPages())
                            <div class="blog-pagination">
                                {{ $posts->links() }}
                            </div>
                        @endif
                    </div>

                    {{-- Sidebar --}}
                    <aside class="w-full md:w-[40%] lg:w-[30%] flex flex-col gap-6">

                        {{-- Kategori --}}
                        @if ($categories->isNotEmpty())
                            <div id="sidebar-categories" class="bg-white rounded-3xl p-6 flex flex-col gap-8">
                                <p class="uppercase text-black font-medium">Kategori</p>
                                <ul class="flex flex-col">
                                    @foreach ($categories as $category)
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

                        {{-- Terbaru --}}
                        <div id="sidebar-latest" class="bg-white rounded-3xl p-6 flex flex-col gap-8">
                            <p class="uppercase text-black font-medium">Terbaru</p>
                            @if ($hasBlogNewSkin && $latestPosts->isNotEmpty())
                                <div class="flex flex-col">
                                    @foreach ($latestPosts as $post)
                                        <div
                                            class="py-8 border-b border-(--color-line) last:border-b-0 first:pt-0 last:pb-0">
                                            <x-layouts.skin.blog-new-skin :entry="$post" />
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    </aside>
                </div>
            </div>
        </section>

    </main>

    @if ($hasFooter)
        <x-layouts.footer.footer />
    @endif
</x-layouts.main>
