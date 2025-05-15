<?php

use function Bokja\Roster\prefixed;

if (!defined('ABSPATH')) {
    exit;
}

const ROSTER_OPTIONS_GROUP = 'roster_options_group';

// Delete old option.
if (false !== get_option(prefixed('page'))) {
    delete_option(prefixed('page'));
}

return [
    prefixed('pages') => [
        'group'             => ROSTER_OPTIONS_GROUP,
        'type'              => 'array',
        'label'             => '페이지',
        'description'       => '회원 명부 페이지에 필요한 페이지를 설정합니다.',
        'sanitize_callback' => function (mixed $input): array {
            return [
                'front' => absint($input['front'] ?? '0'),
                'login' => absint($input['login'] ?? '0'),
            ];
        },
        'show_in_rest'      => false,
        'autoload'          => false,
        'default'           => [
            'front' => 0,
            'login' => 0,
        ],
        'get_filter'        => null,
    ],
    prefixed('roles') => [
        'group'             => ROSTER_OPTIONS_GROUP,
        'type'              => 'array',
        'label'             => '역할',
        'description'       => '명부 페이지에 접근 가능한 역할을 설정합니다. 관리자는 기본적으로 가능합니다.',
        'sanitize_callback' => function ($x) {
            $value = array_unique(array_filter(array_map('sanitize_text_field', (array)$x)));
            if (!in_array('administrator', $value)) {
                $value = ['administrator', ...$value];
            }
            return $value;
        },
        'show_in_rest'      => false,
        'autoload'          => false,
        'default'           => ['administrator'],
        'get_filter'        => null,
    ],
];
