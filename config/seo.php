<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Public identity
    |--------------------------------------------------------------------------
    |
    | These names help search engines connect the portfolio with the handles
    | used by the same person elsewhere on the web.
    |
    */
    'alternate_names' => array_values(array_filter(array_map(
        'trim',
        explode(',', env('SEO_ALTERNATE_NAMES', 'biplobice,biplob.ice')),
    ))),
];
