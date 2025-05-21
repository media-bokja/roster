<?php
/**
 * Plugin Name: 한국순교복자성직수도회 회원명부
 * Plugin URI: https://github.com/media-bokja/roster
 * Description: 수도회 명부 목록 관리를 맡은 워드프레스 플러그인입니다.
 * Author: changwoo
 * Author URI: ep6tri@hotmail.com
 * Requires at least: 6.8
 * Requires PHP: 8.2
 * Version: 1.0.1
 * License: GPLv2 or later
 */

use function Bokja\Roster\Facades\roster;

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

const ROSTER_MAIN    = __FILE__;
const ROSTER_VERSION = '1.0.1';

roster();
