<?php

use Bojka\Roster\Modules;
use Bokja\Roster\Vendor\Bojaghi;
use Bokja\Roster\Vendor\Bojaghi\Continy\Continy;

if (!defined('ABSPATH')) {
    exit;
}

return [
    'main_file' => ROSTER_MAIN,
    'version'   => ROSTER_VERSION,
    'hooks'     => [
        'admin_init' => 0,
        'init'       => 0,
    ],
    'bindings'  => [
        // Bojaghi side
        'bojaghi/cleanPages'  => Bojaghi\CleanPages\CleanPages::class,
        'bojaghi/customPosts' => Bojaghi\CustomPosts\CustomPosts::class,
        'bojaghi/template'    => Bojaghi\Template\Template::class,
        'bojaghi/viteScripts' => Bojaghi\ViteScripts\ViteScript::class,
        // Plugin side
        'bokja/adminEdit'     => Modules\AdminEdit::class,
        'bokja/customFields'  => Modules\CustomFields::class,
        'bokja/options'       => Modules\Options::class,
    ],
    'arguments' => [
        // Bojaghi side
        'bojaghi/cleanPages'  => __DIR__ . '/clean-pages.php',
        'bojaghi/customPosts' => __DIR__ . '/custom-posts.php',
        'bojaghi/template'    => __DIR__ . '/template.php',
        'bojaghi/viteScripts' => __DIR__ . '/vite-scripts.php',
        // Plugin side
        'bokja/customFields'  => __DIR__ . '/custom-fields.php',
        'bokja/options'       => __DIR__ . '/options.php',
    ],
    'modules'   => [
        '_'          => [
            'bojaghi/cleanPages',
        ],
        'init'       => [
            Continy::PR_DEFAULT => [
                // Bojaghi side
                'bojaghi/customPosts',
                // Plugin side
                'bokja/customFields',
                'bokja/options',
            ],
        ],
        'admin_init' => [
            Continy::PR_DEFAULT => [
                // Plugin side
                'bokja/adminEdit',
            ],
        ],
    ]
];
