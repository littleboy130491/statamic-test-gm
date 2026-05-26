@extends('layouts.app')

@section('content')
    @php
        $dealers = Statamic::tag('collection:dealers')
            ->where('is_active', true)
            ->sort('title:asc')
            ->fetch();

        $mapDealers = collect($dealers)->filter(function ($dealer) {
            return $dealer->location?->latitude && $dealer->location?->longitude;
        })->map(function ($dealer) {
            return [
                'id' => $dealer->id(),
                'title' => $dealer->title,
                'url' => $dealer->url,
                'latitude' => (float) $dealer->location->latitude,
                'longitude' => (float) $dealer->location->longitude,
                'zoom' => (int) ($dealer->location->map_zoom ?: 14),
                'city' => $dealer->city,
                'region' => $dealer->region,
                'country' => $dealer->country,
            ];
        })->values();
    @endphp

    <div class="mx-auto w-full max-w-6xl px-4 py-8">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $page->title }}</h1>
            @if ($page->content)
                <div class="prose prose-zinc dark:prose-invert mt-3 max-w-none">{!! $page->content !!}</div>
            @endif
        </header>

        <div
            id="dealers-map"
            class="mb-8 aspect-[16/9] w-full rounded-xl bg-zinc-100 dark:bg-zinc-900"
            data-dealers='@json($mapDealers)'
        ></div>

        <aside class="mb-8 rounded-xl bg-white p-4 shadow dark:bg-zinc-950">
            <h2 class="mb-3 text-sm font-semibold uppercase tracking-wide text-zinc-500">Dealer Categories</h2>
            <ul class="flex flex-wrap gap-2">
                <s:taxonomy:dealer_categories>
                    <li>
                        <a href="{{ $url }}" class="rounded-full bg-zinc-100 px-3 py-1 text-sm text-zinc-700 hover:bg-emerald-100 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-emerald-900/40">
                            {{ $title }}
                        </a>
                    </li>
                </s:taxonomy:dealer_categories>
            </ul>
        </aside>

        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($dealers as $dealer)
                <article class="rounded-xl bg-white p-6 shadow dark:bg-zinc-950">
                    <h2 class="text-lg font-semibold">
                        <a href="{{ $dealer->url }}" class="text-emerald-700 hover:underline dark:text-emerald-400">{{ $dealer->title }}</a>
                    </h2>

                    @if ($dealer->dealer_categories)
                        <p class="mt-1 text-xs uppercase tracking-wide text-zinc-500">
                            @foreach ($dealer->dealer_categories as $category)
                                {{ $category->title }}@unless($loop->last), @endunless
                            @endforeach
                        </p>
                    @endif

                    @if ($dealer->city || $dealer->region || $dealer->country)
                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                            {{ collect([$dealer->city, $dealer->region, $dealer->country])->filter()->implode(', ') }}
                        </p>
                    @endif

                    @if ($dealer->address)
                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ Str::limit($dealer->address, 120) }}</p>
                    @endif

                    @if ($dealer->phone_number)
                        <p class="mt-3 text-sm">
                            <a href="tel:{{ $dealer->phone_number }}" class="text-emerald-600 hover:underline">{{ $dealer->phone_number }}</a>
                        </p>
                    @endif

                    <a href="{{ $dealer->url }}" class="mt-4 inline-block text-sm font-medium text-emerald-600 hover:underline">View dealer</a>
                </article>
            @empty
                <p class="col-span-full text-zinc-600 dark:text-zinc-400">No active dealers found.</p>
            @endforelse
        </section>
    </div>
@endsection
