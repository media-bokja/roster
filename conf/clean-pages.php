<?php

use Bojka\Roster\Supports\FrontPage;

use function Bojka\Roster\Facades\rosterCall;

if (!defined('ABSPATH')) {
    exit;
}

return [
    [
        'name'      => 'roster',
        'condition' => function (): bool { return is_page('roster'); },
        'before'    => function () { rosterCall(FrontPage::class, 'before'); },
        'body'      => function () { rosterCall(FrontPage::class, 'render'); },
    ],
    'show_admin_bar' => false,
];
