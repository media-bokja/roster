<?php

namespace Bojka\Roster\Modules;

use Bokja\Roster\Vendor\Bojaghi\Fields\Meta\Meta;
use Bokja\Roster\Vendor\Bojaghi\Fields\Modules\CustomFields as CustomFieldsBase;

use function Bokja\Roster\prefixed;

/**
 * @property-read Meta $baptismalName
 * @property-read Meta $monasticName
 * @property-read Meta $birthday
 * @property-read Meta $dateOfDeath
 * @property-read Meta $entranceDate
 * @property-read Meta $initialProfessionDate
 * @property-read Meta $ordinationDate
 * @property-read Meta $departureDate
 * @property-read Meta $profileImage
 * @property-read Meta $currentAssignment
 * @property-read Meta $formerAssignments
 */
class CustomFields extends CustomFieldsBase
{
    public function __get(string $name)
    {
        $mapped = match ($name) {
            'baptismalName'           => prefixed('baptismal_name'),
            'birthday'                => prefixed('birthday'),
            'currentAssignment'       => prefixed('current_assignment'),
            'dateOfDeath'             => prefixed('date_of_death'),
            'departureDate'           => prefixed('departure_date'),
            'entranceDate'            => prefixed('entrance_date'),
            'formerAssignments'       => prefixed('former_assignments'),
            'initialProfessionDate'   => prefixed('initial_profession_date'),
            'monasticName'            => prefixed('monastic_name'),
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
