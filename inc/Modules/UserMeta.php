<?php

namespace Bokja\Roster\Modules;

use Bokja\Roster\Vendor\Bojaghi\Fields\Meta\Meta;
use Bokja\Roster\Vendor\Bojaghi\Fields\Modules\CustomFields as CustomFieldsBase;

use function Bokja\Roster\prefixed;

/**
 * @property-read Meta $theme
 */
class UserMeta extends CustomFieldsBase
{
    public function __get(string $name)
    {
        $mapped = match ($name) {
            'theme' => prefixed('theme'),
            default => '',
        };

        if ($mapped) {
            return $this->getUserMeta($mapped);
        }

        return null;
    }
}
