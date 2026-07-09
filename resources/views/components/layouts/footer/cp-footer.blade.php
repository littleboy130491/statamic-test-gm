@php
    $globals = \Statamic\Facades\GlobalSet::findByHandle('settings')?->inCurrentSite()?->data();
    $company_name = $globals['site_title'] ?? '';
@endphp

<footer id="copyright-footer">
    <div class="container pt-8 pb-6">
        <p class="text-(--color-text) text-center md:text-center lg:text-right">© {{ date('Y') }} {{ $company_name }}
        </p>
    </div>
</footer>
