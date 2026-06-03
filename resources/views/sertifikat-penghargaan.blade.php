@php
    $placeholder = asset('assets/placeholder.jpg');

    $sertifikatOpening = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'sertifikatopening',
    );

    $certificateGallery = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'certificate',
    );
@endphp

<x-layouts.main bodyClass="background-grey">
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage :title="$page->title" :image="$page->featured_image" />

        {{-- Heading Sertifikat --}}
        @if ($sertifikatOpening && $sertifikatOpening['show'])
            <section id="sertification-heading">
                <div class="container my-18 md:my-18 lg:my-30">
                    <div class="flow flex flex-col gap-2 md:gap-2 lg:gap-3 items-left md:items-center lg:items-center">

                        <h2 class="text-left md:text-center md:w-full lg:w-full lg:text-center">
                            {{ $sertifikatOpening['heading'] }}
                        </h2>

                        <div class="text-left md:text-center lg:text-center lg:w-[45%]">{!! $sertifikatOpening['description'] !!}</div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Galeri Sertifikat --}}
        @if ($certificateGallery && $certificateGallery['show'] && !empty($certificateGallery['grid_field']))
            <section id="sertification-gallery">
                <div class="container my-18 md:my-18 lg:my-30">
                    <div id="certificate-gallery"
                        class="grid grid-cols-2 gap-x-2 gap-y-8 md:grid-cols-4 lg:grid-cols-4 lg:gap-x-5 lg:gap-y-20">
                        @foreach ($certificateGallery['grid_field'] as $certificate)
                            <div class="certificate-item">
                                <a data-fslightbox="certificates" href="{{ $placeholder }}">
                                    <img src="{{ $placeholder }}" alt="{{ $certificate['certificate_name'] ?? '' }}"
                                        class="w-full h-auto object-cover rounded-md mb-4">
                                </a>
                                <span
                                    class="title-display font-semibold tracking-tighter text-xl">{{ $certificate['certificate_name'] ?? '' }}</span>
                                <p class="text-(--color-primary)">{{ $certificate['certificate_year'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

    </main>

    <x-layouts.footer.footer />
</x-layouts.main>
