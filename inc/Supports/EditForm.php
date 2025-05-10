<?php

namespace Bojka\Roster\Supports;

use Bojka\Roster\Modules\CustomFields;
use Bojka\Roster\Objects\Profile;
use Bokja\Roster\Vendor\Bojaghi\Contract\Support;
use Bokja\Roster\Vendor\Bojaghi\Template\Template;
use WP_Post;

use function Bojka\Roster\Facades\rosterGet;

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
                'profile' => Profile::get($post->ID),
            ],
        );

        echo wp_kses(
            $result,
            [
                'div'      => ['class' => true],
                'table'    => [
                    'class' => true,
                    'role'  => true,
                ],
                'tbody'    => [],
                'tr'       => [],
                'th'       => ['scope' => true],
                'td'       => [],
                'img'      => [
                    'alt'    => true,
                    'class'  => true,
                    'height' => true,
                    'id'     => true,
                    'src'    => true,
                    'title'  => true,
                    'width'  => true,
                ],
                'input'    => [
                    'id'       => true,
                    'class'    => true,
                    'name'     => true,
                    'required' => true,
                    'type'     => true,
                    'value'    => true,
                ],
                'label'    => ['for' => true],
                'p'        => ['class' => true],
                'textarea' => [
                    'id'    => true,
                    'class' => true,
                    'name'  => true,
                    'rows'  => true,
                    'cols'  => true,
                ]
            ],
        );
    }

    public function save(WP_Post $post): void
    {
        if (!isset($_POST['bokja_roster'])) {
            return;
        }

        $profile = Profile::fromArray($_POST['bokja_roster']);

        if (isset($_FILES['bokja_roster_profile_image']) && !empty($_FILES['bokja_roster_profile_image']['name'])) {
            $profile->profileImage = $this->manageProfileImage($_FILES['bokja_roster_profile_image'], $post->ID);
        }

        $profile->save();
    }

    private function manageProfileImage(array $file, int $postId): array
    {
        if (!isset($file['error'], $file['tmp_name'], $file['type']) || UPLOAD_ERR_OK !== $file['error']) {
            return [];
        }

        if (!in_array($file['type'], ['image/jpeg', 'image/png', 'image/webp'])) {
            return [];
        }

        $support      = rosterGet(ImageSupport::class);
        $profileImage = rosterGet(CustomFields::class)->profileImage->get($postId);
        $fileName     = $profileImage['full']['file'] ?? sprintf(
            '%s-%s.webp',
            $postId,
            strtolower(wp_generate_password(8, false)),
        );

        return $support->processImage(
            $file['tmp_name'],
            $support->getUploadDir() . '/' . $fileName,
        );
    }
}
