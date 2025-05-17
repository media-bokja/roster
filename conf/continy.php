<?php

use Bojka\Roster\Modules;
use Bokja\Roster\Vendor\Bojaghi;
use Bokja\Roster\Vendor\Bojaghi\Continy\Continy;

use function Bojka\Roster\Facades\roster;

if (!defined('ABSPATH')) {
    exit;
}

return [
    'main_file' => ROSTER_MAIN,
    'version'   => ROSTER_VERSION,
    'hooks'     => [
        'admin_init'    => 0,
        'init'          => 0,
        'rest_api_init' => 0,
    ],
    'bindings'  => [
        // Bojaghi side
        'bojaghi/adminAjax'   => Bojaghi\AdminAjax\AdminAjax::class,
        'bojaghi/adminPost'   => Bojaghi\AdminAjax\AdminPost::class,
        'bojaghi/cleanPages'  => Bojaghi\CleanPages\CleanPages::class,
        'bojaghi/customPosts' => Bojaghi\CustomPosts\CustomPosts::class,
        'bojaghi/template'    => Bojaghi\Template\Template::class,
        'bojaghi/viteScripts' => Bojaghi\ViteScripts\ViteScript::class,
        // Plugin side
        'bokja/adminAjax'     => Modules\AdminAjax::class,
        'bokja/adminPost'     => Modules\AdminPost::class,
        'bokja/adminEdit'     => Modules\AdminEdit::class,
        'bokja/adminMenu'     => Modules\AdminMenu::class,
        'bokja/options'       => Modules\Options::class,
        'bokja/postMeta'      => Modules\PostMeta::class,
        'bokja/rosterApi'     => Modules\RosterApi::class,
        'bokja/scripts'       => Modules\Scripts::class,
        'bokja/userMeta'      => Modules\UserMeta::class,
    ],
    'arguments' => [
        // Bojaghi side
        'bojaghi/adminAjax'   => fn() => [__DIR__ . '/admin-ajax.php', roster()],
        'bojaghi/adminPost'   => fn() => [__DIR__ . '/admin-post.php', roster()],
        'bojaghi/cleanPages'  => __DIR__ . '/clean-pages.php',
        'bojaghi/customPosts' => __DIR__ . '/custom-posts.php',
        'bojaghi/template'    => __DIR__ . '/template.php',
        'bojaghi/viteScripts' => __DIR__ . '/vite-scripts.php',
        // Plugin side
        'bokja/options'       => __DIR__ . '/options.php',
        'bokja/postMeta'      => __DIR__ . '/post-meta.php',
        'bokja/scripts'       => __DIR__ . '/scripts.php',
        'bokja/userMeta'      => __DIR__ . '/user-meta.php',
    ],
    'modules'   => [
        '_'             => [
            'bojaghi/cleanPages',
        ],
        'init'          => [
            Continy::PR_DEFAULT => [
                // Bojaghi side
                'bojaghi/adminAjax',
                'bojaghi/adminPost',
                'bojaghi/customPosts',
                // Plugin side
                'bokja/adminMenu',
                'bokja/options',
                'bokja/postMeta',
                'bokja/scripts',
            ],
        ],
        'admin_init'    => [
            Continy::PR_DEFAULT => [
                // Plugin side
                'bokja/adminEdit',
            ],
        ],
        'rest_api_init' => [
            Continy::PR_DEFAULT => [
                'bokja/rosterApi',
            ]
        ]
    ]
];
