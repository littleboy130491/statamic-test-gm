@php
    $dealerTitle = 'Jaringan Dealer di Seluruh Indonesia';
    $dealerDesc =
        'Didukung jaringan dealer, workshop, dan layanan purna jual yang tersebar di berbagai untuk memastikan armada Anda tetap produktif dan bekerja optimal.';

@endphp


<x-layouts.main>
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage title="Dealer" :image="asset('assets/hero-dealer.jpg')" />

        {{-- Halaman dealer --}}
        <section id="dealer-page">
            <div class="container">
                <div class="my-18 md:my-18 lg:my-30 flow flex flex-col items-center">
                    <h2 class="text-left md:text-center lg:text-center">{{ $dealerTitle }}</h2>
                    <p class="w-full lg:w-160 text-left md:text-center lg:text-center">{{ $dealerDesc }}</p>
                </div>
            </div>
        </section>

        {{-- Maps dealer --}}
        <x-layouts.dealer-map />

    </main>

    <x-layouts.footer.footer />
</x-layouts.main>
