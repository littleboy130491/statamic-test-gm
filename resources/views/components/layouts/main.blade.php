@props([
    'bodyClass' => '',
    'locale' => null,
])

@php
    $locale = $locale ?? app()->getLocale();
    $classes = trim('locale-' . $locale . ' ' . $bodyClass);
@endphp

<!doctype html>
<html lang="{{ $locale }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
    @stack('scripts')
    @stack('body_end')
</body>

</html>
