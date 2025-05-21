<?php

// Unit testing, do not use abspath,

const FAKE_PLUGIN_MAIN = __FILE__;

// Script 'src' path is not important.
return [
    'scripts'            => [
        'items'         => [
            [
                'handle' => 'fake-script-1',
                'src'    => plugins_url('assets/fake-script.js', FAKE_PLUGIN_MAIN),
            ],
            [
                'handle' => 'fake-script-2',
                'src'    => plugins_url('assets/fake-script.js', FAKE_PLUGIN_MAIN),
            ],
        ],
        'enqueue'       => function ($handle) {
            return 'fake-script-1' === $handle;
        },
        'admin_enqueue' => function ($handle, $hook) {
            return 'fake-script-2' === $handle && 'test_hook' === $hook;
        },
    ],
    'styles'             => [
        'items'         => [
            [
                'handle' => 'fake-style-1',
                'src'    => plugins_url('assets/fake-style.css', FAKE_PLUGIN_MAIN),
            ],
            [
                'handle' => 'fake-style-2',
                'src'    => plugins_url('assets/fake-style.css', FAKE_PLUGIN_MAIN),
            ],
            [
                'handle' => 'fake-style-3',
                'src'    => plugins_url('assets/fake-style.css', FAKE_PLUGIN_MAIN),
            ],
        ],
        'enqueue'       => [
            'fake-style-1' => function ($handle) {
                return 'fake-style-1' === $handle;
            },
        ],
        'admin_enqueue' => [
            'fake-style-2,fake-style-3' => function ($handle) {
                return true;
            },
        ],
    ],
    'enqueue_hook'       => 'test_enqueue_scripts',
    'admin_enqueue_hook' => 'test_admin_enqueue_scripts',
];
