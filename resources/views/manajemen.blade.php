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
            'name' => 'Surijani',
            'position' => 'Direktur Marketing',
            'photo' => asset('/assets/surijani.png'),
            'category' => 'Board Of Directors',
        ],
        [
            'name' => 'Inawati',
            'position' => 'Direktur Keuangan',
            'photo' => asset('/assets/inawati.png'),
            'category' => 'Board Of Directors',
        ],
        [
            'name' => 'Lie Fen Sin',
            'position' => 'Komisaris Utama',
            'photo' => asset('/assets/surijani.png'),
            'category' => 'Board Of Commissioners',
        ],
        [
            'name' => 'Cahyadi Lie',
            'position' => 'Komisaris',
            'photo' => asset('/assets/surijani.png'),
            'category' => 'Board Of Commissioners',
        ],
        [
            'name' => 'Hendry',
            'position' => 'Komisaris',
            'photo' => asset('/assets/surijani.png'),
            'category' => 'Board Of Commissioners',
        ],
    ];

    $bgDireksi = asset('assets/manajemen-back.jpg');
@endphp

<x-layouts.main bodyClass="background-grey">
    <x-layouts.header.header />

    {{-- Manajemen halaman --}}
    <main>
        <x-layouts.hero.heropage :title="$page->title" :image="$page->featured_image" />

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
                                class="w-[48%] md:w-[90%] lg:w-[52%] absolute bottom-0 z-3">
                        </div>
                    </div>
                </div>

                {{-- Card manajemen --}}
                <div id="card-manajemen" class="flex flex-col gap-18 md:gap-18 lg:gap-30 my-18 md:my-18 lg:my-30">
                    @php
                        $direksiByCategory = collect($direksi)->groupBy('category');
                    @endphp

                    @foreach ($direksiByCategory as $category => $members)
                        <div class="flex flex-col gap-6 md:gap-6 lg:gap-10">
                            <h2>{{ $category }}</h2>
                            <div
                                class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-y-8 gap-x-4 md:gap-y-10 md:gap-x-6 lg:gap-y-14 lg:gap-x-6">
                                @foreach ($members as $member)
                                    <div class="flex flex-col gap-4 md:gap-4 lg:gap-6 w-full">
                                        <div class="relative w-full overflow-hidden rounded-xl">
                                            <img src="{{ $bgDireksi }}" alt=""
                                                class="image-grayscale pointer-events-none w-full h-60 md:h-70 lg:h-140 object-cover">
                                            <div class="overlay-bg-management"></div>
                                            @if ($member['photo'])
                                                <img src="{{ $member['photo'] }}" alt="{{ $member['name'] }}"
                                                    class="absolute bottom-0 left-1/2 -translate-x-1/2 h-full w-[70%] md:w-[64%] lg:w-[50%] object-contain object-bottom z-3">
                                            @else
                                                <div class="absolute inset-0 flex items-end justify-center z-3">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <p class="title-display text-xl md:text-xl lg:text-2xl">
                                                {{ $member['name'] }}</p>
                                            <p class="text-(--color-primary) uppercase">
                                                {{ $member['position'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            </div>
        </section>

    </main>
    <x-layouts.footer.footer />
</x-layouts.main>
