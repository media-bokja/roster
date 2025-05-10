<?php

use function Bokja\Roster\prefixed;

if (!defined('ABSPATH')) {
    exit;
}

const ROSTER_OPTIONS_GROUP = 'roster_options_group';

return [
    prefixed('page')  => [
        'group'             => ROSTER_OPTIONS_GROUP,
        'type'              => 'integer',
        'label'             => '페이지',
        'description'       => '명부 페이지에 프론트 페이지를 설정합니다. 템플릿으로도 가능하나, 이렇게 하는 것이 더 알기 쉽습니다.',
        'sanitize_callback' => 'absint',
        'show_in_rest'      => false,
        'autoload'          => false,
        'default'           => 0,
        'get_filter'        => fn($x) => absint($x),
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
