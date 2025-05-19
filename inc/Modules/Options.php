<?php

namespace Bokja\Roster\Modules;

use Bokja\Roster\Vendor\Bojaghi\Fields\Modules\Options as OptionsBase;
use Bokja\Roster\Vendor\Bojaghi\Fields\Option\Option;

use function Bokja\Roster\prefixed;

/**
 * @property-read Option $pages
 * @property-read Option $roles
 */
class Options extends OptionsBase
{
    public function __get(string $name)
    {
        $mapped = match ($name) {
            'pages' => prefixed('pages'),
            'roles' => prefixed('roles'),
            default => '',
        };

        if ($mapped) {
            return $this->getOption($mapped);
        }

        return null;
    }
}
