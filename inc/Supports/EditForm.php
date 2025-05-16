<?php

namespace Bojka\Roster\Supports;

use Bojka\Roster\Objects\Profile;
use Bokja\Roster\Vendor\Bojaghi\Contract\Support;
use Bokja\Roster\Vendor\Bojaghi\Template\Template;
use WP_Post;
use function Bokja\Roster\Kses\ksesEditForm;

readonly class EditForm implements Support
{
    public function __construct(private Template $template)
    {
    }

    public function render(WP_Post $post): void
    {
        $result = $this->template->template(
            'edit-form',
            [
                'profile' => Profile::get($post->ID, "treat_image=url"),
            ],
        );

        add_filter('safe_style_css', fn(array $styles) => [...$styles, 'display']);

        echo wp_kses($result, ksesEditForm());
    }

    public function save(WP_Post $post): void
    {
        if (!isset($_POST['bokja_roster'])) {
            return;
        }

        $data       = $_POST['bokja_roster'];
        $data['ID'] = $post->ID;

        Profile::fromArray(
            $data,
            isset($_FILES['bokja_roster_profile_image']['tmp_name']) && $_FILES['bokja_roster_profile_image']['tmp_name'] ?
                $_FILES['bokja_roster_profile_image'] : null
        )->save();
    }
}
