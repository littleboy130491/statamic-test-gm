@extends('layouts.app')

@section('content')
    @php
        $postsData = Statamic::tag('collection:posts')->sort('date:desc')->paginate(10)->as('posts')->fetch();
    @endphp

    <div class="mx-auto w-full max-w-3xl px-4 py-8">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $page->title }}</h1>
            @if ($page->content)
                <div class="prose prose-zinc dark:prose-invert mt-3">{!! $page->content !!}</div>
            @endif
        </header>

        <aside class="mb-8 rounded-xl bg-white p-4 shadow dark:bg-zinc-950">
            <h2 class="mb-3 text-sm font-semibold uppercase tracking-wide text-zinc-500">Categories</h2>
            <ul class="flex flex-wrap gap-2">
                <s:taxonomy:categories>
                    <li>
                        <a href="{{ $url }}" class="rounded-full bg-zinc-100 px-3 py-1 text-sm text-zinc-700 hover:bg-indigo-100 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-indigo-900/40">
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
                        <a href="{{ $post->url }}" class="text-indigo-700 hover:underline dark:text-indigo-400">{{ $post->title }}</a>
                    </h2>
                    <p class="mt-1 text-sm text-zinc-500">
                        {{ $post->date?->format('F j, Y') }}
                        @if ($post->categories)
                            &middot;
                            @foreach ($post->categories as $category)
                                <a href="{{ $category->url }}" class="hover:underline">{{ $category->title }}</a>@unless($loop->last), @endunless
                            @endforeach
                        @endif
                    </p>
                    @if ($post->excerpt)
                        <p class="mt-3 text-zinc-600 dark:text-zinc-400">{{ $post->excerpt }}</p>
                    @endif
                    <a href="{{ $post->url }}" class="mt-3 inline-block text-sm text-indigo-700 hover:underline dark:text-indigo-400">Read more</a>
                </article>
            @endforeach

            @include('partials.pagination', [
                'paginate' => $postsData['paginate'] ?? null,
                'prevLabel' => '&larr; Newer',
                'nextLabel' => 'Older &rarr;',
            ])
        </section>
    </div>
@endsection
