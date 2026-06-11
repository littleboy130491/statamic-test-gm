<statamic:form:career_apply :files="true" class="career-form flex flex-col gap-4" x-data="{ fileName: '' }">

    {{-- Success Message --}}
    @if ($success)
        <div class="rounded-xl bg-green-50 px-5 py-4 text-green-800">
            {{ $success }}
        </div>
    @endif

    {{-- Error Summary --}}
    @if (count($errors))
        <div class="rounded-xl bg-red-50 px-5 py-4 text-red-800">
            <ul class="flex flex-col gap-1">
                @foreach ($errors as $error_message)
                    <li>{{ $error_message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Row: Name & Position --}}
    <div class="flex flex-col md:flex-row gap-4">

        {{-- Name --}}
        <div class="flex flex-col gap-1 w-full">
            <input type="text" name="name" value="{{ $old['name'] ?? '' }}" placeholder="Nama Lengkap"
                class="career-form__input rounded-xl bg-white px-5 py-4 w-full" />
            @if ($error['name'] ?? false)
                <p class="text-sm text-red-600">{{ $error['name'] }}</p>
            @endif
        </div>

        {{-- Position --}}
        <div class="flex flex-col gap-1 w-full">
            <input type="text" name="position" value="{{ $old['position'] ?? '' }}"
                placeholder="Posisi yang Diminati" class="career-form__input rounded-xl bg-white px-5 py-4 w-full" />
            @if ($error['position'] ?? false)
                <p class="text-sm text-red-600">{{ $error['position'] }}</p>
            @endif
        </div>
    </div>

    {{-- Row: Email & Phone --}}
    <div class="flex flex-col md:flex-row gap-4">

        {{-- Email --}}
        <div class="flex flex-col gap-1 w-full">
            <input type="email" name="email" value="{{ $old['email'] ?? '' }}" placeholder="Email"
                class="career-form__input rounded-xl bg-white px-5 py-4 w-full" />
            @if ($error['email'] ?? false)
                <p class="text-sm text-red-600">{{ $error['email'] }}</p>
            @endif
        </div>

        {{-- Phone --}}
        <div class="flex flex-col gap-1 w-full">
            <input type="tel" name="phone" value="{{ $old['phone'] ?? '' }}" placeholder="Nomor Telepon"
                class="career-form__input rounded-xl bg-white px-5 py-4 w-full" />
            @if ($error['phone'] ?? false)
                <p class="text-sm text-red-600">{{ $error['phone'] }}</p>
            @endif
        </div>
    </div>

    {{-- CV / Resume Upload --}}
    <div class="flex flex-col gap-1">
        <label class="career-form__file flex items-center gap-3 cursor-pointer">
            <span
                class="rounded-full bg-(--color-primary) px-5 py-2 text-white uppercase title-display tracking-widest shrink-0">
                Pilih File
            </span>
            <span class="text-(--color-text)" x-text="fileName || 'PDF, DOC, atau DOCX. Maks 5 MB.'"></span>
            <input type="file" name="cv" accept=".pdf,.doc,.docx" class="hidden"
                @change="fileName = $event.target.files.length ? $event.target.files[0].name : ''" />
        </label>
        @if ($error['cv'] ?? false)
            <p class="text-sm text-red-600">{{ $error['cv'] }}</p>
        @endif
    </div>

    {{-- Document Consent --}}
    <div class="flex flex-col gap-1">
        <label class="flex items-start gap-3 cursor-pointer">
            <input type="checkbox" name="accept_docs" value="1"
                {{ $old['accept_docs'] ?? false ? 'checked' : '' }} class="mt-1 shrink-0" />
            <span class="text-(--color-text)">
                Saya menyetujui untuk mengirimkan CV dan dokumen terkait untuk lamaran ini.
            </span>
        </label>
        @if ($error['accept_docs'] ?? false)
            <p class="text-sm text-red-600">{{ $error['accept_docs'] }}</p>
        @endif
    </div>

    {{-- Submit --}}
    <div>
        <button type="submit" class="button button--primary">
            Kirim
        </button>
    </div>

</statamic:form:career_apply>
