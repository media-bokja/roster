<?php

namespace Bojka\Roster\Supports;

use Bojka\Roster\Modules\Options;
use Bokja\Roster\Vendor\Bojaghi\Contract\Support;
use Bokja\Roster\Vendor\Bojaghi\Template\Template;
use Bokja\Roster\Vendor\Bojaghi\ViteScripts\ViteScript;

readonly class FrontPage implements Support
{
    public function __construct(
        private Options $options,
        private Template $template,
        private ViteScript $vite,
    ) {
    }

    public function addExtraAttrsToHTML(string $output): string
    {
        return $output . ' data-theme="light"';
    }

    public function before(): void
    {
        if (!is_user_logged_in()) {
            wp_redirect(wp_login_url(get_the_permalink()));
            exit;
        }

        // Access check
        $accessible = array_reduce(
            $this->options->roles->get(),
            fn($carry, $role) => $carry || current_user_can($role),
            false,
        );
        if (!$accessible) {
            wp_die(__('접근 권한이 없습니다.', 'roster'));
        }

        add_filter('language_attributes', [$this, 'addExtraAttrsToHTML'], 10, 2);
    }

    public function checkCondition(): bool
    {
        $pageId = $this->options->page->get();

        return $pageId && is_page($pageId);
    }

    public function render(): void
    {
        echo wp_kses(
            $this->template->template('react-root'),
            [
                'div' => [
                    'id'               => true,
                    'class'            => true,
                    'data-roster-root' => true,
                ],
            ],
        );

        $user = wp_get_current_user();

        $this->vite
            ->add('roster', 'src/roster.tsx')
            ->vars('rosterVars', [
                'api'      => [
                    'baseUrl' => rest_url('bokja/v1'),
                    'nonce'   => wp_create_nonce('wp_rest'),
                ],
                'sitemeta' => [
                    'avatarUrl'  => get_edit_profile_url($user->ID),
                    'homeUrl'    => home_url(),
                    'pageTitle'  => get_the_title(),
                    'siteIcon'   => get_site_icon_url(32),
                    'siteUrl'    => get_the_permalink(),
                    'siteTitle'  => get_bloginfo('name'),
                    'userAvatar' => get_avatar_url($user->ID),
                    'userName'   => $user->display_name,
                ],
            ])
        ;
    }
}
