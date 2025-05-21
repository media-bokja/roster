<?php

namespace Bojaghi\Scripts\Tests;

use WP_UnitTestCase;
use Bojaghi\Scripts\Script;

class TestScripts extends WP_UnitTestCase
{
    public function test_script(): void
    {
        add_action('init', function () use (&$script) {
            $script = new Script(__DIR__ . '/fixtures/conf-set-1.php');
        });

        do_action('init');

        // Check if scripts are registered
        $this->assertTrue(wp_script_is('fake-script-1', 'registered'));
        $this->assertTrue(wp_script_is('fake-script-2', 'registered'));
        $this->assertTrue(wp_style_is('fake-style-1', 'registered'));
        $this->assertTrue(wp_style_is('fake-style-2', 'registered'));
        $this->assertTrue(wp_style_is('fake-style-3', 'registered'));

        // Check enqueue_scripts action response.
        $this->assertFalse(wp_script_is('fake-script-1', 'enqueued'));
        $this->assertFalse(wp_script_is('fake-script-2', 'enqueued'));
        $this->assertFalse(wp_script_is('fake-style-1', 'enqueued'));
        $this->assertFalse(wp_script_is('fake-style-2', 'enqueued'));
        $this->assertFalse(wp_script_is('fake-style-3', 'enqueued'));

        do_action('test_enqueue_scripts');

        // fake-script-1 is enqueued
        // fake-script-2 is not enqueued
        $this->assertTrue(wp_script_is('fake-script-1', 'enqueued'));
        $this->assertFalse(wp_script_is('fake-script-2', 'enqueued'));

        // fake-style-1 is enqueued
        // fake-style-2 is not enqueued
        // fake-style-3 is not enqueued
        $this->assertTrue(wp_style_is('fake-style-1', 'enqueued'));
        $this->assertFalse(wp_style_is('fake-style-2', 'enqueued'));
        $this->assertFalse(wp_style_is('fake-style-3', 'enqueued'));

        // Check admin_enqueue_scripts action response.
        do_action('test_admin_enqueue_scripts', 'test_hook');

        // fake-script-2 is enqueued
        $this->assertTrue(wp_script_is('fake-script-2', 'enqueued'));

        // fake-style-2 is enqueued
        // fake-style-3 is enqueued
        $this->assertTrue(wp_style_is('fake-style-2', 'enqueued'));
        $this->assertTrue(wp_style_is('fake-style-3', 'enqueued'));
    }
}
