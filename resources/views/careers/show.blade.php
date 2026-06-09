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

    {{-- Singel career --}}
    <main>
        <section id="single-career">
            <div class="container my-18 md:my-18 lg:my-20">
                <div class="flex gap-20">
                    <article class="w-full lg:w-[70%]">

                        {{-- Head --}}
                        <header class="flex flex-col gap-2">
                            <div id="navigation" class="flex gap-8 font-semibold uppercase text-(--color-primary)">
                                {{-- Employment --}}
                                @if ($page->employment_status)
                                    <span>{{ $page->employment_status->label() }}</span>
                                @endif

                                {{-- Location --}}
                                @if ($page->tags || $page->locations)
                                    <span>
                                        @if ($page->locations)
                                            @foreach ($page->locations as $location)
                                                {{ $location->title }}
                                                @unless ($loop->last)
                                                    ,
                                                @endunless
                                            @endforeach
                                        @endif
                                    </span>
                                @endif
                            </div>

                            {{-- Heading Page --}}
                            <h1 class="heading-single">{{ $page->title }}</h1>
                        </header>

                        {{-- Body --}}
                        <section class="flex flex-col gap-10">

                            {{-- Deskripsi --}}
                            @if ($page->description)
                                <div id="description" class="flow mt-5">{!! $page->description !!}</div>
                            @endif


                            {{-- Persyaratan --}}
                            @if ($page->qualifications)
                                <div id="qualifications">
                                    <h3 class="mb-2">Persyaratan</h3>
                                    <p class="flow">{!! $page->qualifications !!}</p>
                                </div>
                            @endif

                            {{-- Jobdesc --}}
                            @if ($page->jobdesc)
                                <div id="jobdesc">
                                    <h3 class="mb-2">Jobdesc</h3>
                                    <p class="flow">{!! $page->jobdesc !!}</p>
                                </div>
                            @endif

                        </section>
                    </article>
                    <aside class="w-full lg:w-[30%]"> Sidebar </aside>
                </div>
            </div>
        </section>


        {{-- Call to Action --}}
        <x-layouts.cta-single-career />
    </main>

    <x-layouts.footer.secondary-footer />

</x-layouts.main>
