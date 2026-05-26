@extends('layouts.app')

@section('content')
    <article class="mx-auto w-full max-w-3xl px-4 py-8">
        <header class="mb-6">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $page->title }}</h1>
            <p class="mt-2 text-sm text-zinc-500">
                {{ $page->date?->format('F j, Y') }}
                @if ($page->categories)
                    &middot;
                    @foreach ($page->categories as $category)
                        <a href="{{ $category->url }}" class="text-indigo-700 hover:underline dark:text-indigo-400">{{ $category->title }}</a>@unless($loop->last), @endunless
                    @endforeach
                @endif
            </p>
        </header>

        <div class="prose prose-zinc dark:prose-invert max-w-none">
            {!! Statamic::modify($page->content)->widont() !!}
        </div>

        @if ($page->gallery)
            <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3">
                @foreach ($page->gallery as $image)
                    <img
                        src="{{ $image->url }}"
                        alt="{{ $image->alt ?? $page->title }}"
                        class="aspect-square w-full rounded-lg object-cover"
                    >
                @endforeach
            </div>
        @endif

        <p class="mt-8">
            <a href="/blog" class="text-indigo-700 hover:underline dark:text-indigo-400">&larr; Back to blog</a>
        </p>
    </article>
@endsection
