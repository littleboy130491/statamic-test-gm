@php
    $manajemenTitle = 'Didukung Tim Profesional dan Berpengalaman';
    $manajemenDesc =
        'GM Mobil didukung oleh tim profesional yang berpengalaman dalam industri kendaraan niaga untuk memastikan pelayanan, kualitas, dan dukungan operasional terbaik bagi setiap pelanggan.';

    $direkturUtama = [
        'name' => 'Frankie Makaminang',
        'position' => 'Direktur Utama',
        'photo' => 'images/manajemen/frankie-makaminang.png',
        'message' => [
            'Salam sejahtera bagi kita semua,',
            'Saya bersama segenap direksi dan seluruh tim Gaya Makmur Mobil akan terus berusaha meningkatkan pelayanan kami demi mendukung semua produk FAW Trucks yang sudah dan akan kami distribusikan di seluruh wilayah Indonesia, yang sudah mencapai ribuan unit sejak diluncurkan di Indonesia pada tahun 2009.',
            'Kami harapkan FAW Trucks akan terus menjadi pemimpin market truk Cina di Indonesia, seperti negeri asalnya RRC dan menjadi solusi alat transportasi dengan biaya investasi & operasi yang rendah.',
            'Best Regards,
Frankie Makaminang',
        ],
    ];

    $direksi = [
        [
            'name' => 'Surijani',
            'position' => 'Direktur Marketing',
            'photo' => 'images/manajemen/surijani.png',
        ],
        [
            'name' => 'Inawati',
            'position' => 'Direktur Keuangan',
            'photo' => 'images/manajemen/inawati.png',
        ],
    ];
@endphp

<x-layouts.main>
    <x-layouts.header.header />

    {{-- Manajemen halaman --}}
    <main>
        <x-layouts.hero.heropage title="Manajemen" :image="asset('assets/hero-manajemen.jpg')" />

        {{-- Judul halaman --}}
        <section id="manajemen">
            <div class="container">
                <div class="my-18 md:my18 lg:my-30 flow flex flex-col items-center">
                    <h2 class="text-center w-full lg:w-155">{{ $manajemenTitle }}</h2>
                    <p class="text-center w-full lg:w-220">{{ $manajemenDesc }}</p>
                </div>
            </div>
        </section>

        {{-- Manajemen section --}}

        {{-- Section sambutan --}}
        <section id="manajemen-content">
            <div class="container">
                <div class="flex flex-col gap-20">

                    {{-- Kata sambuatan --}}
                    <div id="highligh-management" class="flex flex-col md:flex-row lg:flex-row">
                        <div>
                            @foreach ($direkturUtama['message'] as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                        <div></div>
                    </div>

                    {{-- Card manajemen --}}
                    <div id="card-manajemen"></div>
                </div>
            </div>
        </section>

    </main>
    <x-layouts.footer.footer />
</x-layouts.main>
