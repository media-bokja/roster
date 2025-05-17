<?php

use Bokja\Roster\Vendor\Bojaghi\AdminAjax\SubmitBase;

if (!defined('ABSPATH')) {
    exit;
}

return [
    /** @uses Bojka\Roster\Modules\AdminPost::exportProfiles */
    [
        'roster_export_profiles',
        'bokja/adminPost@exportProfiles',
        SubmitBase::ONLY_PRIV,
        'nonce'
    ],
    'checkContentType' => false,
];
