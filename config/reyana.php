<?php

return [
    'preview' => env('REYANA_PREVIEW', true),
    'indexable' => env('REYANA_INDEXABLE', false),
    'announcement' => env('REYANA_ANNOUNCEMENT'),
    'contact_email' => env('REYANA_CONTACT_EMAIL'),
    // Commercial checkout remains closed until shipping and verified payments are implemented.
    'checkout_enabled' => false,
];
