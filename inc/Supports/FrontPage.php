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
            $loginPage = $this->options->pages->get()['login'];
            if ($loginPage) {
                $loginUrl = add_query_arg('redirect_to', get_the_permalink(), get_permalink($loginPage));
            } else {
                $loginUrl = wp_login_url(get_the_permalink());
            }
            wp_redirect($loginUrl);
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

        add_action('bojaghi/clean-pages/head/end', [$this, 'outputHeaders']);
        add_filter('language_attributes', [$this, 'addExtraAttrsToHTML'], 10, 2);
    }

    public function checkCondition(): bool
    {
        $pageId = $this->options->pages->get()['front'];

        return $pageId && is_page($pageId);
    }

    public function outputHeaders(): void
    {
        // Output site icons
        if (has_site_icon()) {
            $context = [
                'icon32'  => get_site_icon_url(32),
                'icon180' => get_site_icon_url(180),
                'icon192' => get_site_icon_url(192),
                'icon270' => get_site_icon_url(270),
                'title'   => '한국순교복자성직수도회 회원명부',
            ];

            echo $this->template->template('front-header', $context);;
        }
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
                    'homeUrl'         => home_url(),
                    'pageTitle'       => get_the_title(),
                    'profileAdminUrl' => get_edit_profile_url($user->ID),
                    'rosterAdminUrl'  => current_user_can('edit_posts') ? admin_url(
                        add_query_arg(
                            'post_type',
                            ROSTER_CPT_PROFILE,
                            'edit.php',
                        ),
                    ) : '',
                    'siteIcon'        => get_site_icon_url(32),
                    'siteUrl'         => get_the_permalink(),
                    'siteTitle'       => get_bloginfo('name'),
                    'userAvatar'      => get_avatar_url($user->ID),
                    'userName'        => $user->display_name,
                ],
            ])
        ;
    }
}
