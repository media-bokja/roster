<?php

namespace Bojka\Roster\Modules;

use Bokja\Roster\Vendor\Bojaghi\Fields\Meta\Meta;
use Bokja\Roster\Vendor\Bojaghi\Fields\Modules\CustomFields as CustomFieldsBase;

use function Bokja\Roster\prefixed;

/**
 * @property-read Meta $baptismalName
 * @property-read Meta $birthday
 * @property-read Meta $currentAssignment
 * @property-read Meta $dateOfDeath
 * @property-read Meta $departureDate
 * @property-read Meta $entranceDate
 * @property-read Meta $formerAssignments
 * @property-read Meta $initialProfessionDate
 * @property-read Meta $monasticName
 * @property-read Meta $nationality
 * @property-read Meta $ordinationDate
 * @property-read Meta $profileImage
 */
class PostMeta extends CustomFieldsBase
{
    public function __get(string $name)
    {
        $mapped = match ($name) {
            'baptismalName'           => prefixed('baptismal_name'),
            'birthday'                => prefixed('birthday'),
            'currentAssignment'       => prefixed('current_assignment'),
            'dateOfDeath'             => prefixed('date_of_death'),
            'entranceDate'            => prefixed('entrance_date'),
            'initialProfessionDate'   => prefixed('initial_profession_date'),
            'monasticName'            => prefixed('monastic_name'),
            'nameDay'                 => prefixed('name_day'),
            'nationality'             => prefixed('nationality'),
            'ordinationDate'          => prefixed('ordination_date'),
            'perpetualProfessionDate' => prefixed('perpetual_profession_date'),
            'profileImage'            => prefixed('profile_image'),
            default                   => '',
        };

        if ($mapped) {
            return $this->getPostMeta($mapped);
        }

        return null;
    }
}
