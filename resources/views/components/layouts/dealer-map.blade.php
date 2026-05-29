@php
    $categoriesDealer = [
        ['id' => 'cabang-dealer', 'label' => 'Cabang & Dealer'],
        ['id' => 'service-center', 'label' => 'Service Center'],
        ['id' => 'part-shop', 'label' => 'Part Shop'],
    ];

    $locationsDealer = [
        [
            'city' => 'Jakarta',
            'dealer-category' => 'cabang-dealer',
            'company' => 'PT. GM Mobil Jakarta',
            'address' =>
                'Kawasan Pergudangan Diamond Cipta Niaga, Jl. Arteri Jl. Yos Sudarso No.A15, Bandarharjo, Kec. Semarang Utara, Kota Semarang, Jawa Tengah 50175',
            'whatsapp' => '0811 1212 0566',
            'phone' => '(024) 86570705',
            'maps_url' => 'https://maps.google.com/?q=-6.1944,106.8229',
            'lat' => -6.1944,
            'lng' => 106.8229,
        ],
        [
            'city' => 'Jakarta',
            'dealer-category' => 'service-center',
            'company' => 'GM Service Center Jakarta Selatan',
            'address' =>
                'Kawasan Pergudangan Diamond Cipta Niaga, Jl. Arteri Jl. Yos Sudarso No.A15, Bandarharjo, Kec. Semarang Utara, Kota Semarang, Jawa Tengah 50175',
            'whatsapp' => '0811 1212 0566',
            'phone' => '(024) 86570705',
            'maps_url' => 'https://maps.google.com/?q=-6.2607,106.7816',
            'lat' => -6.2607,
            'lng' => 106.7816,
        ],
        [
            'city' => 'Bandung',
            'dealer-category' => 'part-shop',
            'company' => 'GM Part Shop Bandung',
            'address' =>
                'Kawasan Pergudangan Diamond Cipta Niaga, Jl. Arteri Jl. Yos Sudarso No.A15, Bandarharjo, Kec. Semarang Utara, Kota Semarang, Jawa Tengah 50175',
            'whatsapp' => '0811 1212 0566',
            'phone' => '(024) 86570705',
            'maps_url' => 'https://maps.google.com/?q=-6.9175,107.6191',
            'lat' => -6.9175,
            'lng' => 107.6191,
        ],
    ];
@endphp

<section id="dealer-maps">
    <div class="container">
        <div class="my-18 md:my-18 lg:my-30">

            {{-- Filter Kategori & Search --}}
            <div
                class="flex flex-col gap-4 items-center md:flex md:justify-between md:flex-row-reverse lg:flex lg:flex-row-reverse lg:justify-between mb-6">

                {{-- Search Kota --}}
                <div id="city-search" class="w-full md:w-[40%] lg:w-[25%] flex justify-end">
                    <div class="flex w-full rounded overflow-hidden border border-(--color-line)">
                        <input type="text" id="dealer-search" placeholder="Ketik Kota"
                            class="py-2.5 px-4 w-full outline-none text-sm font-(family-name:--font-body)" />
                        <button type="button"
                            class="group flex items-center justify-center px-3.5 bg-(--color-primary) hover:bg-black shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                class="h-5 w-5 text-white">
                                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" />
                                <path d="M16.5 16.5L21 21" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Kategori Dealer --}}

                {{-- Desktop: Button --}}
                <div id="dealer-category-filter" class="hidden flex-col gap-2 lg:flex lg:flex-row">
                    @foreach ($categoriesDealer as $cat)
                        <a href="javascript:void(0)"
                            class="dealer-cat-btn flex items-center gap-2 text-sm text-(--color-primary) hover:text-white bg-(--color-surface) hover:bg-(--color-primary) uppercase py-3 px-8 rounded-full"
                            data-category="{{ $cat['id'] }}">
                            <span>{{ $cat['label'] }}</span>
                            <svg viewBox="0 0 12 12" fill="none" aria-hidden="true" class="h-4 w-4">
                                <path d="M4 2L8 6L4 10" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </a>
                    @endforeach
                </div>

                {{-- Mobile: dropdown --}}
                <select id="dealer-category-select"
                    class="lg:hidden w-full border border-(--color-border) rounded-lg px-4 py-2 text-sm text-(--color-text) bg-white focus:outline-none focus:border-(--color-primary) md:w-[30%]">
                    <option value="all">Semua</option>
                    @foreach ($categoriesDealer as $cat)
                        <option value="{{ $cat['id'] }}">{{ $cat['label'] }}</option>
                    @endforeach
                </select>

            </div>

            {{-- Map --}}
            <div id="dealer-map" style="height: 350px; width: 100%; border-radius: 24px;" class="md:h-120!"></div>

        </div>
    </div>
</section>

{{-- Share data lokasi > dealer-map.js --}}
<script>
    window.dealerLocations = @json($locationsDealer);
</script>
