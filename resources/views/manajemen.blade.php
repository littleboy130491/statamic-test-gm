@php
    $manajemenTitle = 'Didukung Tim Profesional dan Berpengalaman';
    $manajemenDesc =
        'GM Mobil didukung oleh tim profesional yang berpengalaman dalam industri kendaraan niaga untuk memastikan pelayanan, kualitas, dan dukungan operasional terbaik bagi setiap pelanggan.';

    $direkturUtama = [
        'name' => 'Frankie Makaminang',
        'position' => 'Direktur Utama',
        'photo' => asset('/assets/frankie-makaminang.png'),
        'message' => [
            'Salam sejahtera bagi kita semua,',
            'Saya bersama segenap direksi dan seluruh tim Gaya Makmur Mobil akan terus berusaha meningkatkan pelayanan kami demi mendukung semua produk FAW Trucks yang sudah dan akan kami distribusikan di seluruh wilayah Indonesia, yang sudah mencapai ribuan unit sejak diluncurkan di Indonesia pada tahun 2009.',
            'Kami harapkan FAW Trucks akan terus menjadi pemimpin market truk Cina di Indonesia, seperti negeri asalnya RRC dan menjadi solusi alat transportasi dengan biaya investasi & operasi yang rendah.',
            'Best Regards',
            'Frankie Makaminang',
        ],
    ];

    $direksi = [
        [
            'category' => 'Board Of Directors',
            'members' => [
                [
                    'name' => 'Surijani',
                    'position' => 'Direktur Marketing',
                    'photo' => 'Assets/manajemen/surijani.png',
                ],
                [
                    'name' => 'Inawati',
                    'position' => 'Direktur Keuangan',
                    'photo' => 'Assets/manajemen/inawati.png',
                ],
            ],
        ],
        [
            'category' => 'Board Of Commissioners',
            'members' => [
                [
                    'name' => 'Lie Fen Sin',
                    'position' => 'Komisaris Utama',
                    'photo' => '',
                ],
                [
                    'name' => 'Cahyadi Lie',
                    'position' => 'Komisaris',
                    'photo' => '',
                ],
                [
                    'name' => 'Hendry',
                    'position' => 'Komisaris',
                    'photo' => '',
                ],
            ],
        ],
    ];

    $bgDireksi = asset('assets/manajemen-back.jpg');
@endphp

<x-layouts.main bodyClass="background-grey">
    <x-layouts.header.header />

    {{-- Manajemen halaman --}}
    <main>
        <x-layouts.hero.heropage title="Manajemen" :image="asset('assets/hero-manajemen.jpg')" />

        {{-- Judul halaman --}}
        <section id="manajemen">
            <div class="container">
                <div class="my-18 md:my18 lg:my-30 flow flex flex-col items-center">
                    <h2 class="text-left md:text-center lg:text-center w-full md:w-120 lg:w-155">{{ $manajemenTitle }}
                    </h2>
                    <p class="text-left md:text-center lg:text-center w-full lg:w-220">{{ $manajemenDesc }}</p>
                </div>
            </div>
        </section>

        {{-- Manajemen section --}}

        {{-- Section sambutan --}}
        <section id="manajemen-content">
            <div class="container">

                {{-- Kata sambuatan --}}
                <div id="highlight-management"
                    class="flex flex-col-reverse gap-6 bg-white rounded-3xl p-5 md:p-6 lg:p-10 md:flex-row lg:flex-row my-18 md:my-18 lg:my-30">
                    <div class="flex flex-col justify-between gap-8 md:gap-2 lg:gap-2 w-full md:w-[60%] lg:w-[60%]">
                        <div class="flex flex-col">
                            @foreach ($direkturUtama['message'] as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="title-display text-xl md:text-xl lg:text-2xl">{{ $direkturUtama['name'] }}</p>
                            <p class="uppercase text-(--color-primary)">{{ $direkturUtama['position'] }}</p>
                        </div>
                    </div>
                    <div class="w-full md:w-[40%] lg:w-[40%] relative">
                        <img src="{{ $bgDireksi }}" alt="{{ $direkturUtama['name'] }}"
                            class="image-grayscale pointer-events-none rounded-xl w-full md:h-105 lg:h-120 object-cover">
                        <div class="overlay-bg-management"></div>
                        <div class="flex justify-center">
                            <img src="{{ $direkturUtama['photo'] }}" alt="{{ $direkturUtama['name'] }}"
                                class="w-[48%] md:w-[90%] lg:w-[50%] absolute bottom-0 z-3">
                        </div>
                    </div>
                </div>

                {{-- Card manajemen --}}
                <div id="card-manajemen"></div>
            </div>
            </div>
        </section>

    </main>
    <x-layouts.footer.footer />
</x-layouts.main>
