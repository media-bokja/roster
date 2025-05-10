<?php

namespace Bojka\Roster\Facades;

use Bokja\Roster\Vendor\Bojaghi\Continy\Continy;
use Bokja\Roster\Vendor\Bojaghi\Continy\ContinyException;
use Bokja\Roster\Vendor\Bojaghi\Continy\ContinyFactory;
use Bokja\Roster\Vendor\Bojaghi\Continy\ContinyNotFoundException;

/**
 * Wrapper function
 *
 * @return Continy
 */
function roster(): Continy
{
    static $continy = null;

    if (is_null($continy)) {
        $continy = ContinyFactory::create(dirname(__DIR__) . '/conf/continy.php');
    }

    return $continy;
}

/**
 * @template T
 * @param class-string<T> $id
 * @param bool            $constructorCall
 *
 * @return T|object|null
 */
function rosterGet(string $id, bool $constructorCall = false)
{
    try {
        $instance = roster()->get($id, $constructorCall);
    } catch (ContinyException|ContinyNotFoundException $e) {
        $instance = null;
    }

    return $instance;
}

/**
 * @template T
 * @param class-string<T> $id
 * @param string          $method
 * @param array|false     $args
 *
 * @return mixed
 */
function rosterCall(string $id, string $method, array|false $args = false): mixed
{
    try {
        $container = roster();
        $instance  = $container->get($id);
        return $container->call([$instance, $method], $args);
    } catch (ContinyException|ContinyNotFoundException $e) {
        wp_die($e->getMessage());
    }
}
