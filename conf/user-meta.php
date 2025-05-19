<?php

use Bokja\Roster\Objects\Profile;
use Bokja\Roster\Supports\ImageSupport;

use function Bokja\Roster\prefixed;

if (!defined('ABSPATH')) {
    exit;
}

return [
    'user' => [
        prefixed('theme') => [
            'type'              => 'string',
            'description'       => '사용자가 이용 중인 테마. light, dark 중 하나.',
            'single'            => true,
            'default'           => 'light',
            'sanitize_callback' => 'sanitize_key',
            'auth_callback'     => null,
            'show_in_rest'      => false,
            'revisions_enabled' => false,
            'get_filter'        => null,
        ],
    ],
];
