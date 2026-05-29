@php
    $logo_url = asset('images/gm-logo.png');
    $langs = ['ID', 'EN'];
    $activeLang = request('lang', 'id');
    $contact = [
        'phone' => '1500-329',
        'email' => 'gmmcare@gmmobil.com',
    ];
    $menus = [
        ['menu_text' => 'Beranda', 'menu_link' => '/'],
        [
            'menu_text' => 'Tentang',
            'children' => [
                ['menu_text' => 'Tentang Kami', 'menu_link' => '/tentang-kami'],
                ['menu_text' => 'Manajemen', 'menu_link' => '/manajemen'],
                ['menu_text' => 'Sertifikat & Penghargaan', 'menu_link' => '/sertifikat-penghargaan'],
            ],
        ],
        ['menu_text' => 'Dealer', 'menu_link' => '/dealer'],
        ['menu_text' => 'Produk', 'menu_link' => '/produk'],
        [
            'menu_text' => 'Layanan',
            'children' => [
                ['menu_text' => 'Industri', 'menu_link' => '/industri'],
                ['menu_text' => 'Layanan Purna Jual', 'menu_link' => '/layanan-purna-jual'],
                ['menu_text' => 'Reman Center', 'menu_link' => '/reman-center'],
                ['menu_text' => 'GM Teletech', 'menu_link' => '/gm-teletech'],
            ],
        ],
        ['menu_text' => 'Berita dan Artikel', 'menu_link' => '/artikel'],
        ['menu_text' => 'Karier', 'menu_link' => '/karier'],
        ['menu_text' => 'Kontak', 'menu_link' => '/kontak'],
    ];
@endphp

<nav>
    <!-- Mobile Flyout Menu -->
    <div id="mobile-menu"
        class="pointer-events-none invisible opacity-0 lg:hidden fixed inset-0 z-50 transition-opacity duration-300 ease-out">
        <button type="button" id="mobile-menu-backdrop" aria-label="Close menu"
            class="absolute inset-0 bg-black/45 opacity-0 transition-opacity duration-300 ease-out"></button>

        <div id="mobile-menu-panel"
            class="-translate-x-full flex h-full w-full max-w-[90%] md:max-w-[40%] flex-col bg-white px-4 py-5 transition-transform duration-300 ease-out">

            <!-- Flyout Header -->
            <div id="logo-flyout" class="flex items-start justify-between pb-8">
                <a href="/" class="inline-flex items-center">
                    <img src="{{ $logo_url }}" alt="GM Mobil Logo" class="h-auto w-28" />
                </a>
                <button type="button" id="mobile-menu-close" aria-label="Close menu"
                    class="flex h-4 w-4 items-center justify-center text-2xl text-black">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Flyout Menu -->
            <div id="flyout-menu" class="border-t border-(--color-line) py-8">
                <ul class="flex flex-col gap-4 font-(family-name:--font-body)">
                    @foreach ($menus as $menu)
                        <li>
                            @if (!empty($menu['children']))
                                <details class="group">
                                    <summary
                                        class="flex cursor-pointer list-none items-center justify-between gap-4 text-black transition-colors hover:text-(--color-primary)">
                                        <span class="block flex-1">
                                            {{ $menu['menu_text'] }}
                                        </span>
                                        <span
                                            class="flex h-3 w-3 items-center justify-center text-black transition-transform duration-200 group-open:rotate-180">
                                            <svg viewBox="0 0 12 8" fill="none" aria-hidden="true" class="h-2.5 w-3">
                                                <path d="M1 1.25L6 6.25L11 1.25" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </summary>

                                    <ul class="mt-1 ml-2 flex flex-col gap-2">
                                        @foreach ($menu['children'] as $child)
                                            <li>
                                                <a href="{{ $child['menu_link'] }}"
                                                    class="block text-sm text-(--color-text) hover:text-(--color-primary) active:text-(--color-primary)">
                                                    {{ $child['menu_text'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </details>
                            @else
                                <a href="{{ $menu['menu_link'] }}"
                                    class="block text-black hover:text-(--color-primary) active:text-(--color-primary)">
                                    {{ $menu['menu_text'] }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-auto border-t border-(--color-line) py-6 font-(family-name:--font-body) text-black">

                <!-- Language Mobile -->
                <div id="lang-flyout" class="flex items-center justify-between pb-6">
                    <span class="uppercase">Pilih Bahasa</span>
                    <div class="flex items-center gap-2 font-(family-name:--font-body)">
                        @foreach ($langs as $lang)
                            <a href="?lang={{ strtolower($lang) }}"
                                class="text-black grid h-10 w-10 place-items-center rounded-full border border-(--color-line) text-center leading-none transition-colors hover:bg-(--color-secondary) hover:text-(--color-text-button-secondary) {{ strtolower($activeLang) === strtolower($lang) ? 'bg-(--color-secondary) text-(--color-text-button-secondary)' : '' }}">
                                <span style="line-height:1;display:block;">{{ $lang }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Contact Info -->
                <div id="contact-flyout" class="border-t border-(--color-line) pt-8 flex flex-col gap-6">
                    <div>
                        <p class="uppercase text-(--color-primary) mb-2">Telepon</p>
                        <a href="tel:{{ preg_replace('/\s+/', '', $contact['phone']) }}"
                            class="text-[1.2em] text-black hover:text-(--color-primary)">
                            {{ $contact['phone'] }}
                        </a>
                    </div>
                    <div>
                        <p class="uppercase text-(--color-primary) mb-2">Email</p>
                        <a href="mailto:{{ $contact['email'] }}"
                            class="text-[1.2em] text-black hover:text-(--color-primary)">
                            {{ $contact['email'] }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
