<?php

namespace Bokja\Roster\Objects;

use Bokja\Roster\Modules\PostMeta;
use Bokja\Roster\Supports\ImageSupport;
use DateTime;
use DateTimeZone;
use Exception;
use WP_Post;

use function Bokja\Roster\Facades\rosterGet;
use function Bokja\Roster\prefixed;

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

    /** @var string 선종일 */
    public string $dateOfDeath = '';

    /** @var string 입회일 */
    public string $entranceDate = '';

    /** @var string 첫서원일 */
    public string $initialProfessionDate = '';

    /** @var string 수도명 */
    public string $monasticName = '';

    /** @var string 축일 */
    public string $nameDay = '';

    /** @var string 국적 */
    public string $nationality = '';

    /** @var string 서품일 */
    public string $ordinationDate = '';

    /** @var string 종신서원일 */
    public string $perpetualProfessionDate = '';

    /** @var array 사진 */
    public array $profileImage = [
        'full'      => [],
        'medium'    => [],
        'thumbnail' => [],
    ];

    public ?bool $isNew = null;

    public function delete(int|string $id, bool $force = false): void
    {
        wp_delete_post($id, $force);
    }

    public static function formatNameDay(string $value, string $format = '%1$02d-%2$02d'): string
    {
        return self::sanitizeNameDay($value, $format);
    }

    public static function fromArray(array $data, ?array $profileFile = null): Profile
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
        $output->entranceDate            = $data['entrance_date'] ?? '';
        $output->initialProfessionDate   = $data['initial_profession_date'] ?? '';
        $output->monasticName            = $data['monastic_name'] ?? '';
        $output->nameDay                 = $data['name_day'] ?? '';
        $output->nationality             = $data['nationality'] ?? '';
        $output->ordinationDate          = $data['ordination_date'] ?? '';
        $output->perpetualProfessionDate = $data['perpetual_profession_date'] ?? '';
        $output->isNew                   = $data['isNew'] ?? null;

        if ($output->id > 0) {
            if ($profileFile) {
                $output->profileImage = self::manageProfileImage($profileFile, $output->id);
            } else {
                // Keep original image.
                $output->profileImage = rosterGet(PostMeta::class)->profileImage->get($output->id);
            }
        }

        return $output;
    }

    public static function removeProfileImage(int $postId): void
    {
        $support = rosterGet(ImageSupport::class);
        $support->removeImage($postId);

        $meta = rosterGet(PostMeta::class);
        $meta->profileImage->delete($postId);
    }

    private static function manageProfileImage(array $file, int $postId): array
    {
        if (!isset($file['error'], $file['tmp_name'], $file['type']) || UPLOAD_ERR_OK !== $file['error']) {
            return [];
        }

        if (!in_array($file['type'], ['image/jpeg', 'image/png', 'image/webp'])) {
            return [];
        }

        $support = rosterGet(ImageSupport::class);
        $support->removeImage($postId);

        $fileName = sprintf(
            '%s/%s-%s.webp',
            $support->getUploadDir(),
            $postId,
            strtolower(wp_generate_password(8, false)),
        );

        return $support->processImage($file['tmp_name'], $fileName);
    }

    public static function get(WP_Post|string|int|null $id, array|string $args = ''): Profile
    {
        $args = wp_parse_args(
            $args,
            [
                'treat_date'  => '',
                'treat_image' => '',
            ],
        );

        $meta   = rosterGet(PostMeta::class);
        $post   = get_post($id);
        $output = new self();

        // treate_date
        $treatDate = $args['treat_date'] ?? '';
        if (!in_array($treatDate, ['', 'date', 'string'])) {
            $treatDate = '';
        }

        // treat_image
        $treatImage = $args['treat_image'] ?? '';
        if (!in_array($treatImage, ['', 'url', 'path'])) {
            $treatImage = '';
        }

        if ($post && ROSTER_CPT_PROFILE === $post->post_type) {
            $output->id = $post->ID;

            // From post
            $output->name = $post->post_title;

            // From meta
            $output->baptismalName           = $meta->baptismalName->get($post->ID);
            $output->birthday                = $meta->birthday->get($post->ID);
            $output->currentAssignment       = $meta->currentAssignment->get($post->ID);
            $output->dateOfDeath             = $meta->dateOfDeath->get($post->ID);
            $output->entranceDate            = $meta->entranceDate->get($post->ID);
            $output->initialProfessionDate   = $meta->initialProfessionDate->get($post->ID);
            $output->monasticName            = $meta->monasticName->get($post->ID);
            $output->nameDay                 = $meta->nameDay->get($post->ID);
            $output->nationality             = $meta->nationality->get($post->ID);
            $output->ordinationDate          = $meta->ordinationDate->get($post->ID);
            $output->perpetualProfessionDate = $meta->perpetualProfessionDate->get($post->ID);
            $output->profileImage            = $meta->profileImage->get($post->ID);
            $output->isNew                   = self::setIsNew($post);

            if ('string' === $treatDate) {
                $output->birthday                = self::convertDate($output->birthday);
                $output->dateOfDeath             = self::convertDate($output->dateOfDeath);
                $output->entranceDate            = self::convertDate($output->entranceDate);
                $output->initialProfessionDate   = self::convertDate($output->initialProfessionDate);
                $output->ordinationDate          = self::convertDate($output->ordinationDate);
                $output->perpetualProfessionDate = self::convertDate($output->perpetualProfessionDate);

                // Make sure the name day is correct.
                $output->nameDay = self::sanitizeNameDay($output->nameDay);
            }

            if (count($output->profileImage) && $treatImage) {
                $base = match ($treatImage) {
                    'url'  => wp_get_upload_dir()['baseurl'],
                    'path' => wp_get_upload_dir()['basedir'],
                };
                foreach ($output->profileImage as &$item) {
                    if (isset($item['path'])) {
                        $item['path'] = path_join($base, $item['path']);
                    }
                }
            }
        }

        return $output;
    }

    private static function setIsNew(WP_Post $post): bool
    {
        try {
            $now     = new DateTime('now', wp_timezone());
            $created = new DateTime($post->post_date_gmt, new DateTimeZone('UTC'));
            $diff    = $now->diff($created);
            $isNew   = $diff->days < 7;
        } catch (Exception $e) {
            return false;
        }

        return $isNew;
    }

    private static function convertDate(string $string): string
    {
        $output = '';

        if (preg_match('/\d{4}-\d{1,2}-\d{1,2}/', $string) && ($timestamp = strtotime($string))) {
            $format = get_option('date_format');
            $output = wp_date($format, $timestamp);
        } else {
            $exploded = array_map(fn($v) => intval($v), explode('-', $string));
            if (1 === count($exploded) && $exploded[0] > 0) {
                $output = sprintf(__('%1$04d년 경', 'roster'), $exploded[0]);
            } elseif (2 === count($exploded) && $exploded[0] > 0 && $exploded[1] > 0) {
                $output = sprintf(__('%1$04d년 %2$02d월 경', 'roster'), $exploded[0], $exploded[1]);
            }
        }

        return $output;
    }

    public static function sanitizeNameDay(mixed $value, string $format = '%1$02d-%2$02d'): string
    {
        $output = '';

        if (is_string($value) && str_contains($value, '-')) {
            $exp   = explode('-', $value, 2);
            $month = absint($exp[0]);
            $day   = absint($exp[1]);

            if ($month && $day) {
                $output = sprintf($format, $month, $day);
            }
        }

        return $output;
    }

    public static function sanitizeApproxDate(string $value): string
    {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return $value;
        }

        $value = preg_replace('/[^0-9]/', '', $value);

        if (strlen($value) >= 4) {
            $year  = (int)substr($value, 0, 4);
            $month = (int)substr($value, 4, 2);
            if ($year > 0 && $month > 0) {
                $value = sprintf('%04d-%02d', $year, $month);
            } else {
                $value = sprintf('%04d', $year);
            }
        } else {
            $value = '';
        }

        return $value;
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
                prefixed('baptismal_name')            => $this->baptismalName,
                prefixed('birthday')                  => $this->birthday,
                prefixed('current_assignment')        => $this->currentAssignment,
                prefixed('date_of_death')             => $this->dateOfDeath,
                prefixed('entrance_date')             => $this->entranceDate,
                prefixed('initial_profession_date')   => $this->initialProfessionDate,
                prefixed('monastic_name')             => $this->monasticName,
                prefixed('name_day')                  => $this->nameDay,
                prefixed('nationality')               => $this->nationality,
                prefixed('ordination_date')           => $this->ordinationDate,
                prefixed('perpetual_profession_date') => $this->perpetualProfessionDate,
                prefixed('profile_image')             => $this->profileImage,
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

    public function toArray(): array
    {
        return (array)$this;
    }
}
