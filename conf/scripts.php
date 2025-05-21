<?php

if (!defined('ABSPATH')) {
    exit;
}

$ver = fn() => 'production' === wp_get_environment_type() ? ROSTER_VERSION : time();

return [
    'scripts' => [
        'items'         => [
            [
                'handle' => 'roster-admin-edit',
                'src'    => plugin_dir_url(ROSTER_MAIN) . 'assets/admin-edit.js',
                'deps'   => ['jquery'],
                'ver'    => $ver(),
                'args'   => ['strategy' => 'defer', 'in_footer' => true],
            ],
            [
                'handle' => 'roster-livereload',
                'src'    => 'http://localhost:35729/livereload.js?sipver=1',
                'ver'    => null,
                'args'   => ['in_footer' => true],
            ],
        ],
        'admin_enqueue' => [
            'roster-admin-edit' => function (string $handle, string $hook): bool {
                global $post_type;
                return ROSTER_CPT_PROFILE === $post_type &&
                    ('post.php' === $hook || 'post-new.php' === $hook);
            },
            'roster-livereload' => function ($handle, $hook): bool {
                global $post_type;
                return (
                    ROSTER_CPT_PROFILE === $post_type &&
                    ('post.php' === $hook || 'post-new.php' === $hook) &&
                    'production' !== wp_get_environment_type()
                );
            },
        ],
    ],
    'styles'  => [
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
            'roster-admin-edit'      => function (string $handle, string $hook) {
                global $post_type;

                $isEdit = (
                    'post.php' === $hook &&
                    ROSTER_CPT_PROFILE === $post_type &&
                    'edit' === ($_GET['action'] ?? '') &&
                    isset($_GET['post'])
                );

                $isNew = (
                    'post-new.php' === $hook &&
                    ROSTER_CPT_PROFILE === $post_type
                );

                return $isEdit || $isNew;
            },
            'roster-admin-edit-list' => function (string $handle, string $hook) {
                global $post_type;
                return (
                    'edit.php' === $hook &&
                    ROSTER_CPT_PROFILE === $post_type
                );
            },
        ],
    ],
];
