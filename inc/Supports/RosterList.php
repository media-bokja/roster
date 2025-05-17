<?php

namespace Bojka\Roster\Supports;

use Bojka\Roster\Modules\PostMeta;
use Bokja\Roster\Vendor\Bojaghi\Template\Template;

readonly class RosterList
{
    public function __construct(
        private PostMeta $meta,
        private Template $template,
    ) {
    }

    public function addColumns(array $columns): array
    {
        if (isset($columns['cb'])) {
            $cb = $columns['cb'];
            unset($columns['cb']);
        } else {
            $cb = null;
        }

        if (isset($columns['date'])) {
            $date = $columns['date'];
            unset($columns['date']);
        } else {
            $date = null;
        }

        if (isset($columns['title'])) {
            $columns['title'] = __('이름', 'roster');
        }

        return array_merge(
            $cb ? ['cb' => $cb] : [],
            ['profile' => __('사진', 'roster')],
            $columns,
            [
                'bapdismal_name'     => __('세례명', 'roster'),
                'birthday'           => __('생일', 'roster'),
                'current_assignment' => __('현소임지', 'roster'),
            ],
            $date ? ['date' => $date] : [],
        );
    }

    public function addExport(): void
    {
        echo $this->template->template(
            'export',
            [
                'action'     => 'roster_export_profiles',
                'export_url' => add_query_arg(
                    [
                        'action' => 'roster_export_profiles',
                        'nonce'  => wp_create_nonce('roster_export_profiles'),
                    ],
                    admin_url('admin-post.php'),
                ),
                'icon_url'   => plugins_url('assets/excel-icon.png', ROSTER_MAIN),
            ],
        );
    }

    public function outputColumnValues(string $column, int $postId): void
    {
        switch ($column) {
            case 'profile':
                $profile = $this->meta->profileImage->get($postId);
                if (isset($profile['thumbnail']['path'])) {
                    $url = path_join(
                        wp_get_upload_dir()['baseurl'],
                        $profile['thumbnail']['path'],
                    );
                    printf(
                        '<img class="profile-thumbnail" src="%s" alt="%s" width="%s" height=%s">',
                        esc_url($url),
                        esc_attr(sprintf('%s 프로필 이미지', get_post_field('post_title', $postId))),
                        esc_attr($profile['thumbnail']['width'] ?? ''),
                        esc_attr($profile['thumbnail']['height'] ?? ''),
                    );
                }
                break;

            case 'bapdismal_name':
                echo esc_html($this->meta->baptismalName->get($postId));
                break;

            case 'birthday':
                $birthday = $this->meta->birthday->get($postId);
                if ($birthday) {
                    echo esc_html(wp_date(get_option('date_format'), strtotime($birthday), wp_timezone()));
                }
                break;

            case'current_assignment':
                echo esc_html($this->meta->currentAssignment->get($postId));
                break;
        }
    }
}