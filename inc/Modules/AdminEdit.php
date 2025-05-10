<?php

namespace Bojka\Roster\Modules;

use Bojka\Roster\Supports\EditForm;
use Bokja\Roster\Vendor\Bojaghi\Contract\Module;
use WP_Post;
use WP_Screen;

use function Bojka\Roster\Facades\rosterGet;

class AdminEdit implements Module
{
    public function __construct()
    {
        add_action('current_screen', [$this, 'currentScreen']);

        add_action('save_post_' . ROSTER_CPT_PROFILE, [$this, 'savePost'], 10, 3);
        add_filter('post_updated_messages', [$this, 'updatedMessages']);
    }

    public function currentScreen(WP_Screen $screen): void
    {
        if (ROSTER_CPT_PROFILE !== $screen->post_type) {
            return;
        }

        if ('edit' === $screen->base) {
            // TODO: 목록 필드 구현
        }

        if ('post' === $screen->base) {
            add_action('post_edit_form_tag', [$this, 'addAttribute']);
            add_action('edit_form_after_title', [$this, 'editForm']);
        }
    }

    public function addAttribute(WP_Post $post): void
    {
        if (ROSTER_CPT_PROFILE !== $post->post_type) {
            return;
        }

        echo 'enctype="multipart/form-data"';
    }

    public function editForm(WP_Post $post): void
    {
        rosterGet(EditForm::class)->render($post);
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
        }

        return $messages;
    }
}
