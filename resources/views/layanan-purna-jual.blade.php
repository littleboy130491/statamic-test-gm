@php
    $purnaJual_desc =
        'Selain penjualan unit, GMM juga menyediakan pelayanan purna jual, penjualan suku cadang dan pelatihan teknik & mengemudi melalui jaringan di berbagai Kota Besar di seluruh Indonesia. GMM akan selalu menggerakkan sektor industri Indonesia dengan memberikan pelayanan serta produk yang terbaik dan berkualitas bagi pelanggan setia GMM.';
    $purnaJual_items = [
        [
            'icon' => asset('assets/icon-purnajual-1.svg'),
            'title' => 'Pelatihan Pengemudi & Teknik',
            'desc' =>
                'Pusat pelatihan GMM di dirikan dan dipersiapkan sebagai kebutuhan untuk menciptakan sumber daya manusia yang berkualitas dan profesional dengan meningkatkan kemampuan teknis dan skill yang diberikan oleh para pelatih yang sangat berpengalaman dibidangnya. Dan GMM juga memberikan kesempatan kepada pelanggan setia GMM yang memiliki mekanik dan pengemudi untuk GMM berikan pelatihan teknis & keahlian/skill agar dapat memahami dan mengerti tentang produk GMM.',
            'image' => asset('assets/purnajual-1.jpg'),
        ],
        [
            'icon' => asset('assets/icon-purnajual-2.svg'),
            'title' => 'Kontrak Layanan Pemeliharaan',
            'desc' =>
                'Program layanan dari GMM yang berupa pelayanan servis berkala dan penggantian spare part unit milik pelanggan dilaksanakan sesuai dengan jadwal servis dalam jangka waktu tertentu seperti yang tercantum dalam kontrak yang disetujui oleh kedua belah pihak. Layanan ini berupa jasa mekanik di lokasi untuk perawatan & perbaikan serta penggantian parts. GMM juga menyediakan kontrak layanan pemeliharaan lengkap “Full Maintenance Contract” yang sangat menguntungkan untuk pelanggan setia GMM.',
            'image' => asset('assets/purnajual-2.jpg'),
        ],
        [
            'icon' => asset('assets/icon-purnajual-3.svg'),
            'title' => 'Garansi',
            'desc' =>
                'Semua penjualan unit dari GMM akan mendapatkan garansi servis dan suku cadang dengan syarat dan ketentuan yang berlaku. GMM akan memastikan bahwa unit dari GMM akan dapat beroperasi sesuai dengan kebutuhan pelanggan GMM.',
            'image' => asset('assets/purnajual-3.jpg'),
        ],
        [
            'icon' => asset('assets/icon-purnajual-4.svg'),
            'title' => 'Layanan 24/7',
            'desc' =>
                'Bentuk dukungan terhadap customer berupa informasi, bimbingan teknis, perbaikan sederhana and troubleshooting melalui layanan telepon / WhatsApp.',
            'image' => asset('assets/purnajual-4.jpg'),
        ],
        [
            'icon' => asset('assets/icon-purnajual-5.svg'),
            'title' => 'Ketersediaan Suku Cadang',
            'desc' =>
                'Sebagai Agen Pemegang Merek Tunggal, GMM menyediakan layanan distribusi Suku Cadang ke cabang-cabang, dealer-dealer dan Part Shop GMM di seluruh Indonesia.',
            'image' => asset('assets/purnajual-5.jpg'),
        ],
        [
            'icon' => asset('assets/icon-purnajual-6.svg'),
            'title' => 'Konsinyasi Suku Cadang',
            'desc' =>
                'Suatu program yang menempatan suku cadang di dalam area pelanggan setia kami sesuai dengan perjanjian yang disetujui kedua belah pihak. Program ini dapat membantu pelanggan untuk mengurangi biaya inventaris suku cadang dan ketersediaan suku cadang yang lebih terjamin.',
            'image' => asset('assets/purnajual-6.jpg'),
        ],
        [
            'icon' => asset('assets/icon-purnajual-7.svg'),
            'title' => 'Program Pertukaran Komponen',
            'desc' =>
                'Untuk membantu memaksimalkan investasi pelanggan setia GMM, kami menyediakan program tukar tambah komponen yang mengalami kendala dengan komponen siap pakai milik GMM. Program ini akan membantu pelanggan setia kami mengurangi waktu kerusakan unit akibat kendala pada komponen.',
            'image' => asset('assets/purnajual-7.jpg'),
        ],
    ];
@endphp

<x-layouts.main bodyClass="background-grey">
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage title="Layanan Purna Jual" :image="asset('assets/hero-purna-jual.jpg')" />

        {{-- Halaman Purna Jual --}}
        <section id="purna-jual">
            <div class="container">
                <div class="flex flex-col items-center my-18 gap-18 lg:my-30 lg:gap-30">

                    {{-- Deskripsi halaman purna jual --}}
                    <p class="text-left md:text-center lg:text-center lg:w-250">{{ $purnaJual_desc }}</p>

                    {{-- Konten layanan purna jual --}}
                    <div id="purna-jual-content" class="reverse-div flex flex-col gap-20 w-full">
                        @foreach ($purnaJual_items as $item)
                            <div class="flex flex-col gap-4 md:gap-4 lg:gap-6 lg:flex-row">
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}"
                                    class="w-full object-cover rounded-3xl h-50 md:h-60 lg:h-112 lg:w-[50%]">
                                <div
                                    class="flex flex-col justify-center flow bg-white rounded-3xl py-8 px-5 md:px-6 lg:p-10 lg:w-[50%]">
                                    @if (!empty($item['icon']))
                                        <img src="{{ $item['icon'] }}" alt="Icon"
                                            class="w-10 h-10 mb-8 md:mb-8 lg:mb-10 lg:w-12 lg:h-12">
                                    @endif
                                    <h3>{{ $item['title'] }}</h3>
                                    <p>{{ $item['desc'] }}</p>
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
