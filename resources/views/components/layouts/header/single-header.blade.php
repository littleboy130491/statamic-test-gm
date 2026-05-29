@php
    $logo_url = asset('images/gm-logo.png');
    $langs = ['ID', 'EN'];
    $activeLang = request('lang', 'id');
    $menus = [
        ['menu_text' => 'Beranda', 'menu_link' => '/'],
        [
            'menu_text' => 'Tentang',
            'children' => [
                ['menu_text' => 'Manajemen', 'menu_link' => '/manajemen'],
                ['menu_text' => 'Sertifikat & Penghargaan', 'menu_link' => '/sertifikat-penghargaan'],
            ],
        ],
        ['menu_text' => 'Dealer', 'menu_link' => '/dealer'],
        ['menu_text' => 'Produk', 'menu_link' => '/produk'],
        [
            'menu_text' => 'Layanan',
            'children' => [
                ['menu_text' => 'Layanan 1', 'menu_link' => '/layanan'],
                ['menu_text' => 'Layanan 2', 'menu_link' => '/layanan'],
            ],
        ],
        ['menu_text' => 'Berita dan Artikel', 'menu_link' => '/artikel'],
        ['menu_text' => 'Karier', 'menu_link' => '/karier'],
        ['menu_text' => 'Kontak', 'menu_link' => '/kontak'],
    ];
@endphp

<header id="single-header">
    <div class="container">
        <div class="flex items-center justify-between border-b border-(--color-line)/20 py-5 lg:gap-8">
            <a href="/" class="inline-flex items-center">
                <img src="{{ $logo_url }}" alt="GM Mobil Logo" class="h-auto w-28 md:w-28 lg:w-32" />
            </a>

            <!-- Desktop Navigation -->
            <nav id="desktop-menu" class="hidden lg:flex flex-1 justify-center">
                <ul class="flex items-center justify-center gap-16 font-(family-name:--font-body)">
                    @foreach ($menus as $menu)
                        <li class="group relative shrink-0">
                            @if (!empty($menu['children']))
                                @if (!empty($menu['menu_link']))
                                    <a href="{{ $menu['menu_link'] }}"
                                        class="flex items-center gap-2 font-medium text-black hover:text-(--color-primary) active:text-(--color-primary)">
                                        <span>{{ $menu['menu_text'] }}</span>
                                        <span
                                            class="flex h-2.5 w-2.5 items-center justify-center transition-transform duration-200 group-hover:rotate-180">
                                            <svg viewBox="0 0 12 8" fill="none" aria-hidden="true" class="h-2.5 w-3">
                                                <path d="M1 1.25L6 6.25L11 1.25" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </a>
                                @else
                                    <div
                                        class="flex cursor-pointer items-center gap-2 font-medium text-black hover:text-(--color-primary)">
                                        <span>{{ $menu['menu_text'] }}</span>
                                        <span
                                            class="flex h-2.5 w-2.5 items-center justify-center transition-transform duration-200 group-hover:rotate-180">
                                            <svg viewBox="0 0 12 8" fill="none" aria-hidden="true" class="h-2.5 w-3">
                                                <path d="M1 1.25L6 6.25L11 1.25" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </div>
                                @endif
                            @else
                                <a href="{{ $menu['menu_link'] }}"
                                    class="flex items-center gap-2 font-medium text-black hover:text-(--color-primary) active:text-(--color-primary)">
                                    <span>{{ $menu['menu_text'] }}</span>
                                </a>
                            @endif

                            @if (!empty($menu['children']))
                                <ul
                                    class="invisible absolute left-1/2 z-30 mt-8 min-w-56 -translate-x-1/2 rounded-2xl border border-(--color-line)/20 bg-white p-3 opacity-0 shadow-[0_16px_40px_rgba(0,0,0,0.18)] transition-all duration-200 group-hover:visible group-hover:opacity-100">
                                    @foreach ($menu['children'] as $child)
                                        <li>
                                            <a href="{{ $child['menu_link'] }}"
                                                class="block px-1 py-1.5 text-black transition-colors hover:text-(--color-primary) text-sm">
                                                {{ $child['menu_text'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>

            <!-- Language Desktop -->
            <div class="hidden lg:flex items-center gap-0.5 text-sm font-(family-name:--font-body)">
                @foreach ($langs as $lang)
                    <a href="?lang={{ strtolower($lang) }}"
                        class="grid h-9 w-9 place-items-center rounded-full text-center leading-none transition-colors hover:bg-(--color-surface) hover:text-(--color-text-button-secondary) {{ strtolower($activeLang) === strtolower($lang) ? 'bg-(--color-surface) text-(--color-text-button-secondary)' : 'text-black' }}">
                        <span style="line-height:1;display:block;">{{ $lang }}</span>
                    </a>
                @endforeach
            </div>

            <!-- Hamburger Button -->
            <button id="menu-toggle" type="button" aria-controls="mobile-menu" aria-expanded="false"
                class="lg:hidden flex flex-col justify-center items-center w-8 h-8 space-y-1">
                <span class="block w-6 h-0.5 bg-black"></span>
                <span class="block w-6 h-0.5 bg-black"></span>
                <span class="block w-6 h-0.5 bg-black"></span>
            </button>
        </div>

        @include('components.layouts.header.flyout')
    </div>
</header>
