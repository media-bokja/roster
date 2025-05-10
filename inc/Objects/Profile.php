<?php

namespace Bojka\Roster\Objects;

use Bojka\Roster\Modules\CustomFields;

use function Bojka\Roster\Facades\rosterGet;

class Profile
{
    /** @var int 워드프레스 포스트 ID */
    public int $id = 0;

    /** @var string 이름 */
    public string $name = '';

    /** @var string 세레명 */
    public string $baptismalName = '';

    /** @var string 생일 */
    public string $birthday = '';

    /** @var string 현소임지 */
    public string $currentAssignment = '';

    /** @var string 사망일 */
    public string $dateOfDeath = '';

    /** @var string 퇴회일 */
    public string $departureDate = '';

    /** @var string 입회일 */
    public string $entranceDate = '';

    /** @var string 전소임지 */
    public string $formerAssignments = '';

    /** @var string 초(初)서원일, 첫 서원일 */
    public string $initialProfessionDate = '';

    /** @var string 수도명 */
    public string $monasticName = '';

    /** @var string 서품일 */
    public string $ordinationDate = '';

    /** @var array 사진 */
    public array $profileImage = ['full' => [], 'thumbnail' => []];

    /** @var string 종신서원일 */
    public string $perpetualProfessionDate = '';

    public static function fromArray(array $data): Profile
    {
        $output = new self();

        $output->id = absint($data['id'] ?? '0');

        // From posts: total 1 field.
        $output->name = $data['name'] ?? '';

        // From meta: total 12 fields.
        $output->baptismalName           = $data['baptismal_name'] ?? '';
        $output->birthday                = $data['birthday'] ?? '';
        $output->currentAssignment       = $data['current_assignment'] ?? '';
        $output->dateOfDeath             = $data['date_of_death'] ?? '';
        $output->departureDate           = $data['departure_date'] ?? '';
        $output->entranceDate            = $data['entrance_date'] ?? '';
        $output->formerAssignments       = $data['former_assignments'] ?? '';
        $output->initialProfessionDate   = $data['initial_profession_date'] ?? '';
        $output->monasticName            = $data['monastic_name'] ?? '';
        $output->ordinationDate          = $data['ordination_date'] ?? '';
        $output->perpetualProfessionDate = $data['perpetual_profession_date'] ?? '';

        if ($output->id > 0) {
            $output->profileImage = rosterGet(CustomFields::class)->profileImage->get($output->id);
        } else {
            $output->profileImage = [];
        }

        return $output;
    }

    public static function get(string|int|null $id): Profile
    {
        $meta   = rosterGet(CustomFields::class);
        $post   = get_post($id);
        $output = new self();

        if ($post && ROSTER_CPT_PROFILE === $post->post_type) {
            $output->id = $post->ID;

            // From post
            $output->name = $post->post_title;

            // From meta
            $output->baptismalName           = $meta->baptismalName->get($post->ID);
            $output->birthday                = $meta->birthday->get($post->ID);
            $output->currentAssignment       = $meta->currentAssignment->get($post->ID);
            $output->dateOfDeath             = $meta->dateOfDeath->get($post->ID);
            $output->departureDate           = $meta->departureDate->get($post->ID);
            $output->entranceDate            = $meta->entranceDate->get($post->ID);
            $output->formerAssignments       = $meta->formerAssignments->get($post->ID);
            $output->initialProfessionDate   = $meta->initialProfessionDate->get($post->ID);
            $output->monasticName            = $meta->monasticName->get($post->ID);
            $output->ordinationDate          = $meta->ordinationDate->get($post->ID);
            $output->perpetualProfessionDate = $meta->perpetualProfessionDate->get($post->ID);
            $output->profileImage            = $meta->profileImage->get($post->ID);
        }

        return $output;
    }

    public function toArray(): array
    {
        return (array)$this;
    }

    public function delete(int|string $id, bool $force = false): void
    {
        wp_delete_post($id, $force);
    }

    public function save(): int
    {
        $postarr = [
            'post_content' => '',
            'post_name'    => "roster-$this->id",
            'post_status'  => 'publish',
            'post_title'   => $this->name,
            'post_type'    => ROSTER_CPT_PROFILE,
            'meta_input'   => [
                'roster_baptismal_name'            => $this->baptismalName,
                'roster_birthday'                  => $this->birthday,
                'roster_current_assignment'        => $this->currentAssignment,
                'roster_date_of_death'             => $this->dateOfDeath,
                'roster_departure_date'            => $this->departureDate,
                'roster_entrance_date'             => $this->entranceDate,
                'roster_former_assignments'        => $this->formerAssignments,
                'roster_initial_profession_date'   => $this->initialProfessionDate,
                'roster_monastic_name'             => $this->monasticName,
                'roster_ordination_date'           => $this->ordinationDate,
                'roster_perpetual_profession_date' => $this->perpetualProfessionDate,
                'roster_profile_image'             => $this->profileImage,
            ],
        ];

        if (!$this->id) {
            // insert
            $id = wp_insert_post($postarr);
        } else {
            // update
            $postarr['ID'] = $this->id;
            $id            = wp_update_post($postarr);
        }

        if (is_wp_error($id)) {
            wp_die($id);
        }

        $this->id = (int)$id;

        return $id;
    }
}
