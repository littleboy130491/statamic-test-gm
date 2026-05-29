@php
    $slides = [
        [
            'background' => asset('images/hero-slide1.jpg'),
            'backgroundVideo' => '',
            'title' => 'Kepastian Operasional untuk Bisnis Anda',
            'desc' => 'Investasi aman dengan jaminan layanan purna jual yang andal.',
            'btnText' => 'Mulai Konsultasi',
            'btnLink' => '/kontak',
        ],
        [
            'background' => asset('images/hero-slide2.jpg'),
            'backgroundVideo' => '',
            'title' => 'Kepastian Operasional untuk Bisnis Anda',
            'desc' => 'Investasi aman dengan jaminan layanan purna jual yang andal.',
            'btnText' => 'Mulai Konsultasi',
            'btnLink' => '/kontak',
        ],
        [
            'background' => asset('images/hero-slide1.jpg'),
            'backgroundVideo' => '',
            'title' => 'Kepastian Operasional untuk Bisnis Anda',
            'desc' => 'Investasi aman dengan jaminan layanan purna jual yang andal.',
            'btnText' => 'Mulai Konsultasi',
            'btnLink' => '/kontak',
        ],
    ];

    $sliderHeight = 'min-h-[90svh] md:min-h-[60vh] lg:min-h-screen';
@endphp

{{-- Hero Slider --}}
<section id="hero-banner" class="overflow-hidden">
    <div data-hero-slider class="relative select-none touch-pan-y">

        {{-- Slider Track --}}
        <div class="overflow-hidden">
            <div data-hero-track class="flex transition-transform duration-500 ease-out">

                @foreach ($slides as $slide)
                    {{-- Slide --}}
                    <div data-hero-slide class="min-w-full">
                        <div class="relative overflow-hidden bg-slate-900 {{ $sliderHeight }}">

                            {{-- Background image/video --}}
                            @if (empty($slide['backgroundVideo']))
                                <img src="{{ $slide['background'] }}" alt="{{ $slide['title'] }}"
                                    class="pointer-events-none absolute inset-0 h-full w-full object-cover transform-(translateZ(0))" />
                            @endif

                            @if (!empty($slide['backgroundVideo']))
                                @php
                                    preg_match(
                                        '/(?:youtu\.be\/|youtube\.com\/(?:embed\/|watch\?v=|watch\?.+&v=))([^?&\s]+)/',
                                        $slide['backgroundVideo'],
                                        $ytMatch,
                                    );
                                    $ytId = $ytMatch[1] ?? null;
                                @endphp
                                @if ($ytId)
                                    <iframe
                                        class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"
                                        style="width: max(100%, 177.78vh); height: max(100%, 56.25vw);"
                                        src="https://www.youtube.com/embed/{{ $ytId }}?autoplay=1&mute=1&loop=1&controls=0&rel=0&playlist={{ $ytId }}&playsinline=1"
                                        frameborder="0" allow="autoplay; encrypted-media" title="{{ $slide['title'] }}">
                                    </iframe>
                                @else
                                    <video class="pointer-events-none absolute inset-0 h-full w-full object-cover"
                                        autoplay muted loop playsinline>
                                        <source src="{{ asset($slide['backgroundVideo']) }}" type="video/mp4">
                                    </video>
                                @endif
                            @endif

                            {{-- Overlay --}}
                            <div class="hero-banner-overlay absolute inset-0"></div>

                            {{-- Slide Content --}}
                            <div class="absolute inset-0 z-10">
                                <div class="container flex items-center justify-center {{ $sliderHeight }}">
                                    <div class="text-left md:text-center md:w-170 lg:w-200">
                                        <h1 class="max-w-none text-left md:text-center lg:text-center text-white">
                                            {{ $slide['title'] }}
                                        </h1>
                                        <p
                                            class="mx-auto text-left md:text-center lg:text-center mt-2 md:mt-4 lg:mt-4 text-white">
                                            {{ $slide['desc'] }}</p>
                                        <a href="{{ $slide['btnLink'] }}" class="button gap-4 button--primary mt-8">
                                            <span>{{ $slide['btnText'] }}</span>
                                            <svg viewBox="0 0 12 12" fill="none" aria-hidden="true" class="h-4 w-4">
                                                <path d="M4 2L8 6L4 10" stroke="currentColor" stroke-width="1"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        {{-- Navigasi Dots --}}
        <div class="pointer-events-none absolute inset-x-0 bottom-6 z-10 px-6 sm:px-8 lg:px-10">
            <div class="pointer-events-auto flex items-center gap-3 sm:gap-4">
                @foreach ($slides as $slide)
                    <button type="button" data-hero-dot
                        class="hero-slider-dot {{ $loop->first ? 'is-active' : '' }} h-0.5 flex-1 rounded-full"
                        aria-label="Go to slide {{ $loop->iteration }}"
                        aria-current="{{ $loop->first ? 'true' : 'false' }}"></button>
                @endforeach
            </div>
        </div>

    </div>
</section>
