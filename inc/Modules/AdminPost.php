<?php

namespace Bojka\Roster\Modules;

use Bokja\Roster\Vendor\Bojaghi\Contract\Module;
use JetBrains\PhpStorm\NoReturn;

class AdminPost implements Module
{
    #[NoReturn]
    public function exportProfiles(): never
    {
        wp_die('success, but not implemented yet!', '', ['back_link' => true]);
    }
}
