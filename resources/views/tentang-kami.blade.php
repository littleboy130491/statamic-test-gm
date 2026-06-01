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
@endphp

<x-layouts.main bodyClass="background-grey">
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage title="Tentang Kami" :image="asset('assets/hero-tentang.jpg')" />

        {{-- Halaman tentang perusahaan --}}
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
                        class="rounded-xl md:rounded-xl lg:rounded-3xl w-full lg:h-185 object-cover">
                    <div id="visi-misi-content"
                        class="absolute bottom-0 inset-0 z-2 flex flex-col md:flex-row lg:flex-row lg:pr-10 lg:py-10">

                        {{-- Image truk --}}
                        <div class="w-[60%] -ml-20 -mr-30">
                            <img src="{{ $visimisiPhoto }}" alt="Visi Misi">
                        </div>

                        {{-- Teks visi misi --}}
                        <div class="flex inset-0 flex-col gap-8 w-[70%] -ml-20">
                            <div id="vision" class="glass rounded-2xl p-8 flex flex-col gap-6">
                                <h3>{{ $visionContent['title'] }}</h3>
                                <p>{{ $visionContent['desc'] }}</p>
                            </div>
                            <div id="mission" class="glass rounded-2xl p-8 flex flex-col gap-6">
                                <h3>{{ $missionContent['title'] }}</h3>
                                <p>tes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <x-layouts.footer.footer />
</x-layouts.main>
