@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
        class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        {{-- Page numbers --}}
        <div class="flex flex-wrap lg:justify-center items-center gap-2">

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <p aria-current="page"
                                class="w-11 h-11 bg-(--color-primary) flex justify-center items-center text-white rounded-full">
                                {{ $page }}</p>
                        @else
                            <a href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
                                class="w-11 h-11 bg-white flex justify-center items-center text-black rounded-full hover:bg-(--color-primary) hover:text-white transition">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

        </div>
    </nav>
@endif
