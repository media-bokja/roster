<?php

use Bojka\Roster\Supports\FrontPage;

use function Bojka\Roster\Facades\rosterCall;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * @uses FrontPage::checkCondition
 * @uses FrontPage::before
 * @uses FrontPage::render
 */
return [
    [
        'name'      => 'roster',
        'condition' => fn() => rosterCall(FrontPage::class, 'checkCondition'),
        'before'    => function () { rosterCall(FrontPage::class, 'before'); },
        'body'      => function () { rosterCall(FrontPage::class, 'render'); },
    ],
    'show_admin_bar' => false,
];
