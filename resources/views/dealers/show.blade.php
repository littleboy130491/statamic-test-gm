@extends('layouts.app')

@section('content')
    <article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:py-16">
        <header class="mb-8">
            @if ($page->dealer_categories)
                <p class="text-sm font-semibold uppercase tracking-widest text-emerald-600">
                    @foreach ($page->dealer_categories as $category)
                        {{ $category->title }}@unless($loop->last), @endunless
                    @endforeach
                </p>
            @endif

            <h1 class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 sm:text-4xl">
                {{ $page->title }}
            </h1>

            @if ($page->city || $page->region || $page->country)
                <p class="mt-2 text-zinc-600">
                    {{ collect([$page->city, $page->region, $page->country])->filter()->implode(', ') }}
                </p>
            @endif
        </header>

        @if ($page->location?->latitude && $page->location?->longitude)
            <div
                id="dealer-map"
                class="mb-8 aspect-[16/9] w-full rounded-xl bg-zinc-100"
                data-latitude="{{ $page->location->latitude }}"
                data-longitude="{{ $page->location->longitude }}"
                data-zoom="{{ $page->location->map_zoom ?: 14 }}"
                data-title="{{ $page->title }}"
            ></div>
        @endif

        <dl class="space-y-6">
            @if ($page->address)
                <div>
                    <dt class="text-sm font-semibold uppercase tracking-wide text-zinc-500">Address</dt>
                    <dd class="mt-1 whitespace-pre-line text-zinc-700">{{ $page->address }}</dd>
                </div>
            @endif

            @if ($page->phone_number)
                <div>
                    <dt class="text-sm font-semibold uppercase tracking-wide text-zinc-500">Phone</dt>
                    <dd class="mt-1">
                        <a href="tel:{{ $page->phone_number }}" class="text-emerald-600 hover:underline">
                            {{ $page->phone_number }}
                        </a>
                    </dd>
                </div>
            @endif

            @if ($page->whatsapp_number || $page->whatsapp_link)
                <div>
                    <dt class="text-sm font-semibold uppercase tracking-wide text-zinc-500">WhatsApp</dt>
                    <dd class="mt-1">
                        @php
                            $whatsappUrl = $page->whatsapp_link ?: ($page->whatsapp_number ? 'https://wa.me/' . preg_replace('/\D+/', '', $page->whatsapp_number) : null);
                        @endphp
                        @if ($whatsappUrl)
                            <a href="{{ $whatsappUrl }}" class="text-emerald-600 hover:underline" target="_blank" rel="noopener noreferrer">
                                {{ $page->whatsapp_number ?: 'Chat on WhatsApp' }}
                            </a>
                        @endif
                    </dd>
                </div>
            @endif

            @if ($page->google_maps_url)
                <div>
                    <dt class="text-sm font-semibold uppercase tracking-wide text-zinc-500">Google Maps</dt>
                    <dd class="mt-1">
                        <a href="{{ $page->google_maps_url }}" class="text-emerald-600 hover:underline" target="_blank" rel="noopener noreferrer">
                            Open in Google Maps
                        </a>
                    </dd>
                </div>
            @endif
        </dl>

        <p class="mt-12 text-center">
            <a href="/dealers" class="text-sm text-emerald-600 hover:underline">&larr; Back to dealers</a>
        </p>
    </article>
@endsection
