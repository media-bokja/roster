<?php

namespace Bokja\Roster\Supports;

use Bokja\Roster\Modules\Options;
use Bokja\Roster\Vendor\Bojaghi\Contract\Module;
use Bokja\Roster\Vendor\Bojaghi\Fields\Option\Option;
use Bokja\Roster\Vendor\Bojaghi\FieldsRender\AdminCompound;
use Bokja\Roster\Vendor\Bojaghi\Template\Template;

use function Bokja\Roster\Facades\rosterGet;
use function Bokja\Roster\Kses\ksesEditForm;

readonly class SettingsPage implements Module
{
    public const PAGE_SLUG = 'roster-settings';

    public function __construct(private Template $template)
    {
    }

    public function render(): void
    {
        $this->prepareSettings();

        $output = $this->template->template(
            'settings-page',
            [
                'option_group' => ROSTER_OPTIONS_GROUP,
                'page_slug'    => self::PAGE_SLUG,
                'page_title'   => __('인원 명부 설정', 'roster'),
            ],
        );

        echo wp_kses($output, ksesEditForm());
    }

    /**
     * Prepre settings
     *
     * @return void
     */
    private function prepareSettings(): void
    {
        $option = rosterGet(Options::class);

        $section = 'roster-settings-pages';

        add_settings_section($section, __('페이지', 'roster'), '__return_empty_string', self::PAGE_SLUG);

        add_settings_field(
            "$section-front",
            __('프론트 페이지', 'roster'),
            [$this, 'outputPageField'],
            self::PAGE_SLUG,
            $section,
            [
                'desc'      => __('사용할 페이지를 선택하세요. 선택한 페이지의 내용은 무시되고 회원명부가 출력됩니다.', 'roster'),
                'label_for' => "$section-front",
                'name'      => $option->pages->getKey() . '[front]',
                'value'     => $option->pages->get()['front'],
            ],
        );

        add_settings_field(
            "$section-login",
            __('로그인 페이지', 'roster'),
            [$this, 'outputPageField'],
            self::PAGE_SLUG,
            $section,
            [
                'desc'      => __('로그인 페이지를 선택하세요. 선택하지 않으면 기본 워드프레스 로그인이 사용됩니다.', 'roster'),
                'label_for' => "$section-login",
                'name'      => $option->pages->getKey() . '[login]',
                'value'     => $option->pages->get()['login'],
            ],
        );

        $section = 'roster-settings-auth';

        add_settings_section($section, __('권한', 'roster'), '__return_empty_string', self::PAGE_SLUG);

        add_settings_field(
            "$section-roles",
            __('접근 허용할 역할', 'roster'),
            [$this, 'outputRolesField'],
            self::PAGE_SLUG,
            $section,
            [
                'label_for' => "$section-roles",
                'option'    => $option->roles,
            ],
        );
    }

    /**
     * Output page field
     *
     * @param array $args
     *
     * @return void
     */
    public function outputPageField(array $args): void
    {
        $desc     = $args['desc'] ?? '';
        $labelFor = $args['label_for'] ?? '';
        $name     = $args['name'] ?? '';
        $value    = $args['value'] ?? '';

        wp_dropdown_pages(
            [
                'id'               => $labelFor,
                'show_option_none' => __('사용할 페이지 선택', 'roster'),
                'name'             => $name,
                'selected'         => $value,
            ],
        );

        echo wp_kses(AdminCompound::description($desc), ksesEditForm());
    }

    /**
     * Output roles field
     *
     * @param array $args
     *
     * @return void
     */
    public function outputRolesField(array $args): void
    {
        /** @var Option $option */
        $option = $args['option'] ?? null;
        if (!$option) {
            return;
        }

        $labelFor = $args['label_for'] ?? '';
        $roles    = array_map(fn($role) => translate_user_role($role['name']), wp_roles()->roles);
        unset($roles['administrator']); // Administrator role is always allowed.

        $output = AdminCompound::choice(
            $roles,
            $option->get(),
            'checkbox',
            [
                'id'   => $labelFor,
                'name' => $option->getKey(),
            ],
            [
                'orientation' => 'vertical',
            ],
        );

        $output .= AdminCompound::description(
            __('접근 허용할 역할을 선택하세요. 관리자는 이미 권한을 가지고 있습니다.', 'roster'),
        );

        echo wp_kses($output, ksesEditForm());
    }
}
