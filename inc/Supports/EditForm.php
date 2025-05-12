<?php

namespace Bojka\Roster\Supports;

use Bojka\Roster\Modules\CustomFields;
use Bojka\Roster\Objects\Profile;
use Bokja\Roster\Vendor\Bojaghi\Contract\Support;
use Bokja\Roster\Vendor\Bojaghi\Template\Template;
use WP_Post;

use function Bojka\Roster\Facades\rosterGet;
use function Bokja\Roster\Kses\ksesEditForm;

readonly class EditForm implements Support
{
    public function __construct(private Template $template)
    {
    }

    public function render(WP_Post $post): void
    {
        $profile   = Profile::get($post->ID, "treat_image=url");
        $thumbnail = $profile->profileImage['thumbnail'] ?? [];

        $result = $this->template->template(
            'edit-form',
            [
                'profile' => Profile::get($post->ID, "treat_image=url"),
            ],
        );

        echo wp_kses($result, ksesEditForm());
    }

    public function save(WP_Post $post): void
    {
        if (!isset($_POST['bokja_roster'])) {
            return;
        }

        $data       = $_POST['bokja_roster'];
        $data['ID'] = $post->ID;
        $file       = $_FILES['bokja_roster_profile_image'] ?? null;

        Profile::fromArray($data, $file)->save();
    }
}
