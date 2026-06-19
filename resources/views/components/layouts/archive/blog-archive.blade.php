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
    $hasFooter = view()->exists('components.layouts.footer.footer');

    //  Post
    $postsData = Statamic::tag('collection:posts')->sort('date:desc')->paginate(10)->as('posts')->fetch();

    //  Content opening
    $opening = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'opening-blog',
    );
@endphp

<x-layouts.main :body-class="$bodyClass">
    @if ($hasHeader)
        <x-layouts.header.header />
    @endif

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






    <div class="mx-auto w-full max-w-3xl px-4 py-8">

        <aside class="mb-8 rounded-xl bg-white p-4 shadow dark:bg-zinc-950">
            <h2 class="mb-3 text-sm font-semibold uppercase tracking-wide text-zinc-500">Categories</h2>
            <ul class="flex flex-wrap gap-2">
                <s:taxonomy:categories>
                    <li>
                        <a href="{{ $url }}"
                            class="rounded-full bg-zinc-100 px-3 py-1 text-sm text-zinc-700 hover:bg-indigo-100 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-indigo-900/40">
                            {{ $title }}
                        </a>
                    </li>
                </s:taxonomy:categories>
            </ul>
        </aside>

        <section class="space-y-6">
            @foreach ($postsData['posts'] as $post)
                <article class="rounded-xl bg-white p-6 shadow dark:bg-zinc-950">
                    <h2 class="text-xl font-semibold">
                        <a href="{{ $post->url }}"
                            class="text-indigo-700 hover:underline dark:text-indigo-400">{{ $post->title }}</a>
                    </h2>
                    <p class="mt-1 text-sm text-zinc-500">
                        {{ $post->date?->format('F j, Y') }}
                        @if ($post->categories)
                            &middot;
                            @foreach ($post->categories as $category)
                                <a href="{{ $category->url }}" class="hover:underline">{{ $category->title }}</a>
                                @unless ($loop->last)
                                    ,
                                @endunless
                            @endforeach
                        @endif
                    </p>
                    @if ($post->excerpt)
                        <p class="mt-3 text-zinc-600 dark:text-zinc-400">{{ $post->excerpt }}</p>
                    @endif
                    <a href="{{ $post->url }}"
                        class="mt-3 inline-block text-sm text-indigo-700 hover:underline dark:text-indigo-400">Read
                        more</a>
                </article>
            @endforeach

            @include('partials.pagination', [
                'paginate' => $postsData['paginate'] ?? null,
                'prevLabel' => '&larr; Newer',
                'nextLabel' => 'Older &rarr;',
            ])
        </section>
    </div>
</x-layouts.main>
