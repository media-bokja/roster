<?php

namespace Bokja\Roster\Vendor\Bojaghi\Contract;

use Bokja\Roster\Vendor\Psr\Container\ContainerInterface;

interface Container extends ContainerInterface
{
    public function call(callable|array|string $callable, array|callable $args = []);
}
