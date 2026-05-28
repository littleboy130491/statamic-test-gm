@php
    $isCenter = ($block->alignment ?? 'center') === 'center';
    $isDark = ($block->background ?? 'default') === 'dark';
    $sectionBg = match ($block->background ?? 'default') {
        'muted' => 'bg-zinc-50 dark:bg-zinc-900',
        'dark' => 'bg-zinc-900 text-zinc-100',
        default => 'bg-white dark:bg-zinc-950',
    };
@endphp

<section
    @if ($block->anchor) id="{{ $block->anchor }}" @endif
    class="px-4 py-16 sm:px-6 lg:py-24 {{ $sectionBg }} {{ $isCenter ? 'text-center' : 'text-left' }}"
>
    <div class="mx-auto max-w-6xl">
        @if ($block->image)
            <div class="mb-8 flex {{ $isCenter ? 'justify-center' : '' }}">
                @foreach ($block->image as $image)
                    <img
                        src="{{ $image->url }}"
                        alt="{{ $block->headline }}"
                        class="max-h-64 w-auto rounded-xl object-contain"
                    >
                @endforeach
            </div>
        @endif

        @if ($block->headline)
            <h2 class="text-3xl font-bold tracking-tight sm:text-4xl lg:text-5xl {{ $isDark ? 'text-white' : 'text-zinc-900 dark:text-zinc-100' }}">
                {{ $block->headline }}
            </h2>
        @endif

        @if ($block->subheadline)
            <p class="mt-3 text-lg font-medium text-emerald-600 dark:text-emerald-400">
                {{ $block->subheadline }}
            </p>
        @endif

        @if ($block->text)
            <p class="mx-auto mt-4 max-w-2xl text-lg text-zinc-600 dark:text-zinc-400 {{ $isCenter ? '' : 'mx-0' }}">
                {{ $block->text }}
            </p>
        @endif

        @if ($block->buttons)
            <div class="mt-8 flex flex-wrap gap-3 {{ $isCenter ? 'justify-center' : '' }}">
                @foreach ($block->buttons as $button)
                    @if ($button->label && $button->link)
                        <x-block-button
                            :label="$button->label"
                            :link="$button->link"
                            :style="$button->style ?? 'primary'"
                        />
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</section>
