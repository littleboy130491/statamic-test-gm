@props([
    'type' => null,
])

@php
    $company_name = 'PT Gaya Makmur Mobil';
    $menus = [
        ['menu_text' => 'Beranda', 'menu_link' => '/'],
        [
            'menu_text' => 'Tentang',
            'menu_link' => '/tentang',
            'children' => [
                ['menu_text' => 'Visi & Misi', 'menu_link' => '/tentang#visi-misi'],
                ['menu_text' => 'Team', 'menu_link' => '/tentang#team'],
            ],
        ],
        ['menu_text' => 'Dealer', 'menu_link' => '/dealer'],
        ['menu_text' => 'Produk', 'menu_link' => '/produk'],
        [
            'menu_text' => 'Layanan',
            'menu_link' => '/layanan',
            'children' => [
                ['menu_text' => 'Layanan 1', 'menu_link' => '/layanan/1'],
                ['menu_text' => 'Layanan 2', 'menu_link' => '/layanan/2'],
            ],
        ],
        ['menu_text' => 'Berita dan Artikel', 'menu_link' => '/artikel'],
        ['menu_text' => 'Karier', 'menu_link' => '/karier'],
        ['menu_text' => 'Kontak', 'menu_link' => '/kontak'],
    ];
    $socials = [
        [
            'name' => 'Instagram',
            'link' => 'https://instagram.com/gayamakmurmobil',
            'icon' => asset('images/instagram.svg'),
        ],
        ['name' => 'Facebook', 'link' => 'https://facebook.com/fawindonesia/', 'icon' => asset('images/facebook.svg')],
        [
            'name' => 'LinkedIn',
            'link' => 'https://linkedin.com/company/fawindonesia',
            'icon' => asset('images/linkedin.svg'),
        ],
    ];
@endphp

<footer id="secondary-footer"
    {{ $attributes->class([$type, 'relative z-10 rounded-t-2xl md:rounded-t-3xl lg:rounded-t-4xl']) }}>
    <div class="container">
        <div id="footer-menu-wrapper" class="overflow-x-auto border-b border-(--color-line)">
            <ul
                class="flex min-w-max items-center gap-6 whitespace-nowrap py-8 md:justify-between lg:min-w-0 lg:justify-between lg:gap-4">
                @foreach ($menus as $menu)
                    <li class="shrink-0">
                        <a href="{{ $menu['menu_link'] }}"
                            class="text-(--color-text) hover:text-(--color-primary) font-(family-name:--font-body) font-normal">
                            {{ $menu['menu_text'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div id="footer-copyright"
            class="flex flex-col-reverse md:flex-row lg:flex-row items-center justify-between gap-4 py-8">
            <p class="text-(--color-text)">© {{ date('Y') }} {{ $company_name }}</p>
            <div id="social-icons-wrapper" class="flex items-center gap-5">
                @foreach ($socials as $social)
                    <a href="{{ $social['link'] }}" target="_blank" rel="noopener noreferrer"
                        title="{{ $social['name'] }}">
                        <span class="social-icon block w-5 h-5"
                            style="--icon-url: url('{{ $social['icon'] }}');"></span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</footer>
