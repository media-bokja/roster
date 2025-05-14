<?php

namespace Bojka\Roster\Modules;

use Bojka\Roster\Supports\SettingsPage;
use Bokja\Roster\Vendor\Bojaghi\Contract\Module;

use function Bojka\Roster\Facades\rosterCall;

class AdminMenu implements Module
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'addAdminMenu']);
    }

    public function addAdminMenu(): void
    {
        add_options_page(
            '인원 명부 설정 페이지',
            '인원 명부 설정',
            'manage_options',
            SettingsPage::PAGE_SLUG,
            fn() => rosterCall(SettingsPage::class, 'render'),
        );
    }
}
