<?php

namespace Bokja\Roster\Modules;

use Bokja\Roster\Supports\SettingsPage;
use Bokja\Roster\Vendor\Bojaghi\Contract\Module;

use function Bokja\Roster\Facades\rosterCall;

class AdminMenu implements Module
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'addAdminMenu']);
    }

    public function addAdminMenu(): void
    {
        add_options_page(
            '회원 명부 설정 페이지',
            '회원 명부 설정',
            'manage_options',
            SettingsPage::PAGE_SLUG,
            fn() => rosterCall(SettingsPage::class, 'render'),
        );
    }
}
