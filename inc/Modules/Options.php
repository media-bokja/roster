<?php

namespace Bojka\Roster\Modules;

use Bokja\Roster\Vendor\Bojaghi\Fields\Modules\Options as OptionsBase;
use Bokja\Roster\Vendor\Bojaghi\Fields\Option\Option;

use function Bokja\Roster\prefixed;

/**
 * @property-read Option $page
 * @property-read Option $roles
 */
class Options extends OptionsBase
{
    public function __get(string $name)
    {
        $mapped = match ($name) {
            'page'  => prefixed('page'),
            'roles' => prefixed('roles'),
            default => '',
        };

        if ($mapped) {
            return $this->getOption($mapped);
        }

        return null;
    }
}
