@php
    $logo_url = asset('/assets/gm-logo.png');
    $contact = [
        'phone' => '1500-329',
        'email' => 'gmmcare@gmmobil.com',
    ];
@endphp

<nav>
    <!-- Mobile Flyout Menu -->
    <div id="mobile-menu"
        class="pointer-events-none invisible opacity-0 lg:hidden fixed inset-0 z-50 transition-opacity duration-300 ease-out">
        <button type="button" id="mobile-menu-backdrop" aria-label="Close menu"
            class="absolute inset-0 bg-black/45 opacity-0 transition-opacity duration-300 ease-out"></button>

        <div id="mobile-menu-panel"
            class="-translate-x-full flex h-full w-full max-w-[90%] md:max-w-[40%] flex-col bg-white px-4 py-6 transition-transform duration-300 ease-out">

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
            <div id="flyout-menu" class="border-t border-(--color-line) py-6">
                <ul class="flex flex-col gap-4 font-(family-name:--font-body)">
                    <s:nav handle="header_primary">
                        <li>
                            @if (count($children) > 0)
                                <details class="group">
                                    <summary
                                        class="flex cursor-pointer list-none items-center justify-between gap-4 text-black transition-colors hover:text-(--color-primary)">
                                        <span class="block flex-1">{{ $title }}</span>
                                        <span
                                            class="flex h-3 w-3 items-center justify-center text-black transition-transform duration-200 group-open:rotate-180">
                                            <svg viewBox="0 0 12 8" fill="none" aria-hidden="true" class="h-2.5 w-3">
                                                <path d="M1 1.25L6 6.25L11 1.25" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </summary>

                                    <ul class="mt-1 ml-2 flex flex-col gap-2">
                                        @foreach ($children as $child)
                                            <li>
                                                <a href="{{ $child['url'] }}"
                                                    class="block text-sm text-(--color-text) hover:text-(--color-primary) active:text-(--color-primary)">
                                                    {{ $child['title'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </details>
                            @else
                                <a href="{{ $url }}"
                                    class="block text-black hover:text-(--color-primary) active:text-(--color-primary)">
                                    {{ $title }}
                                </a>
                            @endif
                        </li>
                    </s:nav>
                </ul>
            </div>

            <div class="border-t border-(--color-line) py-6 font-(family-name:--font-body) text-black">

                <!-- Language Mobile -->
                <div class="gtranslate_wrapper mb-6"></div>

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
