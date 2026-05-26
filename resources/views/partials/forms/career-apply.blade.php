@php
    $skipHandles = isset($position) ? ['position'] : [];
@endphp

<section class="rounded-xl border border-zinc-200 bg-zinc-50 p-6 dark:border-zinc-800 dark:bg-zinc-900/50">
    <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Apply for this role</h2>
    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Submit your details and CV. We will review your application and get back to you.</p>

    <s:form:career_apply class="statamic-form mt-6 space-y-5">
        @if ($success)
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-200" role="status">
                {{ $success }}
            </div>
        @else
            @if (count($errors) > 0)
                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-900 dark:bg-red-950/40 dark:text-red-200" role="alert">
                    <p class="font-medium">Please fix the following:</p>
                    <ul class="mt-2 list-inside list-disc space-y-1">
                        @foreach ($errors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @isset($position)
                <input type="hidden" name="position" value="{{ $position }}">
            @endisset

            @include('partials.forms.fields', ['fields' => $fields, 'skipHandles' => $skipHandles])

            <input type="text" name="{{ $honeypot ?? 'website_url' }}" value="" tabindex="-1" autocomplete="off" class="sr-only" aria-hidden="true">

            <button
                type="submit"
                class="inline-flex w-full items-center justify-center rounded-full bg-emerald-500 px-8 py-3 text-sm font-semibold uppercase tracking-wide text-white transition hover:bg-emerald-600 sm:w-auto"
            >
                Submit application
            </button>
        @endif
    </s:form:career_apply>
</section>
