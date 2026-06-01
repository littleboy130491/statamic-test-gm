@php
    $reman_desc =
        'Hadirnya REMAN Center GMM pertama kali yakni dibalikpapan menjadi bukti serius GMM untuk terus memberikan pelayanan terbaik untuk semua konsumen & #SobatGaya sekalian di Indonesia. Sebuah fasilitas yang terhitung masih langka di daerah Balikpapan. Ada banyak benefit dan keuntungan yang #SobatGaya dapatkan dari pelayanan REMAN Center ini; GMM REMAN Center meliputi produk utamanya: Mesin, Transmisi dan Gardan, serta rebuild (membangun) komponen selain 3 produk utama. REMAN Center ini menjadi fungsi optimal untuk menjaga ketersediaan stok komponen unit sebagai antisipasi mengurangi waktu downtime (dibandingkan harus menunggu part komponen) dan mengurangi biaya lebih tinggi yang timbul (dibandingkan membeli komponen baru).';
    $reman_image = asset('assets/reman-image.jpg');
@endphp

<x-layouts.main>
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage title="Reman Center" :image="asset('assets/hero-reman-center.jpg')" />

        {{-- Halaman REMAN Center --}}
        <section id="reman-center">
            <div class="container">
                <div class="flex flex-col items-center my-18 gap-18 lg:my-30 lg:gap-30">
                    <p class="text-left md:text-center lg:text-center lg:w-240">{{ $reman_desc }}</p>
                    <img src="{{ $reman_image }}" alt="REMAN Center" class="rounded-2xl w-full lg:h-150 object-cover">
                </div>
            </div>
        </section>
    </main>

    <x-layouts.footer.footer />
</x-layouts.main>
