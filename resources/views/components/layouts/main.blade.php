@props([
    'bodyClass' => '',
    'locale' => null,
])

@php
    $locale = $locale ?? app()->getLocale();
    $classes = trim('locale-' . $locale . ' ' . $bodyClass);
    $settings = \Statamic\Facades\GlobalSet::findByHandle('settings')?->inCurrentSite();

    $favicon = $settings?->favicon;
    $favicon_url = $favicon instanceof \Statamic\Contracts\Assets\Asset
        ? $favicon->url()
        : ($favicon ? \Statamic\Facades\Asset::find('assets::' . $favicon)?->url() : null);
@endphp

@if ($settings?->custom_code_head)
    @push('head')
        {!! $settings->custom_code_head !!}
    @endpush
@endif

@if ($settings?->google_analytics_measurement_id)
    @push('head')
        {{-- Google tag (gtag.js) --}}
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->google_analytics_measurement_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $settings->google_analytics_measurement_id }}');
        </script>
    @endpush
@endif

@if ($settings?->custom_code_body)
    @push('body_start')
        {!! $settings->custom_code_body !!}
    @endpush
@endif

<!doctype html>
<html lang="{{ $locale }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if ($favicon_url)
        <link rel="icon" href="{{ $favicon_url }}" sizes="any">
        <link rel="shortcut icon" href="{{ $favicon_url }}">
        <link rel="apple-touch-icon" href="{{ $favicon_url }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap"rel="stylesheet" />

    {{-- SEO Pro meta tags --}}
    <s:seo_pro:meta />

    {{-- Main CSS/JS assets --}}
    <s:vite src="resources/js/app.js|resources/css/app.css" />

    @stack('styles')
    @stack('head')
</head>

<body class="{{ $classes }}" {{ $attributes->except('class') }}>
    @stack('body_start')
    {{ $slot }}
    <x-layouts.popup />
    @stack('scripts')
    @stack('body_end')
</body>

</html>
