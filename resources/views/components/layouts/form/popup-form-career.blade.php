@php
    $form = \Statamic\Facades\GlobalSet::findByHandle('career_label_information')?->inCurrentSite()?->data();

    $str = fn($val, $default = '') => is_array($val) || is_null($val) ? $default : (string) $val;
    $oldVal = fn($handle) => is_array($old[$handle] ?? null) ? '' : $old[$handle] ?? '';
@endphp

<dialog id="career-popup" class="career-popup"
    data-auto-open="{{ $errors->any() || session()->has('success') ? 'true' : 'false' }}">
    <div class="career-popup-inner p-5 md:p-8 lg:p-10">

        {{-- Tombol close --}}
        <button type="button"
            class="absolute cursor-pointer border-0 z-10 text-(--color-primary) tracking-tighter text-4xl right-4 top-2 md:text-5xl md:right-8 md:top-5 lg:text-6xl lg:right-8 lg:top-5"
            onclick="document.getElementById('career-popup').close()" aria-label="Tutup">
            &times;
        </button>

        <statamic:form:career_apply :files="true" class="career-form flex flex-col gap-6 md:gap-8 lg:gap-8">

            {{-- Heading & Description --}}
            @if (!empty($form['form_heading']) || !empty($form['form_description']))
                <div class="flow">
                    @if (!empty($form['form_heading']))
                        <h2>{{ $str($form['form_heading']) }}</h2>
                    @endif
                    @if (!empty($form['form_description']))
                        <p class="w-full md:w-[90%] lg:w-[75%]">{{ $str($form['form_description']) }}</p>
                    @endif
                </div>
            @endif

            {{-- Fields --}}
            <div class="flex flex-wrap gap-4">
                @foreach ($fields as $field)
                    <div
                        class="career-form-field flex flex-col gap-1 {{ ($field['width'] ?? 100) <= 50 ? 'w-full md:w-[calc(50%-0.5rem)]' : 'w-full' }}">

                        @if (in_array($field['type'] ?? 'text', ['assets', 'files'], true))
                            @unless ($field['hide_display'] ?? false)
                                <label class="font-medium">{{ $str($field['display'] ?? '') }}</label>
                            @endunless
                            <label class="career-form-file flex items-center gap-3 cursor-pointer">
                                <p class="career-form-file-button shrink-0">
                                    {{ $str($form['label_input_file'] ?? null, 'Choose File') }}</p>
                                <p class="career-form-file-name font-medium border border-[#A1A1A1] bg-[#F1F1F1] px-4 py-2 text-sm text-black hover:bg-gray-100"
                                    data-placeholder="{{ $str($form['label_button_input_file'] ?? null, 'No File Choosen') }}">
                                    {{ $str($form['label_button_input_file'] ?? null, 'No File Choosen') }}</p>
                                <input type="file" name="{{ $field['handle'] }}" accept=".pdf,.doc,.docx"
                                    class="hidden"
                                    onchange="this.parentElement.querySelector('.career-form-file-name').textContent = this.files.length ? this.files[0].name : this.parentElement.querySelector('.career-form-file-name').dataset.placeholder" />
                            </label>
                            @if (!empty($field['instructions']))
                                <p class="text-sm text-(--color-text)">{{ $str($field['instructions']) }}</p>
                            @endif
                        @elseif (($field['type'] ?? 'text') === 'toggle')
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="{{ $field['handle'] }}" value="1"
                                    {{ $old[$field['handle']] ?? false ? 'checked' : '' }} class="mt-1 shrink-0" />
                                <p class="text-(--color-text)">
                                    {{ $str($field['inline_label'] ?? ($field['display'] ?? '')) }}</p>
                            </label>
                        @elseif (($field['type'] ?? 'text') === 'textarea')
                            <textarea name="{{ $field['handle'] }}" rows="4" placeholder="{{ $str($field['display'] ?? '') }}"
                                class="career-form-input rounded-xl= bg-white px-5 py-4 w-full">{{ $oldVal($field['handle']) }}</textarea>
                        @else
                            <input type="{{ $field['input_type'] ?? 'text' }}" name="{{ $field['handle'] }}"
                                value="{{ $oldVal($field['handle']) }}"
                                placeholder="{{ $str($form['placeholder_' . $field['handle']] ?? ($field['display'] ?? '')) }}"
                                class="career-form-input rounded-lg bg-white px-5 py-4 w-full font-(family-name:--font-body)" />
                        @endif

                        @if (!empty($field['error']))
                            <p class="text-sm text-red-600">{{ $str($field['error']) }}</p>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Submit --}}
            <div>
                <button type="submit" class="button button--primary">
                    {{ $str($form['button_submit_label'] ?? null, 'Kirim') }}
                </button>
            </div>

            {{-- Success --}}
            @if ($success)
                <div
                    class="rounded-xl bg-green-50 px-5 py-4 text-(--color-primary)/50 border border-(--color-primary)/30">
                    {{ $str($form['success_message'] ?? null, $success) }}
                </div>
            @endif

            {{-- Error --}}
            @if (count($errors))
                <div class="rounded-xl bg-red-50 px-5 py-4 text-red-800 border border-red-800/30">
                    @if (!empty($form['message_failed']))
                        <p class="mb-2 font-medium">{{ $str($form['message_failed']) }}</p>
                    @endif
                    <ul class="flex flex-col gap-1">
                        @foreach ($errors as $error_message)
                            <li>{{ $str($error_message) }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </statamic:form:career_apply>

    </div>
</dialog>
