@php
    $bodyClass = collect([
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

    // Global label blog
    $blog = \Statamic\Facades\GlobalSet::findByHandle('blog_label_information')
        ?->in(\Statamic\Facades\Site::current()->handle())
        ?->toAugmentedArray();

    $isCategory = ($page->taxonomy ?? null) !== null;

    // Banner page
    $blogMainImage = \Statamic\Facades\Entry::query()
        ->where('collection', 'pages')
        ->where('slug', 'berita-dan-artikel')
        ->first()?->featured_image;

    // Banner category
    $heroImage = $page->hero_banner_image ?? ($page->featured_image ?? $blogMainImage);

    // Content opening
    $opening = collect($page->sections ?? [])->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'opening-blog',
    );

    // Kategori post ini (buat filter related)
    $currentCategorySlugs = collect($page->categories ?? [])
        ->map(fn($cat) => $cat->slug())
        ->all();

    // Grid post terkait
    $relatedQuery = \Statamic\Facades\Entry::query()
        ->where('collection', 'posts')
        ->whereStatus('published')
        ->where('id', '!=', $page->id())
        ->orderBy('date', 'desc');

    if (!empty($currentCategorySlugs)) {
        $relatedQuery->whereTaxonomyIn(collect($currentCategorySlugs)->map(fn($s) => 'categories::' . $s)->all());
    }

    $posts = $relatedQuery->limit(3)->get();

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
        <x-layouts.header.single-header />
    @endif

    <main>
        <section id="single-blog">
            <div class="container my-18 md:my-18 lg:my-30">
                <article class="flex flex-col gap-10">

                    {{-- Heading + Meta data --}}
                    <div id="header-article" class="flex flex-col gap-6">
                        <div class="flex items-center gap-5">
                            @if ($page->date)
                                <a
                                    class="uppercase text-(--color-primary) tracking-wider">{{ $page->date->format('d.m.Y') }}</a>
                            @endif

                            @if ($page->categories && $page->categories->isNotEmpty())
                                <span class="flex items-center gap-2">
                                    @foreach ($page->categories as $category)
                                        <a href="{{ $category->url() }}"
                                            class="uppercase text-(--color-primary) tracking-wider">
                                            {{ $category->title }}
                                        </a>
                                        @unless ($loop->last)
                                            <span class="text-(--color-primary)">,</span>
                                        @endunless
                                    @endforeach
                                </span>
                            @endif
                        </div>

                        <h1 class="heading-single text-5xl w-full lg:w-[80%]">{{ $page->title }}</h1>
                    </div>

                    {{-- Content blog --}}
                    <div id="content-article"
                        class="richtext flex flex-col md:flex-row lg:flex-row gap-18 md:gap-6 lg:gap-6">

                        {{-- Kolom konten utama --}}
                        <div class="w-full md:w-[60%] lg:w-[70%] flex flex-col gap-10">

                            {{-- Gallery --}}
                            @if ($page->gallery)
                                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                                    @foreach ($page->gallery as $image)
                                        <img src="{{ $image->url() }}" alt="{{ $page->title }}"
                                            class="aspect-square w-full rounded-lg object-cover" />
                                    @endforeach
                                </div>
                            @endif

                            {{-- Content --}}
                            <div class="richtext">
                                @if ($page->description)
                                    {!! Statamic::modify($page->description)->widont() !!}
                                @endif
                            </div>

                        </div>

                        {{-- Sidebar --}}
                        <aside class="w-full md:w-[40%] lg:w-[30%] flex flex-col gap-8">

                            {{-- Kategori --}}
                            @if ($categories->isNotEmpty())
                                <div id="sidebar-categories"
                                    class="bg-(--color-surface) rounded-3xl p-6 flex flex-col gap-8">
                                    <p class="uppercase text-black font-medium">
                                        {{ $blog['category_labels'] ?? 'Kategori' }}</p>
                                    <ul class="flex flex-col list-none pl-0 mb-0">
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
                            <div id="sidebar-latest" class="bg-(--color-surface) rounded-3xl p-6 flex flex-col gap-8">
                                <p class="uppercase text-black font-medium">
                                    {{ $blog['latest_blog_label'] ?? 'Terbaru' }}</p>
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

                            {{-- Share --}}
                            <div id="share-icon"
                                class="bg-(--color-surface) rounded-3xl p-6 flex flex-row gap-4 items-center justify-between">
                                <p class="uppercase text-black font-medium">{{ $blog['label_share'] ?? 'Share' }}</p>
                                <div class="flex items-center gap-4"></div>
                            </div>

                        </aside>
                    </div>

                </article>
            </div>
        </section>

        {{-- Berita terkait --}}
        @if ($hasBlogSkin && $posts->isNotEmpty())
            <section id="related-news" class="bg-(--color-surface)">
                <div class="container py-18 md:py-18 lg:pt-30 lg:pb-50 lg:-mb-20">
                    <div class="flex flex-col gap-8">
                        <h2>{{ $blog['related_news_labels'] ?? 'Berita Terkait' }}</h2>
                        <div id="article-grid"
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-x-4 md:gap-y-10 lg:gap-x-6 lg:gap-y-16">
                            @foreach ($posts as $post)
                                <x-layouts.skin.blog-skin :entry="$post" />
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </main>

    @if ($hasFooter)
        <x-layouts.footer.footer />
    @endif

</x-layouts.main>
