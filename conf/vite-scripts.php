<?php

if (!defined('ABSPATH')) {
    exit;
}

return [
    'distBaseUrl'  => plugin_dir_url(ROSTER_MAIN) . 'dist',
    'i18n'         => false,
    'isProd'       => 'production' === wp_get_environment_type(),
    'manifestPath' => plugin_dir_path(ROSTER_MAIN) . 'dist/.vite/manifest.json'
];
