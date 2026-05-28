@foreach ($page->sections as $section)
    @includeFirst([
        'blocks.' . $section->type,
        'blocks._missing',
    ], ['block' => $section])
@endforeach
