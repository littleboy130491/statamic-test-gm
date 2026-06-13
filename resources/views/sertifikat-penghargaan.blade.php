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

    $sertifikatOpening = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'sertifikatopening',
    );

    $certificateGallery = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'certificate',
    );

    // Global: placeholder image
    $achievements = \Statamic\Facades\GlobalSet::findByHandle('achievements_label_information')
        ?->in(\Statamic\Facades\Site::current()->handle())
        ?->toAugmentedArray();

    // Entries dari collection achievements
    $certificates = \Statamic\Facades\Entry::query()
        ->where('collection', 'achievements')
        ->whereStatus('published')
        ->get();
@endphp

<x-layouts.main :body-class="$bodyClass">
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage :title="$page->title" :image="$page->featured_image" />

        {{-- Heading Sertifikat --}}
        @if ($sertifikatOpening && $sertifikatOpening['show'])
            <section id="sertification-heading">
                <div class="container my-18 md:my-18 lg:my-30">
                    <div class="flow flex flex-col gap-2 md:gap-2 lg:gap-3 items-left md:items-center lg:items-center">

                        <h2 class="text-left w-[90%] md:text-center md:w-full lg:w-full lg:text-center">
                            {{ $sertifikatOpening['heading'] }}
                        </h2>

                        <div class="text-left md:text-center lg:text-center lg:w-[45%]">{!! $sertifikatOpening['description'] !!}</div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Galeri Sertifikat --}}
        @if ($certificates->isNotEmpty())
            <section id="sertification-gallery">
                <div class="container my-18 md:my-18 lg:my-30">
                    <div id="certificate-gallery"
                        class="grid grid-cols-2 gap-x-2 gap-y-8 md:grid-cols-4 lg:grid-cols-4 lg:gap-x-5 lg:gap-y-20">
                        @foreach ($certificates as $certificate)
                            @php $img = $certificate->featured_image?->url() ?? ($achievements['placeholder_image'] ?? ''); @endphp
                            <div class="certificate-item">
                                <a data-fslightbox="certificates" href="{{ $img }}">
                                    <img src="{{ $img }}" alt="{{ $certificate->title }}"
                                        class="w-full h-auto object-cover rounded-md mb-4">
                                </a>
                                <span
                                    class="title-display font-semibold tracking-tighter text-xl lg:text-2xl">{{ $certificate->title }}</span>
                                <p class="text-(--color-primary) font-medium">
                                    @foreach ($certificate->years as $year)
                                        {{ $year->title }}
                                        @unless ($loop->last)
                                            ,
                                        @endunless
                                    @endforeach
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

    </main>

    <x-layouts.footer.footer />
</x-layouts.main>
