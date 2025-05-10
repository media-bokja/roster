<?php

namespace Bojka\Roster\Modules;

use Bojka\Roster\Supports\ImageSupport;
use Bokja\Roster\Vendor\Bojaghi\Contract\Module;

use function Bojka\Roster\Facades\rosterGet;

class ProfileImage implements Module
{
    public function __construct()
    {
        add_action('deleted_post_' . ROSTER_CPT_PROFILE, [$this, 'onDeleteImage'], 10, 2);
    }

    public function onDeleteImage(int|string $postId): void
    {
        rosterGet(ImageSupport::class)->removeImage($postId);
    }


}
