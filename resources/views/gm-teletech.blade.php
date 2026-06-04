@php
    $opening = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'opening-teletech',
    );

    $teletechImage = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'section-image-teletech',
    );

    $fiturBenefit = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'section-fitur-benefit',
    );

    $ctaGrid = collect($page->sections)->first(
        fn($section) => (string) ($section['type'] ?? '') === 'call_to_action_grid',
    );

    $iconPlaceholderBenefit = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'icon-placeholder-benefit',
    );

    $iconPlaceholderCta = collect($page->sections)->first(
        fn($section) => (string) ($section['identifier'] ?? '') === 'icon-placeholder-cta-grid',
    );

    $iconBenefitPlaceholder = $iconPlaceholderBenefit['section_images'] ?? null;
    $iconCtaDefault = $iconPlaceholderCta['section_images'] ?? null;

    // Jumlah kolom feature grid
    $columnClassMap = [
        '1' => 'lg:grid-cols-1',
        '2' => 'md:grid-cols-2 lg:grid-cols-2',
        '3' => 'md:grid-cols-2 lg:grid-cols-3',
        '4' => 'md:grid-cols-2 lg:grid-cols-4',
    ];
    $featureColumns = $columnClassMap[(string) ($fiturBenefit['columns'] ?? '3')] ?? 'md:grid-cols-2 lg:grid-cols-3';

    // URL kontak (WhatsApp & Email)
    $buildContactUrl = function ($kontak) {
        $kontak = trim((string) $kontak);

        // Email
        if (str_contains($kontak, '@')) {
            return 'mailto:' . $kontak;
        }

        // WhatsApp
        $number = preg_replace('/[^0-9]/', '', $kontak);
        return 'https://wa.me/' . $number;
    };
@endphp

<x-layouts.main>
    <x-layouts.header.header />

    <main>
        <x-layouts.hero.heropage :title="$page->title" :image="$page->featured_image" />

        {{-- Deskripsi teletech --}}
        @if ($opening && $opening['show'])
            <section id="gm-teletech-desc">
                <div class="container">
                    <div class="flex flex-col items-center my-18 lg:my-30">
                        <div class="text-left md:text-center lg:text-center lg:w-285">{!! $opening['description'] !!}</div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Image teletech --}}
        @if ($teletechImage && $teletechImage['show'])
            <section id="gm-teletech-map">
                <div class="container">
                    <div class="flex flex-col items-center my-18 lg:my-30">
                        <img src="{{ $teletechImage['section_images'] }}" alt="{{ $page->title }}"
                            class="rounded-2xl w-full lg:h-150 object-cover">
                    </div>
                </div>
            </section>
        @endif

        {{-- Fitur & Benefit --}}
        @if ($fiturBenefit && $fiturBenefit['show'] && !empty($fiturBenefit['features']))
            <section id="fitur-benefit">
                <div class="container">
                    <div class="flex flex-col gap-6 my-18 md:gap-10 md:my-18 lg:gap-10 lg:my-30">

                        <h2 id="title-fitur-benefit">{{ $fiturBenefit['heading'] }}</h2>

                        {{-- Grid Fitur & Benefit --}}
                        <div id="fitur-benefit-content" data-equal-height class="grid gap-5 {{ $featureColumns }}">
                            @foreach ($fiturBenefit['features'] as $item)
                                <div
                                    class="flex flex-col gap-14 p-6 bg-(--color-surface) rounded-3xl md:p-6 md:gap-14 lg:p-6 lg:gap-20">
                                    <img src="{{ $item['icon'] ?: $iconBenefitPlaceholder }}" alt="Icon"
                                        class="w-10 h-10">
                                    <div class="flow">
                                        <h4 class="text-black">{{ $item['title'] }}</h4>
                                        <p>{{ $item['text'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Pemantauan trucks --}}
        @if ($ctaGrid)
            <section id="cta-gm-teletech">
                <div class="container">
                    <div class="flex flex-col items-center gap-6 my-18 md:flex-row md:my-18 lg:flex-row lg:my-30">
                        <img src="{{ $ctaGrid['image_call_to_action'] }}" alt="{{ $ctaGrid['heading'] }}"
                            class="md:w-[40%] lg:w-[40%]">

                        {{-- Konten CTA --}}
                        <div class="flex flex-col gap-4">
                            <h2 class="lg:w-180">{{ $ctaGrid['heading'] }}</h2>

                            @if (!empty($ctaGrid['description']))
                                <div class="flow">{!! $ctaGrid['description'] !!}</div>
                            @endif

                            @foreach ($ctaGrid['call_to_action'] as $contact)
                                @php
                                    $contactUrl = $buildContactUrl($contact['kontak'] ?? '');
                                    $isWhatsapp = str_starts_with($contactUrl, 'https://wa.me');
                                    $contactIcon = $contact['icon'] ?? null ?: $iconCtaDefault;
                                @endphp
                                <a href="{{ $contactUrl }}"
                                    @if ($isWhatsapp) target="_blank" rel="noopener" @endif
                                    class="group bg-(--color-surface) hover:bg-(--color-secondary) flex justify-between items-center rounded-full p-3 pl-6 md:p-3 md:pl-6 lg:p-3 lg:pl-8 transition-colors">

                                    {{-- Kontak --}}
                                    <div class="lg:flex lg:w-[90%] lg:items-center lg:justify-between">
                                        <p class="font-medium group-hover:text-black transition-colors">
                                            {{ $contact['label'] }}
                                        </p>
                                        <span
                                            class="title-display group-hover:text-black -mb-1 transition-colors">{{ $contact['kontak'] }}</span>
                                    </div>

                                    {{-- Icon kontak --}}
                                    <div
                                        class="bg-(--color-primary) group-hover:bg-black flex items-center justify-center rounded-full transition-colors w-12 h-12 md:w-12 md:h-12 lg:w-12 lg:h-12">
                                        <img src="{{ $contactIcon }}" alt="{{ $contact['label'] }}" class="w-5 h-5">
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

    </main>

    <x-layouts.footer.footer />

</x-layouts.main>
