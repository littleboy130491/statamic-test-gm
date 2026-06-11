@php
    $form = \Statamic\Facades\GlobalSet::findByHandle('career_label_information')?->inCurrentSite()?->data();
@endphp

<statamic:form:career_apply :files="true" class="career-form flex flex-col gap-4">

    {{-- Success --}}
    @if ($success)
        <div class="rounded-xl bg-green-50 px-5 py-4 text-green-800">
            {{ $form['success_message'] ?? $success }}
        </div>
    @endif

    {{-- Error Summary --}}
    @if (count($errors))
        <div class="rounded-xl bg-red-50 px-5 py-4 text-red-800">
            @if (!empty($form['message_failed']))
                <p class="mb-2 font-medium">{{ $form['message_failed'] }}</p>
            @endif
            <ul class="flex flex-col gap-1">
                @foreach ($errors as $error_message)
                    <li>{{ $error_message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Fields (auto-loop, input manual per tipe, lebar dari width blueprint) --}}
    <div class="flex flex-wrap gap-4">
        @foreach ($fields as $field)
            <div
                class="career-form__field flex flex-col gap-1 {{ ($field['width'] ?? 100) <= 50 ? 'w-full md:w-[calc(50%-0.5rem)]' : 'w-full' }}">

                @if (($field['type'] ?? 'text') === 'assets')
                    <label class="font-medium">{{ $field['display'] ?? '' }}</label>
                    <input type="file" name="{{ $field['handle'] }}" accept=".pdf,.doc,.docx"
                        class="career-form__file" />
                    @if (!empty($field['instructions']))
                        <p class="text-sm text-(--color-text)">{{ $field['instructions'] }}</p>
                    @endif
                @elseif (($field['type'] ?? 'text') === 'toggle')
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="{{ $field['handle'] }}" value="1"
                            {{ $old[$field['handle']] ?? false ? 'checked' : '' }} class="mt-1 shrink-0" />
                        <span
                            class="text-(--color-text)">{{ $field['inline_label'] ?? ($field['display'] ?? '') }}</span>
                    </label>
                @elseif (($field['type'] ?? 'text') === 'textarea')
                    <textarea name="{{ $field['handle'] }}" rows="4" placeholder="{{ $field['display'] ?? '' }}"
                        class="career-form__input rounded-xl bg-white px-5 py-4 w-full">{{ $old[$field['handle']] ?? '' }}</textarea>
                @else
                    <input type="{{ $field['input_type'] ?? 'text' }}" name="{{ $field['handle'] }}"
                        value="{{ $old[$field['handle']] ?? '' }}"
                        placeholder="{{ $form['placeholder_' . $field['handle']] ?? ($field['display'] ?? '') }}"
                        class="career-form__input rounded-xl bg-white px-5 py-4 w-full" />
                @endif

                @if (!empty($field['error']))
                    <p class="text-sm text-red-600">{{ $field['error'] }}</p>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Submit --}}
    <div>
        <button type="submit" class="button button--primary">
            {{ $form['button_submit_label'] ?? 'Kirim' }}
        </button>
    </div>

</statamic:form:career_apply>
