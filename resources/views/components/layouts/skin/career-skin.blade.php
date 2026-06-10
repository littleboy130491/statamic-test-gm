@props(['entry', 'career' => null])

@php
    $career =
        $career ??
        \Statamic\Facades\GlobalSet::findByHandle('single_career_information')
            ?->in(\Statamic\Facades\Site::current()->handle())
            ?->toAugmentedArray();
@endphp

<div
    class="group hover:bg-[#E8F1E8] flex flex-col gap-6 md:gap-3 lg:gap-8 rounded-2xl lg:rounded-3xl bg-white p-5 md:p-4 lg:p-6">

    <header class="flex flex-col gap-3">

        {{-- Employment & Location --}}
        <div class="flex flex-wrap gap-4 md:gap-6">
            @if ($entry->employment_status)
                <p class="flex items-center gap-2 uppercase text-(--color-primary) font-medium group-hover:text-black">
                    @if (!empty($career['icon_employment_status']))
                        <img src="{{ $career['icon_employment_status'] }}" alt=""
                            class="w-4 h-4 shrink-0 -mt-1 group-hover:brightness-0" />
                    @endif
                    {{ $entry->employment_status->label() }}
                </p>
            @endif

            @if ($entry->locations)
                <p class="flex items-center gap-2 uppercase text-(--color-primary) font-medium group-hover:text-black">
                    @if (!empty($career['icon_location']))
                        <img src="{{ $career['icon_location'] }}" alt=""
                            class="w-4 h-4 shrink-0 -mt-1 group-hover:brightness-0" />
                    @endif
                    @foreach ($entry->locations as $location)
                        {{ $location->title }}
                        @unless ($loop->last)
                            ,
                        @endunless
                    @endforeach
                </p>
            @endif
        </div>

        {{-- Heading --}}
        <h4>
            <a href="{{ $entry->url() }}" class="text-(--color-heading) title-display">{{ $entry->title }}</a>
        </h4>
    </header>

    <div class="flex flex-col gap-4">

        {{-- Excerpt --}}
        @if ($entry->excerpt)
            <p>{{ $entry->excerpt }}</p>
        @endif

        {{-- Tags --}}
        @if ($entry->tags)
            <div class="flex flex-wrap gap-2">
                @foreach ($entry->tags as $tag)
                    <p class="rounded-full bg-(--color-surface) px-3.5 py-2 text-sm">
                        {{ $tag->title }}
                    </p>
                @endforeach
            </div>
        @endif

        {{-- Button Selengkapnya --}}
        <a href="{{ $entry->url() }}"
            class="mt-4 bg-(--color-surface) rounded-full flex justify-between items-center py-2 pl-6 pr-2 group-hover:bg-(--color-primary)">
            <p class="uppercase title-display text-(--color-primary) tracking-widest group-hover:text-white">
                {{ $career['label_card_button'] ?? 'Selengkapnya' }}
            </p>
            <p
                class="flex h-10 w-10 md:h-8 md:w-8 lg:h-10 lg:w-10 shrink-0 items-center justify-center rounded-full bg-(--color-primary) group-hover:bg-white">
                <svg class="h-4 w-4 text-white group-hover:text-(--color-primary)" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </p>
        </a>
    </div>

</div>
