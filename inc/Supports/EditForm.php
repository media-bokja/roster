<?php

namespace Bokja\Roster\Supports;

use Bokja\Roster\Objects\Profile;
use Bokja\Roster\Vendor\Bojaghi\Contract\Support;
use Bokja\Roster\Vendor\Bojaghi\Template\Template;
use WP_Post;

use function Bokja\Roster\Facades\rosterGet;
use function Bokja\Roster\Kses\ksesEditForm;

readonly class EditForm implements Support
{
    public function __construct(private Template $template)
    {
    }

    public function render(WP_Post $post): void
    {
        $profile = Profile::get($post->ID, "treat_image=url");

        // Correct 'Auto Draft' here
        if ('auto-draft' === $post->post_status && __('Auto Draft') === $profile->name) {
            $profile->name = '';
        }

        // Nationality options
        $countries = [
            __('대한민국', 'roster'),
            __('동(東)티모르', 'roster'),
            __('베트남', 'roster'),
            __('필리핀', 'roster'),
        ];
        if (!in_array($profile->nationality, $countries, true)) {
            $countries[] = $profile->nationality;
        }

        $result = $this->template->template(
            'edit-form',
            [
                'countries' => $countries,
                'profile'   => $profile,
            ],
        );

        // Allow 'style' attrribute when using wp_kses().
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

        // Remove profile image
        $remove = filter_var($_POST['bokja_roster_remove_profile_image'] ?? 'no', FILTER_VALIDATE_BOOLEAN);
        if ($remove) {
            Profile::removeProfileImage($post->ID);
        }

        Profile::fromArray(
            $data,
            isset($_FILES['bokja_roster_profile_image']['tmp_name']) && $_FILES['bokja_roster_profile_image']['tmp_name'] ?
                $_FILES['bokja_roster_profile_image'] : null,
        )->save();
    }
}
