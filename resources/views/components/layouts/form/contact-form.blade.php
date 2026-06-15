@php
    $contactLabel = \Statamic\Facades\GlobalSet::findByHandle('contact_label_information')?->inCurrentSite()?->data();
@endphp

<statamic:form:contact class="contact-form flex flex-col gap-4">

    {{-- Success --}}
    @if ($success)
        <div class="rounded-xl bg-green-50 px-5 py-4 text-green-800">
            {{ $contactLabel['success_message'] ?? $success }}
        </div>
    @endif

    {{-- Error Summary --}}
    @if (count($errors))
        <div class="rounded-xl bg-red-50 px-5 py-4 text-red-800">
            @if (!empty($contactLabel['message_failed']))
                <p class="mb-2 font-medium">{{ $contactLabel['message_failed'] }}</p>
            @endif
            <ul class="flex flex-col gap-1">
                @foreach ($errors as $error_message)
                    <li>{{ $error_message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Fields --}}
    <div class="flex flex-wrap gap-4">
        @foreach ($fields as $field)
            <div
                class="contact-form-field flex flex-col gap-1 {{ ($field['width'] ?? 100) <= 50 ? 'w-full md:w-[calc(50%-0.5rem)]' : 'w-full' }}">
                @if (($field['type'] ?? 'text') === 'select')
                    <select name="{{ $field['handle'] }}"
                        {{ in_array('required', (array) ($field['validate'] ?? [])) || str_contains($field['validate'] ?? '', 'required') ? 'required' : '' }}
                        class="contact-form-input rounded-xl px-5 py-4 w-full border border-[#CECECE]">
                        <option value="" disabled selected>{{ $field['placeholder'] ?? ($field['display'] ?? '') }}
                        </option>
                        @foreach ($field['options'] ?? [] as $optKey => $optLabel)
                            <option value="{{ $optKey }}">{{ $optLabel }}</option>
                        @endforeach
                    </select>
                @elseif (($field['type'] ?? 'text') === 'textarea')
                    <textarea name="{{ $field['handle'] }}" rows="5"
                        placeholder="{{ $field['placeholder'] ?? ($field['display'] ?? '') }}"
                        class="contact-form-input rounded-xl px-5 py-4 w-full border border-[#CECECE] lg:h-73"></textarea>
                @else
                    <input type="{{ $field['input_type'] ?? 'text' }}" name="{{ $field['handle'] }}"
                        placeholder="{{ $field['placeholder'] ?? ($field['display'] ?? '') }}"
                        class="contact-form-input rounded-xl px-5 py-4 w-full border border-[#CECECE]" />
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
            {{ $contactLabel['submit_button_label'] ?? 'Kirim' }}
        </button>
    </div>

</statamic:form:contact>
