<?php

namespace Bokja\Roster\Modules;

use Bokja\Roster\Supports\EditForm;
use Bokja\Roster\Supports\RosterList;
use Bokja\Roster\Vendor\Bojaghi\Contract\Module;
use WP_Admin_Bar;
use WP_Post;
use WP_Query;
use WP_Screen;

use function Bokja\Roster\Facades\rosterCall;
use function Bokja\Roster\Facades\rosterGet;

class AdminEdit implements Module
{
    public function __construct()
    {
        add_action('current_screen', [$this, 'currentScreen']);

        add_action('save_post_' . ROSTER_CPT_PROFILE, [$this, 'savePost'], 10, 3);
        add_filter('post_updated_messages', [$this, 'updatedMessages']);
    }

    public function addAdminBarMenu(WP_Admin_Bar $adminBar): void
    {
        $front = rosterGet(Options::class)->pages->get()['front'];
        if (!$front) {
            return;
        }

        $adminBar->add_node(
            [
                'id'    => 'view-front',
                'title' => __('회원명부 보기', 'roster'),
                'href'  => get_permalink($front),
            ],
        );
    }

    public function addAttribute(WP_Post $post): void
    {
        if (ROSTER_CPT_PROFILE !== $post->post_type) {
            return;
        }

        echo 'enctype="multipart/form-data"';
    }

    /**
     * @param array $columns
     *
     * @return array
     *
     * @uses RosterList::addColumns()
     */
    public function addColumns(array $columns): array
    {
        return rosterCall(RosterList::class, 'addColumns', [$columns]);
    }

    public function addExport(string $which): void
    {
        global $post_type;

        if (ROSTER_CPT_PROFILE !== $post_type) {
            return;
        }

        rosterGet(RosterList::class)->addExport();
    }

    /**
     * @param array $columns
     *
     * @return array
     *
     * @uses RosterList::addSortableColumns()
     */
    public function addSortableColumns(array $columns): array
    {
        return rosterCall(RosterList::class, 'addSortableColumns', [$columns]);
    }

    /**
     * @param WP_Query $query
     *
     * @return void
     *
     * @uses RosterList::preGetPosts
     */
    public function preGetPosts(WP_Query $query): void
    {
        if ($query->is_main_query()) {
            remove_action('pre_get_posts', [$this, 'preGetPosts']);
            rosterCall(RosterList::class, 'preGetPosts', [$query]);
        }
    }

    /**
     * @param WP_Screen $screen
     *
     * @return void
     */
    public function currentScreen(WP_Screen $screen): void
    {
        if (ROSTER_CPT_PROFILE !== $screen->post_type) {
            return;
        }

        if ('edit' === $screen->base) {
            // List
            add_action("manage_{$screen->post_type}_posts_custom_column", [$this, 'outputColumnValues'], 10, 2);
            add_action('manage_posts_extra_tablenav', [$this, 'addExport'], 10);
            add_action('pre_get_posts', [$this, 'preGetPosts']);

            add_filter("manage_{$screen->post_type}_posts_columns", [$this, 'addColumns']);
            add_filter("manage_{$screen->id}_sortable_columns", [$this, 'addSortableColumns']);
        }

        if ('post' === $screen->base) {
            // Single
            add_action('post_edit_form_tag', [$this, 'addAttribute']);
            add_action('edit_form_after_title', [$this, 'editForm']);
        }

        add_action('admin_bar_menu', [$this, 'addAdminBarMenu'], 500);
    }

    public function editForm(WP_Post $post): void
    {
        rosterGet(EditForm::class)->render($post);
    }

    /**
     * @param string $column
     * @param int    $postId
     *
     * @return void
     *
     * @uses RosterList::outputColumnValues()
     */
    public function outputColumnValues(string $column, int $postId): void
    {
        rosterCall(RosterList::class, 'outputColumnValues', [$column, $postId]);
    }

    public function savePost(int $postId, WP_Post $post, bool $update): void
    {
        if (!$postId || !$update) {
            return;
        }

        remove_action('save_post_' . ROSTER_CPT_PROFILE, [$this, 'savePost']);

        rosterGet(EditForm::class)->save($post);

        add_action('save_post_' . ROSTER_CPT_PROFILE, [$this, 'savePost'], 10, 3);
    }

    public function updatedMessages(array $messages): array
    {
        global $post_type;

        if (ROSTER_CPT_PROFILE === $post_type) {
            $messages['post'][1] = __('명부 업데이트 됨.', 'roster');
            $messages['post'][4] = __('명부 업데이트 됨.', 'roster');
            $messages['post'][6] = __('새 명부가 등록되었습니다.', 'roster');
            $messages['post'][7] = __('명부가 저장됨', 'roster');
            $messages['post'][8] = __('명부를 제출했습니다.', 'roster');
        }

        return $messages;
    }
}
