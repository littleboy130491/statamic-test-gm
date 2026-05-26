@foreach ($fields as $field)
    @if (! empty($skipHandles) && in_array($field['handle'], $skipHandles, true))
        @continue
    @endif

    <div class="space-y-1.5">
        <label for="{{ $field['id'] }}" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
            {{ $field['display'] }}
            @if (collect($field['validate'] ?? [])->contains('required'))
                <span class="text-emerald-600" aria-hidden="true">*</span>
            @endif
        </label>

        <div>{!! $field['field'] !!}</div>

        @if ($field['instructions'] ?? false)
            <p id="{{ $field['id'] }}-instructions" class="text-xs text-zinc-500 dark:text-zinc-400">
                {{ $field['instructions'] }}
            </p>
        @endif

        @if ($field['error'] ?? false)
            <p id="{{ $field['id'] }}-error" class="text-sm text-red-600 dark:text-red-400" role="alert">
                {{ $field['error'] }}
            </p>
        @endif
    </div>
@endforeach
