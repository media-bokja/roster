<?php

namespace Bokja\Roster\Modules;

use Bokja\Roster\Supports\FrontPage;
use Bokja\Roster\Vendor\Bojaghi\Contract\Module;

use function Bokja\Roster\Facades\rosterCall;

class AdminAjax implements Module
{
    /**
     * @return void
     *
     * @uses FrontPage::setTheme()
     */
    public function setTheme(): void
    {
        if (isset($_REQUEST['theme'])) {
            $theme = rosterCall(FrontPage::class, 'setTheme', [$_REQUEST['theme']]);
            wp_send_json_success(['theme' => $theme]);
        }
    }
}
