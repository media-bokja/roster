<?php

namespace Bokja\Roster\Vendor\Bojaghi\Scripts;

use Bokja\Roster\Vendor\Bojaghi\Contract\Module;
use Bokja\Roster\Vendor\Bojaghi\Helper\Helper;
use Closure;

class Script implements Module
{
    /**
     * Registered script handles
     *
     * @var string[]
     */
    private array $scripts = [];

    /**
     * Registered style handles
     *
     * @var string[]
     */
    private array $styles = [];

    private array|Closure $scriptRules = [];
    private array|Closure $styleRules  = [];

    private array|Closure $scriptAdminRules = [];
    private array|Closure $styleAdminRules  = [];

    public function __construct(string|array $args = '')
    {
        $this->register(
            $this->setup(
                wp_parse_args(
                    Helper::loadConfig($args),
                    self::getDefault(),
                ),
            ),
        );
    }

    private function register(array $args): void
    {
        foreach ($args['scripts']['items'] as $item) {
            $item = array_merge([
                'handle' => '',
                'src'    => '',
                'deps'   => [],
                'ver'    => false,
                'args'   => [],
            ], $item);

            if ($item['handle'] && $item['src']) {
                if (wp_register_script(
                    handle: $item['handle'],
                    src: $item['src'],
                    deps: $item['deps'],
                    ver: $item['ver'],
                    args: $item['args'],
                )) {
                    $this->scripts[] = $item['handle'];
                }
            }
        }

        foreach ($args['styles']['items'] as $item) {
            $item = array_merge([
                'handle' => '',
                'src'    => '',
                'deps'   => [],
                'ver'    => false,
                'media'  => 'all',
            ], $item);

            if ($item['handle'] && $item['src']) {
                if (wp_register_style(
                    handle: $item['handle'],
                    src: $item['src'],
                    deps: $item['deps'],
                    ver: $item['ver'],
                    media: $item['media'],
                )) {
                    $this->styles[] = $item['handle'];
                }
            }
        }

        $this->scripts = array_unique($this->scripts);
        $this->styles  = array_unique($this->styles);

        $this->scriptRules      = $args['scripts']['enqueue'];
        $this->scriptAdminRules = $args['scripts']['admin_enqueue'];

        $this->styleRules      = $args['styles']['enqueue'];
        $this->styleAdminRules = $args['styles']['admin_enqueue'];

        $hook = $args['enqueue_hook'] ?? 'wp_enqueue_scripts'; // DO NOT USE! Just for testing,
        add_action($hook, [$this, 'enqueueScripts'], $args['scripts']['enqueue_priority']);
        add_action($hook, [$this, 'enqueueStyles'], $args['styles']['enqueue_priority']);

        $hook = $args['admin_enqueue_hook'] ?? 'admin_enqueue_scripts'; // DO NOT USE! Just for testing,
        add_action($hook, [$this, 'adminEnqueueScripts'], $args['scripts']['admin_enqueue_priority']);
        add_action($hook, [$this, 'adminEnqueueStyles'], $args['styles']['admin_enqueue_priority']);
    }

    private function setup(array $args): array
    {
        foreach (['scripts', 'styles'] as $type) {
            // *.items
            if (!isset($args[$type]['items']) || !is_array($args[$type]['items'])) {
                $args[$type]['items'] = [];
            }

            // *.enqueue
            if (!isset($args[$type]['enqueue']) || !is_callable($args[$type]['enqueue']) && !is_array($args[$type]['enqueue'])) {
                $args[$type]['enqueue'] = [];
            }

            // *.admin_enqueue
            if (!isset($args[$type]['admin_enqueue']) || !is_callable($args[$type]['admin_enqueue']) && !is_array($args[$type]['admin_enqueue'])) {
                $args[$type]['admin_enqueue'] = [];
            }

            // *.enqueue_priority
            $args[$type]['enqueue_priority'] = (int)($args[$type]['enqueue_priority'] ?? 10);

            // *.admin_enqueue_priority
            $args[$type]['admin_enqueue_priority'] = (int)($args[$type]['admin_enqueue_priority'] ?? 10);
        }

        return $args;
    }

    /**
     * Get default configuration.
     *
     * Please refer to README.md
     *
     * @return array[]
     */
    public static function getDefault(): array
    {
        return [
            'scripts' => [
                'items'                  => [],
                'enqueue'                => [],
                'admin_enqueue'          => [],
                'enqueue_priority'       => 10,
                'admin_enqueue_priority' => 10,
            ],
            'styles'  => [
                'items'                  => [],
                'enqueue'                => [],
                'admin_enqueue'          => [],
                'enqueue_priority'       => 10,
                'admin_enqueue_priority' => 10,
            ],
        ];
    }

    public function adminEnqueueScripts(string $hook): void
    {
        self::prepEnqueue(
            caller: 'wp_enqueue_script',
            rules: $this->scriptAdminRules,
            handles: $this->scripts,
            hook: $hook,
        );

        // Reset rules
        $this->scriptAdminRules = [];
    }

    private static function prepEnqueue(
        callable       $caller,
        callable|array $rules,
        array          $handles,
        string|false   $hook = false,
    ): void
    {
        $core = function (callable $caller, array $handles, callable $condition, string|false $hook) {
            foreach ($handles as $handle) {
                // Admin or front
                if ($hook ? $condition($handle, $hook) : $condition($handle)) {
                    $caller($handle);
                }
            }
        };

        if (is_callable($rules)) {
            // One single rule callback.
            $core(
                $caller,
                $handles,
                $rules,
                $hook,
            );
        } elseif (is_array($rules)) {
            // Per-handle callable
            foreach ($rules as $handles => $condition) {
                $core(
                    $caller,
                    array_filter(array_map('trim', explode(',', $handles))),
                    $condition,
                    $hook,
                );
            }
        }
    }

    public function adminEnqueueStyles(string $hook): void
    {
        self::prepEnqueue(
            caller: 'wp_enqueue_style',
            rules: $this->styleAdminRules,
            handles: $this->styles,
            hook: $hook,
        );

        // Reset rules
        $this->styleAdminRules = [];
    }

    public function enqueueScripts(): void
    {
        self::prepEnqueue(
            caller: 'wp_enqueue_script',
            rules: $this->scriptRules,
            handles: $this->scripts,
        );

        // Reset rules
        $this->scriptRules = [];
    }

    public function enqueueStyles(): void
    {
        self::prepEnqueue(
            caller: 'wp_enqueue_style',
            rules: $this->styleRules,
            handles: $this->styles,
            hook: false,
        );

        // Reset rules
        $this->styleRules = [];
    }
}
