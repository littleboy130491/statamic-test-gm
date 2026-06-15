@php
    $bodyClass = collect([
        $is_entry ?? false ? 'entry' : null,
        isset($collection) ? 'entry-' . $collection : null,
        isset($collection) ? $collection : null,
        isset($slug) ? 'slug-' . $slug : null,
    ])
        ->filter()
        ->implode(' ');

    $globals = \Statamic\Facades\GlobalSet::findByHandle('settings')?->inCurrentSite()?->data();

    // Global label kontak
    $contactLabel = \Statamic\Facades\GlobalSet::findByHandle('contact_label_information')?->inCurrentSite()?->data();

    // Telepon
    $phones = collect($globals['phone_numbers'] ?? [])
        ->filter(fn($item) => $item['enabled'] ?? false)
        ->pluck('number')
        ->filter()
        ->values()
        ->all();

    // Email
    $emails = collect($globals['emails'] ?? [])
        ->filter(fn($item) => $item['enabled'] ?? false)
        ->pluck('email')
        ->filter()
        ->values()
        ->all();

    // Alamat & link maps
    $address = $globals['address'] ?? null;
    $addressUrl = $globals['google_map_link'] ?? null;

    // Embed maps
    $mapEmbed = $globals['google_maps_embed'] ?? null;

    // Sosmed
    $socials = collect($globals['social_media'] ?? [])
        ->map(function ($item, $key) {
            $url = $item['url'] ?? null;
            if (!$url) {
                return null;
            }

            $iconRaw = $item['image'] ?? null;

            return [
                'name' => ucfirst($key),
                'link' => $url,
                'icon' => $iconRaw ? asset('assets/' . $iconRaw) : null,
            ];
        })
        ->filter()
        ->values()
        ->all();

    $formText = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'text-form',
    );

    // Cek component
    $hasHeader = view()->exists('components.layouts.header.header');
    $hasHeroPage = view()->exists('components.layouts.hero.heropage');
    $hasContactForm = view()->exists('components.layouts.form.contact-form');
    $hasFooter = view()->exists('components.layouts.footer.cp-footer');
@endphp

@push('head')
    <statamic:captcha:head>
    @endpush

    <x-layouts.main :body-class="$bodyClass">
        @if ($hasHeader)
            <x-layouts.header.header />
        @endif

        <main>
            @if ($hasHeroPage)
                <x-layouts.hero.heropage :title="$page->title" :image="$page->featured_image" />
            @endif

            {{-- Halaman kontak --}}
            <section id="{{ $formText['anchor'] ?? 'kontak' }}">
                <div class="container">
                    <div class="mt-18 flex flex-col-reverse gap-18 lg:my-0 lg:mt-30 lg:flex-row lg:gap-8">

                        {{-- Kontak form --}}
                        <div id="form-contact" class="lg:w-[70%]">

                            <div id="header-form"
                                class="px-4 py-6 bg-(--color-surface) rounded-2xl flow lg:p-6 lg:rounded-3xl flex flex-col gap-10">
                                <div id="text-form">
                                    @if ($formText && ($formText['show'] ?? false))
                                        <h2 class="lg:w-180 mb-4">{{ $formText['heading'] ?? '' }}</h2>
                                        <div class="richtext lg:w-150">{!! $formText['description'] ?? '' !!}</div>
                                    @endif
                                </div>

                                {{-- Form halaman kontak --}}
                                <div id="form">
                                    @if ($hasContactForm)
                                        <x-layouts.form.contact-form />
                                    @endif
                                </div>
                            </div>

                        </div>

                        {{-- Informasi kontak --}}
                        <div id="contact-information" class="lg:w-[40%]">

                            {{-- Konten kontak --}}
                            <div class="flex flex-col gap-8">

                                {{-- Nomor telepon --}}
                                @if (count($phones) > 0)
                                    <div id="phone-number" class="flex flex-col gap-2">
                                        @if (!empty($contactLabel['phone_number_heading']))
                                            <span
                                                class="title-display text-xl text-(--color-primary)">{{ $contactLabel['phone_number_heading'] }}</span>
                                        @endif
                                        <div class="flex flex-col gap-1">
                                            @foreach ($phones as $phone)
                                                <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}"
                                                    class="text-(--color-body) hover:text-(--color-secondary)">
                                                    {{ $phone }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Email --}}
                                @if (count($emails) > 0)
                                    <div id="email" class="flex flex-col gap-2 border-t border-(--color-line) pt-6">
                                        @if (!empty($contactLabel['email_heading']))
                                            <span
                                                class="title-display text-xl text-(--color-primary)">{{ $contactLabel['email_heading'] }}</span>
                                        @endif
                                        <div class="flex flex-col gap-1">
                                            @foreach ($emails as $email)
                                                <a href="mailto:{{ $email }}"
                                                    class="text-(--color-body) hover:text-(--color-secondary)">
                                                    {{ $email }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Alamat kantor --}}
                                @if ($address)
                                    <div id="address-office"
                                        class="flex flex-col gap-2 border-t border-(--color-line) pt-6">
                                        @if (!empty($contactLabel['address_heading']))
                                            <span
                                                class="title-display text-xl text-(--color-primary)">{{ $contactLabel['address_heading'] }}</span>
                                        @endif
                                        @if (!empty($addressUrl))
                                            <a href="{{ $addressUrl }}" target="_blank" rel="noopener noreferrer"
                                                class="text-(--color-body) hover:text-(--color-secondary) lg:w-[90%]">
                                                {{ $address }}
                                            </a>
                                        @else
                                            <p>{{ $address }}</p>
                                        @endif
                                    </div>
                                @endif

                                {{-- Media sosial --}}
                                @if (count($socials) > 0)
                                    <div id="social-media"
                                        class="flex flex-col gap-4 border-t border-(--color-line) pt-6">
                                        @if (!empty($contactLabel['social_media_labels']))
                                            <span
                                                class="title-display text-xl text-(--color-primary)">{{ $contactLabel['social_media_labels'] }}</span>
                                        @endif
                                        <div class="flex gap-6">
                                            @foreach ($socials as $social)
                                                <a href="{{ $social['link'] }}" target="_blank"
                                                    rel="noopener noreferrer" title="{{ $social['name'] }}"
                                                    class="hover:text-(--color-primary)">
                                                    <span class="social-icon block w-5 h-5 social-icon-grey"
                                                        style="--icon-url: url('{{ $social['icon'] }}');"></span>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                            </div>

                            {{-- Maps --}}
                            @if ($mapEmbed)
                                <div
                                    class="mt-10 h-75 overflow-hidden rounded-2xl lg:rounded-3xl [&_iframe]:w-full [&_iframe]:h-full">
                                    {!! $mapEmbed !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @if ($hasFooter)
            <x-layouts.footer.cp-footer />
        @endif
    </x-layouts.main>
