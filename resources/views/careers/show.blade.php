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
@endphp

<x-layouts.main :body-class="$bodyClass">
    <x-layouts.header.single-header />

    <main>
        <section id="career-single">
            <div class="container my-18 md:my-18 lg:my-30">
                <div class="flex flex-col gap-8 lg:flex-row lg:gap-10">

                    {{-- Konten utama --}}
                    <article class="w-full lg:w-[65%]">
                        <header class="mb-8">
                            @if ($page->tags || $page->locations)
                                <p class="text-sm font-semibold uppercase tracking-widest text-(--color-primary)">
                                    @if ($page->locations)
                                        @foreach ($page->locations as $location)
                                            {{ $location->title }}@unless ($loop->last)
                                            ,
                                        @endunless
                                    @endforeach
                                @endif
                                @if ($page->tags && $page->locations)
                                    &middot;
                                @endif
                                @if ($page->tags)
                                    @foreach ($page->tags as $tag)
                                        {{ $tag->title }}@unless ($loop->last)
                                        ,
                                    @endunless
                                @endforeach
                            @endif
                        </p>
                    @endif

                    <h1 class="mt-3">{{ $page->title }}</h1>

                    @if ($page->employment_status)
                        <p class="mt-2 text-zinc-600">
                            {{ $page->employment_status->label() }}
                        </p>
                    @endif
                </header>

                @if ($page->description)
                    <section class="mb-8">
                        <div class="flow">{!! $page->description !!}</div>
                    </section>
                @endif

                @if ($page->qualifications)
                    <section class="mb-8">
                        <h2>Persyaratan</h2>
                        <div class="flow mt-4">{!! $page->qualifications !!}</div>
                    </section>
                @endif

                @if ($page->jobdesc)
                    <section class="mb-8">
                        <h2>Jobdesc</h2>
                        <div class="flow mt-4">{!! $page->jobdesc !!}</div>
                    </section>
                @endif

                {{-- Meta footer --}}
                <div class="mt-8 flex flex-wrap gap-x-3 gap-y-2 text-sm text-zinc-600">
                    @if ($page->employment_status)
                        <span>{{ $page->employment_status->label() }}</span>
                    @endif
                    @if ($page->locations)
                        @foreach ($page->locations as $location)
                            <span>{{ $location->title }}</span>
                        @endforeach
                    @endif
                    @if ($page->tags)
                        @foreach ($page->tags as $tag)
                            <span>{{ $tag->title }}</span>
                        @endforeach
                    @endif
                </div>

                {{-- Tombol kirim lamaran --}}
                <div class="mt-10 flex flex-wrap gap-3">
                    @if ($page->apply_email)
                        <a href="mailto:{{ $page->apply_email }}"
                            class="bg-(--color-primary) hover:bg-black inline-block rounded-full px-8 py-3 text-sm font-semibold uppercase tracking-wide text-white transition-colors">
                            Kirim Lamaran
                        </a>
                    @endif

                    @if ($page->apply_link)
                        <a href="{{ $page->apply_link }}" target="_blank" rel="noopener"
                            class="border border-zinc-300 hover:bg-zinc-50 inline-block rounded-full px-8 py-3 text-sm font-semibold uppercase tracking-wide text-zinc-600 transition-colors">
                            Lamar Eksternal
                        </a>
                    @endif
                </div>
            </article>

            {{-- Sidebar --}}
            <aside class="w-full lg:w-[35%]">
                <div class="flex flex-col gap-6">

                </div>
            </aside>

        </div>
    </div>
</section>

<x-layouts.cta-single-career />

</main>
<x-layouts.footer.secondary-footer />

</x-layouts.main>
