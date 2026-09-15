@if (filled(config('tracking.google_tag_manager_id')))
    <noscript>
        <iframe
            src="https://www.googletagmanager.com/ns.html?id={{ config('tracking.google_tag_manager_id') }}"
            height="0"
            width="0"
            style="display:none;visibility:hidden"
            title="Google Tag Manager"
        ></iframe>
    </noscript>
@endif
