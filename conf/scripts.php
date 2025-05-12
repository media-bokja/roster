<?php

if (!defined('ABSPATH')) {
    exit;
}

$ver = fn() => 'production' === wp_get_environment_type() ? ROSTER_VERSION : time();

return [
    'script' => [
        'items' => [
            [
                'handle' => 'roster-admin-edit',
                'src'    => plugin_dir_url(ROSTER_MAIN) . 'assets/admin-edit.js',
                'deps'   => ['jquery'],
                'ver'    => $ver(),
                'args'   => ['strategy' => 'defer', 'in_footer' => true],
            ],
        ],
        'admin_enqueue' => [
            'post.php' => [
                'roster-admin-edit' => function (): bool {
                    global $post_type;
                    return ROSTER_CPT_PROFILE === $post_type;
                }
            ],
        ],
    ],
    'style'  => [
        'items'         => [
            [
                'handle' => 'roster-admin-edit',
                'src'    => plugin_dir_url(ROSTER_MAIN) . 'assets/admin-edit.css',
                'deps'   => [],
                'ver'    => $ver(),
                'media'  => 'all',
            ],
        ],
        'admin_enqueue' => [
            'post.php' => [
                'roster-admin-edit' => function (): bool {
                    global $post_type;
                    return ROSTER_CPT_PROFILE === $post_type;
                }
            ],
        ],
    ],
];
