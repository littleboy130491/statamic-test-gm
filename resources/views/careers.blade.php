<x-layouts.app>
    @php
        $careers = Statamic::tag('collection:careers')
            ->sort('title:asc')
            ->fetch();

        $employmentLabels = [
            'full_time' => 'Full Time',
            'part_time' => 'Part Time',
            'contract' => 'Contract',
            'internship' => 'Internship',
            'temporary' => 'Temporary',
        ];
    @endphp

    <div class="mx-auto w-full max-w-6xl px-4 py-8">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $page->title }}</h1>
            @if ($page->content)
                <div class="prose prose-zinc dark:prose-invert mt-3 max-w-none">{!! $page->content !!}</div>
            @endif
        </header>

        <aside class="mb-8 grid gap-6 sm:grid-cols-2">
            <div class="rounded-xl bg-white p-4 shadow dark:bg-zinc-950">
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wide text-zinc-500">Locations</h2>
                <ul class="flex flex-wrap gap-2">
                    <s:taxonomy:locations>
                        <li>
                            <a href="{{ $url }}" class="rounded-full bg-zinc-100 px-3 py-1 text-sm text-zinc-700 hover:bg-emerald-100 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-emerald-900/40">
                                {{ $title }}
                            </a>
                        </li>
                    </s:taxonomy:locations>
                </ul>
            </div>

            <div class="rounded-xl bg-white p-4 shadow dark:bg-zinc-950">
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wide text-zinc-500">Tags</h2>
                <ul class="flex flex-wrap gap-2">
                    <s:taxonomy:tags>
                        <li>
                            <a href="{{ $url }}" class="rounded-full bg-zinc-100 px-3 py-1 text-sm text-zinc-700 hover:bg-emerald-100 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-emerald-900/40">
                                {{ $title }}
                            </a>
                        </li>
                    </s:taxonomy:tags>
                </ul>
            </div>
        </aside>

        <section class="grid gap-4">
            @forelse ($careers as $career)
                <article class="rounded-xl bg-white p-6 shadow dark:bg-zinc-950">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold">
                                <a href="{{ $career->url }}" class="text-emerald-700 hover:underline dark:text-emerald-400">{{ $career->title }}</a>
                            </h2>

                            <div class="mt-2 flex flex-wrap gap-x-3 gap-y-1 text-sm text-zinc-600 dark:text-zinc-400">
                                @if ($career->employment_status)
                                    <span>{{ $employmentLabels[$career->employment_status] ?? Str::title(str_replace('_', ' ', $career->employment_status)) }}</span>
                                @endif

                                @if ($career->locations)
                                    <span>
                                        @foreach ($career->locations as $location)
                                            {{ $location->title }}@unless($loop->last), @endunless
                                        @endforeach
                                    </span>
                                @endif

                                @if ($career->tags)
                                    <span>
                                        @foreach ($career->tags as $tag)
                                            {{ $tag->title }}@unless($loop->last), @endunless
                                        @endforeach
                                    </span>
                                @endif
                            </div>

                            @if ($career->description)
                                <div class="prose prose-zinc dark:prose-invert mt-3 max-w-none text-sm">
                                    {!! Str::limit(strip_tags($career->description), 200) !!}
                                </div>
                            @endif
                        </div>

                        <a href="{{ $career->url }}" class="shrink-0 text-sm font-medium text-emerald-600 hover:underline">View role</a>
                    </div>
                </article>
            @empty
                <p class="text-zinc-600 dark:text-zinc-400">No open positions at the moment.</p>
            @endforelse
        </section>
    </div>
</x-layouts.app>
