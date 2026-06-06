@php
    $company_name = 'PT Gaya Makmur Mobil';
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

<footer id="secondary-footer" class="bg-white relative z-10 rounded-t-2xl md:rounded-t-3xl lg:rounded-t-4xl">
    <div class="container">
        <div id="footer-menu-wrapper" class="overflow-x-auto border-b border-(--color-line)">
            <ul
                class="flex min-w-max items-center gap-6 whitespace-nowrap py-8 md:justify-between lg:min-w-0 lg:justify-between lg:gap-4">
                <s:nav handle="secondary_footer">
                    <li class="shrink-0">
                        <a href="{{ $url }}"
                            class="text-(--color-text) hover:text-(--color-primary) font-(family-name:--font-body) font-normal">
                            {{ $title }}
                        </a>
                    </li>
                </s:nav>
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
