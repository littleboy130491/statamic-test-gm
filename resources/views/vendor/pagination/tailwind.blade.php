@php
    // Jendela halaman sendiri (bawaan Laravel minimal ~7 angka)
    $current = $paginator->currentPage();
    $last = $paginator->lastPage();
    $side = $onEachSide ?? 1;

    // Geser jendela di ujung > jumlah angka tetap sama
    $span = $side * 2 + 1;
    $start = min(max(1, $current - $side), max(1, $last - $span + 1));
    $end = max(min($last, $current + $side), min($last, $span));

    $pages = collect([1, $last])
        ->merge(range($start, $end))
        ->unique()
        ->sort()
        ->values();

    // Penanda "..." di setiap lompatan halaman
    $items = [];
    $prev = 0;
    foreach ($pages as $page) {
        if ($prev && $page - $prev > 1) {
            $items[] = ['type' => 'gap'];
        }
        $items[] = ['type' => 'page', 'page' => $page];
        $prev = $page;
    }
@endphp

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
        class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        {{-- Page numbers --}}
        <div class="flex flex-wrap lg:justify-center items-center gap-2">

            @foreach ($items as $item)
                @if ($item['type'] === 'gap')
                    <span aria-hidden="true"
                        class="w-11 h-11 flex justify-center items-center text-(--color-primary)">...</span>
                @elseif ($item['page'] == $current)
                    <p aria-current="page"
                        class="w-11 h-11 bg-(--color-primary) flex justify-center items-center text-white rounded-full">
                        {{ $item['page'] }}</p>
                @else
                    <a href="{{ $paginator->url($item['page']) }}"
                        aria-label="{{ __('Go to page :page', ['page' => $item['page']]) }}"
                        class="w-11 h-11 bg-white flex justify-center items-center text-(--color-primary) rounded-full hover:bg-(--color-primary) hover:text-white transition">{{ $item['page'] }}</a>
                @endif
            @endforeach

        </div>
    </nav>
@endif
