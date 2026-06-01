@php
    $company_name = 'PT Gaya Makmur Mobil';
    $footer_title = 'Langkah Pertama untuk Operasional yang Lebih Efisien';
    $footer_desc =
        'Tim konsultan kami siap mendengarkan kebutuhan Anda dan memberikan rekomendasi solusi yang paling sesuai.';
    $footer_button = ['btnText' => 'Konsultasi Sekarang', 'btnLink' => '/kontak'];
    $footer_background = asset('/assets/footer-background.jpg');
    $image_footer = asset('/assets/footer-image.png');
    $socials = [
        [
            'name' => 'Instagram',
            'link' => 'https://instagram.com/gayamakmurmobil',
            'icon' => asset('assets/instagram.svg'),
        ],
        ['name' => 'Facebook', 'link' => 'https://facebook.com/fawindonesia/', 'icon' => asset('assets/facebook.svg')],
        [
            'name' => 'LinkedIn',
            'link' => 'https://linkedin.com/company/fawindonesia',
            'icon' => asset('assets/linkedin.svg'),
        ],
    ];
@endphp

<footer id="footer">
    <div class="relative overflow-hidden rounded-t-3xl lg:rounded-t-[60px] bg-(--color-primary)">

        {{-- Background Footer --}}
        <div id="footer-background" class="overlay-footer">
            <img src="{{ $footer_background }}" alt="Footer Background"
                class="w-full h-195 md:h-120 lg:h-140 object-cover mix-blend-multiply pointer-events-none">
        </div>

        {{-- Content Footer --}}
        <div id="content-footer" class="absolute inset-0 z-10 mt-4 lg:mt-15">
            <div class="container flex flex-col gap-8 justify-center md:flex-row lg:flex-row">

                <div class="flex flex-col-reverse md:flex-row lg:flex-row gap-6">
                    {{-- Image Footer --}}
                    <div id="image-footer" class="flex items-end">
                        <img src="{{ $image_footer }}" alt="Footer Background" class="block w-full">
                    </div>

                    {{-- CTA Footer --}}
                    <div id="cta-footer" class="flex flex-col justify-between mt-10 lg:-ml-20">
                        <div class="flow">
                            <h2 class="text-white lg:w-160">{{ $footer_title }}</h2>
                            <p class="text-white lg:w-120">{{ $footer_desc }}</p>

                            {{-- Media Sosial --}}
                            <div
                                class="flex flex-col-reverse gap-6 items-start mt-4 lg:flex-row lg:items-center lg:mt-8">
                                <div
                                    class="flex justify-between w-full border-t border-white/20 py-4 mt-2 md:border-white/0 md:py-0 md:mt-0 lg:border-white/0 lg:py-0 lg:mt-0 lg:w-min">
                                    <p class="uppercase text-white border-white md:hidden lg:hidden">Media
                                        Sosial</p>
                                    <div class="flex gap-4">
                                        @foreach ($socials as $social)
                                            <a href="{{ $social['link'] }}" target="_blank" rel="noopener noreferrer"
                                                title="{{ $social['name'] }}">
                                                <span class="social-icon block w-5 h-5 social-icon-white"
                                                    style="--icon-url: url('{{ $social['icon'] }}');"></span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Button Konsultasi --}}
                                <a href="{{ $footer_button['btnLink'] }}" class="button gap-4 button--white">
                                    <span>{{ $footer_button['btnText'] }}</span>
                                    <svg viewBox="0 0 12 12" fill="none" aria-hidden="true" class="h-4 w-4">
                                        <path d="M4 2L8 6L4 10" stroke="currentColor" stroke-width="1"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- Copyrigth Footer Desktop --}}
                        <div id="copyrigth-footer" class="hidden my-6 md:mt-20 md:block lg:block">
                            <p class="text-white">© {{ date('Y') }} {{ $company_name }}</p>
                        </div>
                    </div>
                </div>

                {{-- Copyrigth Footer Mobile --}}
                <div id="copyrigth-footer" class="-mt-4 md:hidden lg:hidden">
                    <p class="text-white text-center">© {{ date('Y') }} {{ $company_name }}</p>
                </div>
            </div>
        </div>
    </div>
</footer>
