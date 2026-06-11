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

    // Global Label
    $career = \Statamic\Facades\GlobalSet::findByHandle('career_label_information')
        ?->in(\Statamic\Facades\Site::current()->handle())
        ?->toAugmentedArray();

    // Sidebar Career
    $relatedCareers = \Statamic\Facades\Entry::query()
        ->where('collection', 'careers')
        ->whereStatus('published')
        ->where('id', '!=', $page->id)
        ->limit(2)
        ->get();
@endphp

<x-layouts.main :body-class="$bodyClass">

    <x-layouts.header.single-header />

    {{-- Singel career --}}
    <main>
        <section id="single-career">
            <div class="container mt-10 mb-18 md:mt-10 md:mb-18 lg:mt-20 lg:mb-30">
                <div class="flex flex-col md:flex-row lg:flex-row gap-18 md:gap-6 lg:gap-30">
                    <article class="w-full md:w-[70%] lg:w-[70%]">

                        {{-- Head --}}
                        <header class="flex flex-col gap-4">
                            <div id="navigation" class="flex gap-6 md:gap-8 lg:gap-8">

                                {{-- Employment --}}
                                @if ($page->employment_status)
                                    <p class="flex items-center gap-2 uppercase text-(--color-primary) font-medium">
                                        @if (!empty($career['icon_employment_status']))
                                            <img src="{{ $career['icon_employment_status'] }}" alt=""
                                                class="w-5 h-5 shrink-0" />
                                        @endif
                                        {{ $page->employment_status->label() }}
                                    </p>
                                @endif

                                {{-- Location --}}
                                @if ($page->locations)
                                    <p class="flex items-center gap-2 uppercase text-(--color-primary) font-medium">
                                        @if (!empty($career['icon_location']))
                                            <img src="{{ $career['icon_location'] }}" alt=""
                                                class="w-5 h-5 shrink-0" />
                                        @endif
                                        @foreach ($page->locations as $location)
                                            {{ $location->title }}@unless ($loop->last)
                                            ,
                                        @endunless
                                    @endforeach
                                </p>
                            @endif
                        </div>

                        {{-- Heading Page --}}
                        <h1 class="heading-single">{{ $page->title }}</h1>
                    </header>

                    {{-- Body --}}
                    <section class="flex flex-col gap-10">

                        {{-- Deskripsi --}}
                        @if ($page->description)
                            <div id="description" class="richtext mt-4 md:mt-4 lg:mt-5">{!! $page->description !!}
                            </div>
                        @endif

                        {{-- Persyaratan --}}
                        @if ($page->qualifications)
                            <div id="qualifications" class="richtext">
                                <h3 class="mb-2">{{ $career['requirements_label'] ?? 'Persyaratan' }}</h3>
                                {!! $page->qualifications !!}
                            </div>
                        @endif

                        {{-- Jobdesc --}}
                        @if ($page->jobdesc)
                            <div id="jobdesc" class="richtext">
                                <h3 class="mb-2">{{ $career['label_jobdesc'] ?? 'Jobdesc' }}</h3>
                                {!! $page->jobdesc !!}
                            </div>
                        @endif

                        {{-- Tag Career --}}
                        <div id="tag-career"
                            class="flex flex-wrap gap-x-4 gap-y-2 md:gap-x-4 md:gap-y-2 lg:gap-x-8 lg:gap-y-8">
                            @if ($page->tags)
                                @foreach ($page->tags as $tag)
                                    <p>{{ $tag->title }}</p>
                                @endforeach
                            @endif
                        </div>

                        {{-- Button Kirim Lamaran --}}
                        <div id="button-submit">
                            @if ($page->apply_email)
                                <a href="mailto:{{ $page->apply_email }}" class="button button--primary">
                                    {{ $career['label_submit_button'] ?? 'Kirim Lamaran' }}
                                </a>
                            @elseif ($page->apply_link)
                                <a href="{{ $page->apply_link }}" target="_blank" rel="noopener"
                                    class="button button--primary">
                                    {{ $career['label_submit_button'] ?? 'Lamar Eksternal' }}
                                </a>
                            @else
                                <button type="button" class="button button--primary"
                                    onclick="document.getElementById('career-popup').showModal()">
                                    {{ $career['label_submit_button'] ?? 'Kirim Lamaran' }}
                                </button>
                            @endif
                        </div>

                    </section>
                </article>

                {{-- Career Lainnya --}}
                <aside class="w-full md:w-[40%] lg:w-[35%]">
                    @if ($relatedCareers->isNotEmpty())
                        <div class="flex flex-col gap-6">
                            @foreach ($relatedCareers as $entry)
                                <x-layouts.skin.career-skin :entry="$entry" :career="$career" />
                            @endforeach
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>


    {{-- Call to Action --}}
    <x-layouts.cta-single-career />

    {{-- Popup Form --}}
    <x-layouts.popup-form-career />
</main>

<x-layouts.footer.secondary-footer />

</x-layouts.main>
