<?php

if (!defined('ABSPATH')) {
    exit;
}

$ver = fn() => 'production' === wp_get_environment_type() ? ROSTER_VERSION : time();

return [
    'script' => [
        'items'         => [
            [
                'handle' => 'roster-admin-edit',
                'src'    => plugin_dir_url(ROSTER_MAIN) . 'assets/admin-edit.js',
                'deps'   => ['jquery'],
                'ver'    => $ver(),
                'args'   => ['strategy' => 'defer', 'in_footer' => true],
            ],
        ],
        'admin_enqueue' => [
            'roster-admin-edit' => [
                'post.php' => function (): bool {
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
                'ver'    => $ver(),
            ],
            [
                'handle' => 'roster-admin-edit-list',
                'src'    => plugin_dir_url(ROSTER_MAIN) . 'assets/admin-edit-list.css',
                'ver'    => $ver(),
            ],
        ],
        'admin_enqueue' => [
            'roster-admin-edit'      => [
                'post.php'     => function (): bool {
                    global $post_type;
                    return (
                        ROSTER_CPT_PROFILE === $post_type &&
                        'edit' === ($_GET['action'] ?? '') &&
                        isset($_GET['post'])
                    );
                },
                'post-new.php' => function (): bool {
                    global $post_type;
                    return (
                        ROSTER_CPT_PROFILE === $post_type
                    );
                },
            ],
            'roster-admin-edit-list' => [
                'edit.php' => function (): bool {
                    global $post_type;
                    return (
                        ROSTER_CPT_PROFILE === $post_type
                    );
                },
            ],
        ],
    ],
];
