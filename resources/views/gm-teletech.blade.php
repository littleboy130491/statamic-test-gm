@php
    $teletech_desc =
        'GMM Teletech merupakan sistem manajemen untuk kendaraan yang dibangun dan dikembangkan oleh PT Gaya Makmur Mobil. Dengan GMM Teletech #SobatGaya dapat selalu mengetahui mengenai lokasi, kondisi kendaraan, perilaku berkendara secara realtime melalui perangkat smartphone ataupun computer yang terhubung dengan internet, bahkan saat kehilangan koneksi internet pun data akan tetap disimpan dan dikirim saat terkoneksi kembali. Dengan informasi-informasi tersebut #SobatGaya bisa melakukan banyak hal seperti perencanaan dan pengaturan kerja yang lebih baik, memaksimalkan operasional kendaraan, meminimalkan resiko downtime kendaraan yang akan berujung pada efisiensi bisnis dan keuntungan yang lebih besar.';
    $teletech_image = asset('images/img-gm-teletech.jpg');
    $fiturBenefit_title = 'Fitur & Benefit';
    $fiturBenefit_iconplaceholder = asset('images/icon-placeholder,svg');
    $fiturBenefit_items = [
        [
            'icon' => asset('images/fitur-benefit-1.svg'),
            'title' => 'Pemantauan Bahan Bakar',
            'desc' =>
                'Pemberitahuan instan mengenai efisiensi penggunaan BBM, pemakaian BBM yang tidak normal, indikasi penyimpangan BBM.',
        ],
        [
            'icon' => asset('images/fitur-benefit-2.svg'),
            'title' => 'Utility Armada',
            'desc' =>
                'Data mengenai penggunaan kendaraan, kendaraan mana yang produktif dan kendaraan yang dia (idle), perbandingan antara kendaraan yang berhenti dan kendaraan yang beroperasi.',
        ],
        [
            'icon' => asset('images/fitur-benefit-3.svg'),
            'title' => 'Data Real Time & Riwayat Perjalanan Kendaraan',
            'desc' =>
                'Terintegrasi dengan google maps sehingga secara otomatis sistem akan terus mengupdate posisi & lokasi kendaraan. Membandingkan perencanaan perjalanan dengan riwayat perjalanan aktual untuk rencana kerja yang lebih baik.',
        ],
        [
            'icon' => asset('images/fitur-benefit-4.svg'),
            'title' => 'Perilaku Pengemudi',
            'desc' =>
                'Menganalisa perilaku pengemudi untuk keamanan, ketetapan dan efisiensi yang lebih baik. Data perilaku pengemudi seperti cara pengereman akselarasi, batas kecepatan, serta lama mesin idle.',
        ],
        [
            'icon' => asset('images/fitur-benefit-5.svg'),
            'title' => 'Perawatan Kendaraan',
            'desc' =>
                'Secara otomatis akan mendapatkan notifikasi untuk perawatan kendaraan berdasarkan odometer dan jam operasional kendaraan.',
        ],
        [
            'icon' => asset('images/fitur-benefit-6.svg'),
            'title' => 'Laporan & Evaluasi',
            'desc' =>
                'Laporan dan Evaluasi terkait dengan pengoperasian kendaraan untuk mengukur dan meningkatkan efisiensi dari operasional perusahaan.',
        ],
    ];
    $imageCTA_fiturBenefit = asset('images/cta-gmteletch.jpg');
    $titleCTA_fiturBenefit = 'Pantau Kapan pun & Dimana pun FAW Trucks Kalian Berada!';
    $contactCTA_fiturBenefit = [
        [
            'icon' => asset('images/whatsapp-white.svg'),
            'title' => 'Call & WA Center',
            'name' => '62 000 0000 0000',
            'phoneNumber' => '+62 000 0000 0000',
            'whatsappURL' => '/kontak',
        ],
    ];
@endphp

<x-layouts.main>
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage title="GM Teletech" :image="asset('images/hero-gm-teletech.jpg')" />

        {{-- Image Map --}}
        <section id="gm-teletech-map">
            <div class="container">
                <div class="flex flex-col items-center my-18 gap-18 lg:my-30 lg:gap-30">
                    <p class="text-left md:text-center lg:text-center lg:w-285">{{ $teletech_desc }}</p>
                    <img src="{{ $teletech_image }}" alt="REMAN Center" class="rounded-2xl w-full lg:h-150 object-cover">
                </div>
            </div>
        </section>

        {{-- Fitur & Benefit --}}
        <section id="fitur-benefit">
            <div class="container">
                <div class="flex flex-col gap-6 my-18 md:gap-10 md:my-18 lg:gap-10 lg:my-30">

                    <h2 id="title-fitur-benefit">{{ $fiturBenefit_title }}</h2>

                    {{-- Grid Fitur & Benefit --}}
                    <div id="fitur-benefit-content" data-equal-height class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($fiturBenefit_items as $item)
                            <div
                                class="flex flex-col gap-14 p-6 bg-(--color-surface) rounded-3xl md:p-6 md:gap-14 lg:p-6 lg:gap-20">
                                <img src="{{ !empty($item['icon']) ? $item['icon'] : $fiturBenefit_iconplaceholder }}"
                                    alt="Icon" class="w-10 h-10">
                                <div class="flow">
                                    <h4 class="text-black">{{ $item['title'] }}</h4>
                                    <p>{{ $item['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        {{-- Pemantauan trucks --}}
        <section id="cta-gm-teletech">
            <div class="container">
                <div class="flex flex-col items-center gap-6 my-18 md:flex-row md:my-18 lg:flex-row lg:my-30">
                    <img src="{{ $imageCTA_fiturBenefit }}" alt=" {{ $titleCTA_fiturBenefit }} "
                        class="md:w-[40%] lg:w-[40%]">

                    {{-- Konten CTA --}}
                    <div class="flex flex-col gap-4">
                        <h2 class="lg:w-180">{{ $titleCTA_fiturBenefit }}</h2>
                        @foreach ($contactCTA_fiturBenefit as $contact)
                            <a @if (!empty($contact['whatsappURL'])) href="{{ $contact['whatsappURL'] }}" target="_blank" @endif
                                class="group bg-(--color-surface) hover:bg-(--color-secondary) flex justify-between items-center rounded-full p-3 pl-6 md:p-3 md:pl-6 lg:p-3 lg:pl-8 transition-colors">

                                {{-- WhatsApp number --}}
                                <div class="lg:flex lg:w-[90%] lg:items-center lg:justify-between">
                                    <p class="font-medium group-hover:text-black transition-colors">
                                        {{ $contact['title'] }}
                                    </p>
                                    <span
                                        class="title-display group-hover:text-black -mb-1 transition-colors">{{ $contact['name'] }}
                                </div>

                                {{-- Icon WhatsApp --}}
                                <div
                                    class="bg-(--color-primary) group-hover:bg-black flex items-center justify-center rounded-full transition-colors w-12 h-12 md:w-12 md:h-12 lg:w-12 lg:h-12">
                                    <img src="{{ $contact['icon'] }}" alt="{{ $contact['title'] }}" class="w-5 h-5">
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

    </main>

    <x-layouts.footer.footer />

</x-layouts.main>
