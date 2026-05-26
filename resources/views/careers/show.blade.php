@extends('layouts.app')

@section('content')
    @php
        $employmentLabels = [
            'full_time' => 'Full Time',
            'part_time' => 'Part Time',
            'contract' => 'Contract',
            'internship' => 'Internship',
            'temporary' => 'Temporary',
        ];
    @endphp

    <article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:py-16">
        <header class="mb-8">
            @if ($page->tags || $page->locations)
                <p class="text-sm font-semibold uppercase tracking-widest text-emerald-600">
                    @if ($page->locations)
                        @foreach ($page->locations as $location)
                            {{ $location->title }}@unless($loop->last), @endunless
                        @endforeach
                    @endif
                    @if ($page->tags && $page->locations)
                        &middot;
                    @endif
                    @if ($page->tags)
                        @foreach ($page->tags as $tag)
                            {{ $tag->title }}@unless($loop->last), @endunless
                        @endforeach
                    @endif
                </p>
            @endif

            <h1 class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 sm:text-4xl dark:text-zinc-100">
                {{ $page->title }}
            </h1>

            @if ($page->employment_status)
                <p class="mt-2 text-zinc-600 dark:text-zinc-400">
                    {{ $employmentLabels[$page->employment_status] ?? Str::title(str_replace('_', ' ', $page->employment_status)) }}
                </p>
            @endif
        </header>

        @if ($page->description)
            <section class="mb-8">
                <div class="prose prose-zinc dark:prose-invert max-w-none">
                    {!! $page->description !!}
                </div>
            </section>
        @endif

        @if ($page->qualifications)
            <section class="mb-8">
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Qualifications</h2>
                <div class="prose prose-zinc dark:prose-invert mt-4 max-w-none">
                    {!! $page->qualifications !!}
                </div>
            </section>
        @endif

        @if ($page->jobdesc)
            <section class="mb-8">
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Job Description</h2>
                <div class="prose prose-zinc dark:prose-invert mt-4 max-w-none">
                    {!! $page->jobdesc !!}
                </div>
            </section>
        @endif

        <div class="mt-10">
            @include('partials.forms.career-apply', ['position' => $page->title])
        </div>

        @if ($page->apply_email || $page->apply_link)
            <div class="mt-6 flex flex-wrap gap-3">
                @if ($page->apply_email)
                    <a
                        href="mailto:{{ $page->apply_email }}"
                        class="inline-block rounded-full border border-emerald-500 px-6 py-2.5 text-sm font-semibold uppercase tracking-wide text-emerald-600 transition hover:bg-emerald-50 dark:text-emerald-400 dark:hover:bg-emerald-950/40"
                    >
                        Apply via Email
                    </a>
                @endif

                @if ($page->apply_link)
                    <a
                        href="{{ $page->apply_link }}"
                        class="inline-block rounded-full border border-zinc-300 px-6 py-2.5 text-sm font-semibold uppercase tracking-wide text-zinc-600 transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-400 dark:hover:bg-zinc-900"
                    >
                        External application
                    </a>
                @endif
            </div>
        @endif

        <p class="mt-12 text-center">
            <a href="/careers" class="text-sm text-emerald-600 hover:underline">&larr; Back to careers</a>
        </p>
    </article>
@endsection
