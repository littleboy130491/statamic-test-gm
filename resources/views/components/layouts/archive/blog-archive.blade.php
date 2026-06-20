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

    // Content opening
    $opening = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'opening-blog',
    );

    // Grid post
    $posts = \Statamic\Facades\Entry::query()
        ->where('collection', 'posts')
        ->whereStatus('published')
        ->orderBy('date', 'desc')
        ->paginate(6);

    // Sidebar: 3 post terbaru (independen dari pagination)
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
            <x-layouts.hero.heropage :title="$page->title" :image="$page->featured_image" />
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
                <div class="flex flex-col lg:flex-row gap-6 lg:gap-6">

                    {{-- Kiri: grid card blog --}}
                    <div class="w-full lg:w-[70%] flex flex-col gap-20">
                        <div id="article-grid"
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 md:gap-x-4 md:gap-y-10 lg:gap-x-6 lg:gap-y-16">
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
                    <aside class="w-full lg:w-[30%] flex flex-col gap-6">

                        {{-- Kategori --}}
                        @if ($categories->isNotEmpty())
                            <div id="sidebar-categories" class="bg-white rounded-3xl p-6 flex flex-col gap-8">
                                <p class="uppercase text-black font-medium">Kategori</p>
                                <ul class="flex flex-col">
                                    @foreach ($categories as $category)
                                        <li
                                            class="py-3 border-b border-(--color-line) last:border-b-0 first:pt-0 last:pb-0">
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
                                            class="py-4 border-b border-(--color-line) last:border-b-0 first:pt-0 last:pb-0">
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
