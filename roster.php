<?php
/**
 * Plugin Name: 복자수도회 명부
 * Plugin URI: https://github.com/media-bokja/roster
 * Description: 수도회 명부 관리를 맡은 워드프레스 플러그인입니다.
 * Author: changwoo
 * Author URI: ep6tri@hotmail.com
 * Requires at least: 6.8
 * Requires PHP: 8.2
 * Version: 0.4.0
 * License: GPLv2 or later
 */

use function Bojka\Roster\Facades\roster;

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

const ROSTER_MAIN    = __FILE__;
const ROSTER_VERSION = '0.4.0';

roster();
