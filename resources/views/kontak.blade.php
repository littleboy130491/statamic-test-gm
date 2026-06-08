@php
    $bodyClass = collect([
        $is_entry ?? false ? 'entry' : null,
        isset($collection) ? 'entry-' . $collection : null,
        isset($collection) ? $collection : null,
        isset($slug) ? 'slug-' . $slug : null,
    ])
        ->filter()
        ->implode(' ');

    $contact = [
        [
            'title_phone' => 'Nomor Telp',
            'phone1' => '+ 62 000 0000 0000',
            'phone2' => '+ 62 000 0000 0000',
        ],

        [
            'title_email' => 'Email',
            'email1' => 'email@dummy.com',
        ],

        [
            'title_address' => 'Alamat',
            'address' =>
                'Jl. Lkr. Luar Barat No.9, RT.14/RW.3, Rw. Buaya, Kecamatan Cengkareng, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11740',
            'address_url' =>
                'https://www.google.com/maps/search/?api=1&query=Jl.+Lkr.+Luar+Barat+No.9%2C+RT.14%2FRW.3%2C+Rw.+Buaya%2C+Kecamatan+Cengkareng%2C+Kota+Jakarta+Barat%2C+Daerah+Khusus+Ibukota+Jakarta+11740',
        ],
    ];
    $socials = [
        [
            'name' => 'Instagram',
            'link' => 'https://instagram.com/gayamakmurmobil',
            'icon' => asset('assets/instagram.svg'),
        ],
        ['name' => 'Facebook', 'link' => 'https://facebook.com/fawindonesia/', 'icon' => asset('assets/facebook.svg')],
        [
            'name' => 'LinkedIn',
            'link' => 'https://linkedin.com/company/fawindonesia',
            'icon' => asset('assets/linkedin.svg'),
        ],
    ];

    $mapEmbed = $mapEmbed =
        '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.706041215713!2d106.72720077588374!3d-6.170101793817197!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f785e478eed7%3A0x22011b641a6b1e4!2sGaya%20Makmur%20Mobil%20Pt.%2C%20Rw.%20Buaya%2C%20Kecamatan%20Cengkareng%2C%20Kota%20Jakarta%20Barat%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2011740!5e0!3m2!1sen!2sid!4v1779440004920!5m2!1sen!2sid" width="100%" height="450" style="border:0;width:100%;height:100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';

    $formText = collect($page->sections)->first(fn($section) => (string) $section['identifier'] === 'text-form');

@endphp
@push('head')
    <statamic:captcha:head>
    @endpush

    <x-layouts.main :body-class="$bodyClass">
        <x-layouts.header.header />

        <main>
            <x-layouts.hero.heropage :title="$page->title" :image="$page->featured_image" />

            {{-- Halaman kontak --}}
            <section id="kontak">
                <div class="container">
                    <div class="mt-18 flex flex-col-reverse gap-18 lg:my-0 lg:mt-30 lg:flex-row lg:gap-8">

                        {{-- Kontak form --}}
                        <div id="form-contact" class="lg:w-[70%]">

                            <div id="header-form"
                                class="px-4 py-6 bg-(--color-surface) rounded-2xl flow lg:p-6 lg:rounded-3xl">
                                @if ($formText && $formText['show'])
                                    <h2 class="lg:w-180 mb-4">{{ $formText['heading'] }}</h2>
                                    <div class="lg:w-150">{!! $formText['description'] !!}</div>
                                @endif
                                <div id="form"></div>
                            </div>

                        </div>

                        {{-- Informasi kontak --}}
                        <div id="contact-information" class="lg:w-[40%]">

                            {{-- Konten kontak --}}
                            <div class="flex flex-col gap-8">

                                @foreach ($contact as $item)
                                    <div
                                        class="flex flex-col gap-2 {{ $loop->first ? '' : 'border-t border-(--color-line) mt-6 pt-6' }}">
                                        {{-- Nomor telepon --}}
                                        @if (isset($item['title_phone']))
                                            <div id="phone-number" class="flex flex-col gap-2">
                                                <span
                                                    class="title-display text-xl text-(--color-primary)">{{ $item['title_phone'] }}</span>
                                                <div class="flex flex-col gap-1">

                                                    <a href="tel:{{ preg_replace('/\s+/', '', $item['phone1']) }}"
                                                        class="text-(--color-body) hover:text-(--color-secondary)">
                                                        {{ $item['phone1'] }}
                                                    </a>

                                                    <a href="tel:{{ preg_replace('/\s+/', '', $item['phone2']) }}"
                                                        class="text-(--color-body) hover:text-(--color-secondary)">
                                                        {{ $item['phone2'] }}
                                                    </a>

                                                </div>
                                            </div>
                                        @endif

                                        {{-- Email --}}
                                        @if (isset($item['title_email']))
                                            <div id="email" class="flex flex-col gap-2">
                                                <span
                                                    class="title-display text-(--color-primary)">{{ $item['title_email'] }}</span>
                                                <div class="flex flex-col gap-1">

                                                    <a href="mailto:{{ $item['email1'] }}"
                                                        class="text-(--color-body) hover:text-(--color-secondary)">
                                                        {{ $item['email1'] }}
                                                    </a>

                                                </div>
                                            </div>
                                        @endif

                                        {{-- Alamat kantor --}}
                                        @if (isset($item['title_address']))
                                            <div id="address-office" class="flex flex-col gap-2">

                                                <span
                                                    class="title-display text-(--color-primary)">{{ $item['title_address'] }}</span>
                                                @if (!empty($item['address_url']))
                                                    <a href="{{ $item['address_url'] }}" target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="text-(--color-body) hover:text-(--color-secondary) lg:w-[90%]">
                                                        {{ $item['address'] }}
                                                    </a>
                                                @else
                                                    <p>{{ $item['address'] }}</p>
                                                @endif

                                            </div>
                                        @endif
                                @endforeach

                                {{-- Media sosial --}}
                                <div id="social-media"
                                    class="flex flex-col gap-4 border-t border-(--color-line) mt-6 pt-6">
                                    <span class="title-display text-(--color-primary)">Media Sosial</span>
                                    <div class="flex gap-6">
                                        @foreach ($socials as $social)
                                            <a href="{{ $social['link'] }}" target="_blank" rel="noopener noreferrer"
                                                title="{{ $social['name'] }}" class="hover:text-(--color-primary)">
                                                <span class="social-icon block w-5 h-5 social-icon-grey"
                                                    style="--icon-url: url('{{ $social['icon'] }}');"></span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                            </div>

                            {{-- Maps --}}
                            <div class="mt-10 h-75 overflow-hidden rounded-2xl lg:rounded-3xl">
                                {!! $mapEmbed !!}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <x-layouts.footer.cp-footer />
    </x-layouts.main>
