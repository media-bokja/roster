<?php

namespace Bojka\Roster\Modules;

use Bokja\Roster\Vendor\Bojaghi\Contract\Module;
use Bokja\Roster\Vendor\Bojaghi\Helper\Helper;

class Scripts implements Module
{
    private array $args;

    public function __construct(array|string $args = '')
    {
        $args = Helper::loadConfig($args);

        $default = [
            'script' => [
                'items'         => [
                    // 스크립트 예시
                    [
                        'handle' => '',
                        'src'    => '',
                        'deps'   => [],
                        'ver'    => false,
                        'args'   => [],
                    ],
                ],
                // 인큐 옵션
                // 1. 콜백 함수. 핸들을 인자로 받음. 함수를 호출하고 결과가 참일 때 스크립트 인큐.
                // 2. 키-값 배열. 키는 핸들, 콜백 함수. 함수는 핸들을 인자로 받음. 호출 결과가 참이면 스크립트 인큐잉.
                'enqueue'       => [],
                // 어드민 인큐 옵션
                // 1. 콜백 함수. 인큐 옵션과 동일.
                // 2. 키-값 배열. 키는 $hook 문자열.
                //    - 현재 처리하는 $hook 에 해당하는 배열을 선택.
                //    - 배열의 값은 문자열 또는 콜백의 배열.
                //    - 문자열이라면 바로 인큐.
                //    - 콜백이라면 핸들과 $hook 를 인자로 넣고 호출. 참이면 인큐.
                'admin_enqueue' => [],
            ],
            'style'  => [
                'items'         => [
                    // 스타일 예시
                    [
                        'handle' => '',
                        'src'    => '',
                        'deps'   => [],
                        'ver'    => false,
                        'madia'  => 'all',
                    ],
                ],
                'enqueue'       => [], // script 와 동일한 규칙
                'admin_enqueue' => [], // script 와 동일한 규칙
            ],
        ];

        $this->args = wp_parse_args($args, $default);

        $this->args['script']['items'] = wp_parse_args(
            $this->args['script']['items'] ?? [],
            $default['script']['items'],
        );

        $this->args['script']['enqueue'] = wp_parse_args(
            $this->args['script']['enqueue'] ?? [],
            $default['script']['enqueue'],
        );

        $this->args['script']['admin_enqueue'] = wp_parse_args(
            $this->args['script']['admin_enqueue'] ?? [],
            $default['script']['admin_enqueue'],
        );

        $this->args['style']['items'] = wp_parse_args(
            $this->args['style']['items'] ?? [],
            $default['style']['items'],
        );

        $this->args['style']['enqueue'] = wp_parse_args(
            $this->args['style']['enqueue'] ?? [],
            $default['style']['enqueue'],
        );

        $this->args['style']['admin_enqueue'] = wp_parse_args(
            $this->args['style']['admin_enqueue'] ?? [],
            $default['style']['admin_enqueue'],
        );

        if (!did_action('init')) {
            add_action('init', [$this, 'register']);
        } elseif (doing_action('init')) {
            $this->register();
        }
    }

    public function register(): void
    {
        $registered = [];

        foreach ($this->args['script']['items'] as $item) {
            $item = wp_parse_args(
                $item,
                [
                    'handle' => '',
                    'src'    => '',
                    'deps'   => [],
                    'ver'    => false,
                    'args'   => [],
                ],
            );

            if ($item['handle'] && $item['src']) {
                if (!wp_register_script(
                    handle: $item['handle'],
                    src:    $item['src'],
                    deps:   $item['deps'],
                    ver:    $item['ver'],
                    args:   $item['args'],
                )) {
                    wp_die(sprintf('Failed to register script: %s', $item['handle']));
                }

                $registered[] = $item['handle'];
            }
        }

        // Change the form of array.
        $this->args['script']['items'] = $registered;

        $registered = [];

        foreach ($this->args['style']['items'] as $item) {
            $item = wp_parse_args(
                $item,
                [
                    'handle' => '',
                    'src'    => '',
                    'deps'   => [],
                    'ver'    => false,
                    'media'  => 'all',
                ],
            );

            if ($item['handle'] && $item['src']) {
                if (!wp_register_style(
                    handle: $item['handle'],
                    src:    $item['src'],
                    deps:   $item['deps'],
                    ver:    $item['ver'],
                    media:  $item['media'],
                )) {
                    wp_die(sprintf('Failed to register style: %s', $item['handle']));
                }

                $registered[] = $item['handle'];
            }
        }

        // Change the form of array.
        $this->args['style']['items'] = $registered;

        if (($this->args['script']['items'] || $this->args['style']['items']) && ($this->args['script']['enqueue'] || $this->args['style']['enqueue'])) {
            add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        }

        if (($this->args['script']['items'] || $this->args['style']['items']) && ($this->args['script']['admin_enqueue'] || $this->args['style']['admin_enqueue'])) {
            add_action('admin_enqueue_scripts', [$this, 'adminEnqueue']);
        }
    }

    public function enqueue(): void
    {
        if ($this->args['script']['enqueue']) {
            $rules = $this->args['script']['enqueue'];

            if (is_callable($rules)) {
                // One single rule callback.
                // The array is changed into a list of strings.
                foreach ($this->args['script']['items'] as $item) {
                    if ($rules($item)) {
                        wp_enqueue_script($item);
                    }
                }
            } elseif (is_array($rules)) {
                // Per-handle callabck.
                foreach ($rules as $handle => $condition) {
                    is_callable($condition) && $condition($handle) &&
                    wp_enqueue_script($handle);
                }
            }
        }

        if ($this->args['style']['enqueue']) {
            $rules = $this->args['style']['enqueue'];

            if (is_callable($rules)) {
                // One single rule callback.
                // The array is changed into a list of strings.
                foreach ($this->args['style']['items'] as $item) {
                    if ($rules($item)) {
                        wp_enqueue_style($item);
                    }
                }
            } elseif (is_array($rules)) {
                // Per-handle callabck.
                foreach ($rules as $handle => $condition) {
                    if (is_callable($condition) && $condition($handle)) {
                        is_callable($condition) && $condition($handle) &&
                        wp_enqueue_style($handle);
                    }
                }
            }
        }
    }

    public function adminEnqueue(string $hook): void
    {
        if ($this->args['script']['admin_enqueue']) {
            $rules = $this->args['script']['admin_enqueue'];

            if (is_callable($rules)) {
                // One single callback.
                // The array is changed into a list of strings.
                foreach ($this->args['script']['items'] as $item) {
                    if ($rules($hook, $item)) {
                        wp_enqueue_script($item);
                    }
                }
            } elseif (is_array($rules)) {
                // Detailed per-hook rules.
                foreach ($rules as $handle => $conditions) {
                    is_array($conditions) && isset($conditions[$hook]) &&
                    is_callable($conditions[$hook]) && $conditions[$hook]($hook, $handle) &&
                    wp_enqueue_script($handle);
                }
            }
        }

        if ($this->args['style']['admin_enqueue']) {
            $rules = $this->args['style']['admin_enqueue'];

            if (is_callable($rules)) {
                // One single callback.
                // The array is changed into a list of strings.
                foreach ($this->args['style']['items'] as $item) {
                    if ($rules($item)) {
                        wp_enqueue_style($item);
                    }
                }
            } elseif (is_array($rules)) {
                // Detailed per-hook rules.
                foreach ($rules as $handle => $conditions) {
                    is_array($conditions) && isset($conditions[$hook]) &&
                    is_callable($conditions[$hook]) && $conditions[$hook]($hook, $handle) &&
                    wp_enqueue_style($handle);
                }
            }
        }
    }
}
