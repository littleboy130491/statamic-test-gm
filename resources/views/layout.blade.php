@php
    $body_classes = '';

    if ($is_homepage ?? false) {
        $body_classes .= 'homepage ';
    }

    if ($is_entry ?? false) {
        $body_classes .= 'entry';
        if (isset($collection)) {
            $body_classes .= " entry-{$collection}";
        }
        if (isset($id)) {
            $body_classes .= " entry-id-{$id}";
        }
        if (isset($slug)) {
            $body_classes .= " slug-{$slug}";
        }
        $body_classes .= ' ';
    }

    if ($is_taxonomy ?? false) {
        $body_classes .= 'term';
        if (isset($taxonomy)) {
            $body_classes .= " taxonomy-{$taxonomy}";
        }
        if (isset($slug)) {
            $body_classes .= " term-{$slug}";
        }
        $body_classes .= ' ';
    }

    if (isset($current_template)) {
        $body_classes .= "template-{$current_template} ";
    }

    if (isset($current_layout)) {
        $body_classes .= "layout-{$current_layout} ";
    }

    $locale = $site->short_locale ?? 'en';
    $body_classes .= "locale-{$locale}";

    $body_classes = trim($body_classes);
@endphp
<!doctype html>
<html lang="{{ $site->short_locale ?? 'en' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- SEO Pro meta tags (title, description, OG, Twitter, JSON-LD, etc.) --}}
    <s:seo_pro:meta />
    {{-- Main CSS/JS assets --}}
    <s:vite src="resources/js/site.js|resources/css/site.css" />
    {{-- Hook: Additional styles - pakai @section('styles')...@stop --}}
    @yield('styles')
    {{-- Hook: Additional head content - pakai @section('head')...@stop --}}
    @yield('head')
</head>

<body
    class="{{ $body_classes }}@hasSection('body_class')
@yield('body_class')
@endif@hasSection('body_style_class')
@yield('body_style_class')
@else
bg-zinc-100 dark:bg-zinc-900 font-sans leading-normal text-zinc-800 dark:text-zinc-400
@endif"@yield('body_attrs')>
    {{-- Hook: Body start - analytics, tag managers, etc. --}}
    @yield('body_start')
    {{-- Main content wrapper --}}
    <div
        class="@hasSection('wrapper_class')
@yield('wrapper_class')
@else
mx-auto px-2 lg:min-h-screen flex flex-col items-center justify-center
@endif">
        {{-- Hook: Before content - header, navigation, etc. --}}
        @yield('before_content')
        {{-- Main template content --}}
        {!! $template_content !!}
        {{-- Hook: After content - footer, etc. --}}
        @yield('after_content')
    </div>
    {{-- Hook: Additional scripts - pakai @section('scripts')...@stop --}}
    @yield('scripts')
    {{-- Hook: Body end --}}
    @yield('body_end')
</body>

</html>
