<?php

namespace Bojka\Roster\Modules;

use Bojka\Roster\Supports\RosterList;
use Bokja\Roster\Vendor\Bojaghi\Contract\Module;
use JetBrains\PhpStorm\NoReturn;

use function Bojka\Roster\Facades\rosterGet;

class AdminPost implements Module
{
    #[NoReturn]
    public function exportProfiles(): never
    {
        if (!current_user_can('administrator')) {
            wp_die(
                __('죄송합니다. 이 작업은 관리자만 할 수 있습니다.', 'roster'),
                __('권한 에러', 'roster'),
                ['back_link' => true],
            );
        }

        rosterGet(RosterList::class)->exportProfiles();

        exit;
    }
}
