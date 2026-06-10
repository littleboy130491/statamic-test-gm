@props(['entry', 'career' => null])

@php
    $career =
        $career ??
        \Statamic\Facades\GlobalSet::findByHandle('single_career_information')
            ?->in(\Statamic\Facades\Site::current()->handle())
            ?->toAugmentedArray();
@endphp

<article class="career-card flex flex-col gap-4 rounded-3xl bg-white p-6">

    {{-- Employment & Location --}}
    <div class="flex flex-wrap gap-4 md:gap-6">

        {{-- Employment --}}
        @if ($entry->employment_status)
            <p class="flex items-center gap-2 uppercase font-semibold text-(--color-primary)">
                @if (!empty($career['icon_employment_status']))
                    <img src="{{ $career['icon_employment_status'] }}" alt="" class="w-5 h-5 shrink-0" />
                @endif
                {{ $entry->employment_status->label() }}
            </p>
        @endif

        {{-- Location --}}
        @if ($entry->locations)
            <p class="flex items-center gap-2 uppercase font-semibold text-(--color-primary)">
                @if (!empty($career['icon_location']))
                    <img src="{{ $career['icon_location'] }}" alt="" class="w-5 h-5 shrink-0" />
                @endif
                @foreach ($entry->locations as $location)
                    {{ $location->title }}@unless ($loop->last)
                    ,
                @endunless
            @endforeach
        </p>
    @endif
</div>

{{-- Title --}}
<h3 class="career-card__title">
    <a href="{{ $entry->url() }}">{{ $entry->title }}</a>
</h3>

{{-- Short Description --}}
@if ($entry->short_description)
    <p class="career-card__excerpt">{{ $entry->short_description }}</p>
@endif

{{-- Tags --}}
@if ($entry->tags)
    <div class="flex flex-wrap gap-2 md:gap-3">
        @foreach ($entry->tags as $tag)
            <span class="career-card__tag rounded-full bg-(--color-bg-grey) px-4 py-2">
                {{ $tag->title }}
            </span>
        @endforeach
    </div>
@endif

{{-- Button Selengkapnya --}}
<a href="{{ $entry->url() }}"
    class="career-card__button mt-2 flex items-center justify-between gap-4 rounded-full bg-(--color-bg-grey) py-3 pl-6 pr-3">
    <span class="uppercase font-semibold text-(--color-primary)">
        {{ $career['label_card_button'] ?? 'Selengkapnya' }}
    </span>
    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-(--color-primary)">
        <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
    </span>
</a>

</article>
