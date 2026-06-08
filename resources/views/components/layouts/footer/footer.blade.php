@php
    $footer = \Statamic\Facades\GlobalSet::findByHandle('primary_footer')?->inCurrentSite();

    // URL Button
    $footerUrlRaw = $footer?->augmentedValue('url_button')->value();
    $footerUrl = is_object($footerUrlRaw) ? $footerUrlRaw->url() ?? (string) $footerUrlRaw : $footerUrlRaw;
    $footerUrl = $footerUrl ?: null;

    $globals = \Statamic\Facades\GlobalSet::findByHandle('settings')?->inCurrentSite()?->data();

    $company_name = $globals['site_title'] ?? 'PT Gaya Makmur Mobil';

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
@endphp

@if ($footer?->get('show'))
    <footer id="footer">
        <div class="relative overflow-hidden rounded-t-3xl lg:rounded-t-[60px]">

            {{-- Background Footer --}}
            <div id="footer-background" class="overlay-footer">
                <img src="{{ $footer->augmentedValue('backgound_image')->value()?->url() }}" alt="Footer Background"
                    class="w-full h-200 md:h-110 lg:h-150 object-cover pointer-events-none">
            </div>

            {{-- Content Footer --}}
            <div id="content-footer" class="absolute inset-0 z-10 mt-18 md:mt-15 lg:mt-15">
                <div class="container flex flex-col gap-8 justify-center md:flex-row lg:flex-row">

                    <div class="flex flex-col-reverse justify-center md:flex-row lg:flex-row gap-8 md:gap-2 lg:gap-10">

                        {{-- Image Footer --}}
                        <div id="image-footer" class="flex mb-0 md:-mb-40 md:w-[70%] lg:w-[40%]">
                            <img src="{{ $footer->augmentedValue('image')->value()?->url() }}"
                                alt="{{ $footer->get('heading') }}" class="w-ful object-contain">
                        </div>

                        {{-- CTA Footer --}}
                        <div id="cta-footer" class="flex flex-col justify-between lg:justify-center lg:w-[30%]">
                            <div class="flow">
                                <h2 class="text-white lg:w-110">{{ $footer->get('heading') }}</h2>
                                <p class="text-white lg:w-120">{{ $footer->get('short_description') }}</p>

                                {{-- Media Sosial --}}
                                <div
                                    class="flex flex-col-reverse gap-6 items-start mt-4 lg:flex-row lg:items-center lg:mt-8">
                                    @if (count($socials) > 0)
                                        <div
                                            class="flex justify-between w-full border-t border-white/20 py-4 mt-2 md:border-white/0 md:py-0 md:mt-0 lg:border-white/0 lg:py-0 lg:mt-0 lg:w-min">
                                            <p class="uppercase text-white border-white md:hidden lg:hidden">Media
                                                Sosial</p>
                                            <div class="flex gap-4">
                                                @foreach ($socials as $social)
                                                    <a href="{{ $social['link'] }}" target="_blank"
                                                        rel="noopener noreferrer" title="{{ $social['name'] }}">
                                                        <span class="social-icon block w-5 h-5 social-icon-white"
                                                            style="--icon-url: url('{{ $social['icon'] }}');"></span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Button Konsultasi --}}
                                    @if ($footerUrl)
                                        <a href="{{ $footerUrl }}" class="button gap-4 button--white">
                                            <span>{{ $footer->get('label_button') ?: 'Konsultasi Sekarang' }}</span>
                                            <svg viewBox="0 0 12 12" fill="none" aria-hidden="true" class="h-4 w-4">
                                                <path d="M4 2L8 6L4 10" stroke="currentColor" stroke-width="1"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Copyright Footer --}}
        <div id="copyrigth-footer" class="-mt-12 md:-mt-14 relative z-10">
            <p class="text-white text-center">© {{ date('Y') }} {{ $company_name }}</p>
        </div>
    </footer>
@endif
