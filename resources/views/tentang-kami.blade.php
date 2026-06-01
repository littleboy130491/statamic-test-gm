@php
    $titleAbout = 'Lebih dari Dua Dekade Menjadi Mitra Truk Terpercaya Indonesia';
    $descAbout =
        'PT Gaya Makmur Mobil (GM Mobil) adalah Agen Pemegang Merek resmi FAW Truck di Indonesia sejak 2005. Selama 21 tahun, GM Mobil menjadi satu-satunya distributor truk China yang paling lama beroperasi di Indonesia tanpa pernah berganti merek, melayani sektor logistik, konstruksi, pertambangan, kehutanan, hingga perkebunan.';

    $visimisiPhoto = asset('/assets/truk-vm.png');
    $visimisiBackground = asset('/assets/visi-misi-bg.jpg');
    $visionContent = [
        'title' => 'Visi',
        'desc' =>
            'Menjadi salah satu pemain kunci dalam industri otomotif, khususnya truk menengah hingga berat di Indonesia, dengan menghadirkan produk berkualitas dan layanan terpercaya bagi pelanggan.',
    ];
    $missionContent = [
        'title' => 'Misi',
        'desc' => [
            'Terus meningkatkan pengetahuan dan kapabilitas dalam teknologi serta produk masa depan guna memberikan layanan purna jual yang optimal.',
            'Menjaga komitmen terhadap kualitas dan kepuasan pelanggan sesuai standar internasional.',
            'Mengembangkan pengalaman dan kompetensi kerja untuk menghadapi persaingan industri global secara berkelanjutan.',
        ],
    ];

    $fawTitle =
        'FAW sendiri merupakan pabrikan otomotif pertama dan terbesar di Tiongkok, dengan produksi lebih dari 3,5 juta unit per tahun dan pangsa pasar truk medium–heavy di atas 20%, menjadikannya pemimpin pasar nomor satu di Tiongkok hingga hari ini.';
    $fawDesc =
        'Lebih dari sekadar penjualan unit, GM Mobil menghadirkan layanan purna jual, suku cadang, serta pelatihan teknik dan mengemudi melalui jaringan yang tersebar di berbagai kota besar di seluruh Indonesia. Bersama pelanggan, GM Mobil terus berkomitmen menggerakkan industri Indonesia dengan produk berkualitas dan pelayanan terbaik.';
    $fawCertificate = [
        [
            'title' => null,
            'photo' => asset('/assets/cer-1.jpg'),
        ],
        [
            'title' => 'Sole Distributor of',
            'photo' => asset('/assets/cer-2.jpg'),
        ],
    ];
@endphp

<x-layouts.main bodyClass="background-grey">
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage title="Tentang Kami" :image="asset('assets/hero-tentang.jpg')" />

        {{-- Tentang perusahaan --}}
        <section id="tentang-kami">
            <div class="container">
                <div class="flow flex flex-col items-center my-18 md:my18 lg:mt-30 lg:mb-8">
                    <h2 class="text-left md:text-center lg:text-center w-full md:w-150 lg:w-180">{{ $titleAbout }}</h2>
                    <p class="text-left md:text-center lg:text-center w-full md:w-full lg:w-250">{{ $descAbout }}</p>
                </div>
            </div>
        </section>

        {{-- Visi dan misi --}}
        <section id="visi-misi">
            <div class="container">
                <div id="background-visi-misi" class="overlay-visimisi relative my-18 md:my-18 lg:my-30 rounded-3xl">
                    <img src="{{ $visimisiBackground }}" alt="Visi Misi Background"
                        class="rounded-xl md:rounded-xl lg:rounded-3xl w-full h-245 md:h-260 lg:h-205 object-cover pointer-events-none">

                    <div id="visi-misi-content"
                        class="absolute bottom-0 inset-0 z-2 flex flex-col-reverse gap-10 md:gap-10 px-4 md:px-6 md:flex-col-reverse lg:flex-row lg:pr-16 lg:py-10">

                        {{-- Image truk --}}
                        <div class="w-full -mb-10 lg:mb-10 lg:w-[64%] lg:-ml-25 lg:-mr-45">
                            <img src="{{ $visimisiPhoto }}" alt="Visi Misi">
                        </div>

                        {{-- Teks visi misi --}}
                        <div
                            class="flex flex-col md:flex-row inset-0 lg:flex-col gap-4 md:gap-4 lg:gap-8 md:w-full lg:w-[60%] lg:-ml-20">
                            <div id="vision"
                                class="glass rounded-2xl p-5 w-full md:w-[40%] lg:w-full md:p-5 lg:p-8 flex flex-col gap-6">
                                <h3>{{ $visionContent['title'] }}</h3>
                                <p>{{ $visionContent['desc'] }}</p>
                            </div>

                            <div id="mission"
                                class="glass rounded-2xl p-5 w-full md:w-[60%] lg:w-full md:p-5 lg:p-8 flex flex-col md:gap-0 lg:gap-6">
                                <h3>{{ $missionContent['title'] }}</h3>
                                <ol class="flex flex-col">
                                    @foreach ($missionContent['desc'] as $index => $item)
                                        <li
                                            class="flex gap-4 md:gap-4 lg:gap-20 py-4 md:py-5 lg:py-8 {{ $index < count($missionContent['desc']) - 1 ? 'border-b border-white' : '' }}">
                                            <span
                                                class="mission-list md:text-xl lg:text-2xl text-black shrink-0">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}.</span>
                                            <p>{{ $item }}</p>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Setifikasi --}}
        <section id="faw-trucks">
            <div class="container">
                <div
                    class="flex flex-col-reverse md:flex-col-reverse lg:flex-row gap-8 md:gap-10 lg:gap-30 my-18 md:my-18 lg:my-30">

                    {{-- Faw image --}}
                    <div id="certificate"
                        class="w-full md:w-[60%] lg:w-[23%] flex flex-row md:flex-row lg:flex-col gap-4">
                        @foreach ($fawCertificate as $cert)
                            <div class="bg-white rounded-2xl p-4 md:p-4 lg:p-6 flex flex-col gap-2">
                                @if (!empty($cert['title']))
                                    <p>{{ $cert['title'] }}</p>
                                @endif
                                <img src="{{ $cert['photo'] }}" alt="{{ $cert['title'] ?? '' }}">
                            </div>
                        @endforeach
                    </div>

                    {{-- Faw konten --}}
                    <div id="faw-content" class="w-full md:w-full lg:w-[70%] flex flex-col gap-5">
                        <h3>{{ $fawTitle }}</h3>
                        <p class="w-full lg:w-170">{{ $fawDesc }}</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <x-layouts.footer.footer />
</x-layouts.main>
