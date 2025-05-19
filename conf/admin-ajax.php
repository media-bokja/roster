<?php

use Bokja\Roster\Vendor\Bojaghi\AdminAjax\SubmitBase;

if (!defined('ABSPATH')) {
    exit;
}

return [
    /** @uses Bokja\Roster\Modules\AdminAjax::setTheme() */
    [
        'roster_set_theme',
        'bokja/adminAjax@setTheme',
        SubmitBase::ONLY_PRIV,
        'nonce'
    ],
    'checkContentType' => true,
];
