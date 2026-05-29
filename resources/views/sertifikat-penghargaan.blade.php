@php
    $certificate_title = 'Komitmen yang Teruji dan Diakui';
    $certificate_desc =
        'Berbagai penghargaan dan sertifikasi menjadi bukti komitmen GM Mobil dalam menjaga kualitas layanan, produk, dan kepuasan pelanggan di seluruh Indonesia';
    $placeholder = asset('images/placeholder.jpg');
    $certificates = [
        [
            'image' => null,
            'name' => 'ISO XXXX:2015X',
            'years' => '2025',
        ],
        [
            'image' => null,
            'name' => 'ISO XXXX:2015',
            'years' => '2025',
        ],
        [
            'image' => asset('images/placeholder.jpg'),
            'name' => 'ISO XXXX:2015',
            'years' => '2025',
        ],
        [
            'image' => asset('images/placeholder.jpg'),
            'name' => 'ISO XXXX:2015',
            'years' => '2025',
        ],
        [
            'image' => asset('images/placeholder.jpg'),
            'name' => 'ISO XXXX:2015',
            'years' => '2025',
        ],
        [
            'image' => asset('images/placeholder.jpg'),
            'name' => 'ISO XXXX:2015',
            'years' => '2025',
        ],
        [
            'image' => asset('images/placeholder.jpg'),
            'name' => 'ISO XXXX:2015',
            'years' => '2025',
        ],
        [
            'image' => asset('images/placeholder.jpg'),
            'name' => 'ISO XXXX:2015',
            'years' => '2025',
        ],
        [
            'image' => asset('images/placeholder.jpg'),
            'name' => 'ISO XXXX:2015',
            'years' => '2025',
        ],
        [
            'image' => asset('images/placeholder.jpg'),
            'name' => 'ISO XXXX:2015',
            'years' => '2025',
        ],
        [
            'image' => asset('images/placeholder.jpg'),
            'name' => 'ISO XXXX:2015',
            'years' => '2025',
        ],
        [
            'image' => asset('images/placeholder.jpg'),
            'name' => 'ISO XXXX:2015',
            'years' => '2025',
        ],
    ];
@endphp

<x-layouts.main bodyClass="background-grey">
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage title="Sertifikat & Penghargaan" :image="asset('images/hero-sertifikat.jpg')" />

        {{-- Halaman sertifikat --}}
        <section id="sertification">
            <div class="container my-18 md:my-18 lg:my-30">
                <div class="flex flex-col gap-10 md:gap-10 lg:gap-30">

                    {{-- Heading sertifikat --}}
                    <div id="ceritificate-content" class="flow flex flex-col items-left md:items-center lg:items-center">
                        <h2 class="text-left w-[90%] md:text-center md:w-full lg:w-full lg:text-center">
                            {{ $certificate_title }}
                        </h2>
                        <p class="text-left md:text-center lg:text-center lg:w-[45%]">{{ $certificate_desc }}</p>
                    </div>

                    {{-- Galeri Sertifikat --}}
                    <div id="certificate-gallery"
                        class="grid grid-cols-2 gap-x-2 gap-y-8 md:grid-cols-4 lg:grid-cols-4 lg:gap-x-5 lg:gap-y-20">
                        @foreach ($certificates as $index => $certificate)
                            <div class="certificate-item">
                                <a data-fslightbox="certificates" href="{{ $certificate['image'] ?: $placeholder }}">
                                    <img src="{{ $certificate['image'] ?: $placeholder }}" alt="{{ $certificate['name'] }}"
                                        class="w-full h-auto object-cover rounded-md mb-4">
                                </a>
                                <span
                                    class="title-display font-semibold tracking-tighter text-xl">{{ $certificate['name'] }}</span>
                                <p class="text-(--color-primary)">{{ $certificate['years'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>

    <x-layouts.footer.footer />
</x-layouts.main>
