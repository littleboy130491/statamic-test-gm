@php
    $career = \Statamic\Facades\GlobalSet::findByHandle('single_career_information')
        ?->in(\Statamic\Facades\Site::current()->handle())
        ?->toAugmentedArray();
@endphp

<x-layouts.main>

    <x-layouts.header.single-header />

    <main>
        <section id="careers-listing">
            <div class="container my-18 md:my-18 lg:my-20">
                <div class="grid grid--auto gap-6 md:gap-8">
                    @foreach ($entries as $entry)
                        <x-cards.career-card :entry="$entry" :career="$career" />
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <x-layouts.footer.secondary-footer />

</x-layouts.main>
