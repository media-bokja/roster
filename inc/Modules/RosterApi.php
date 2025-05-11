<?php

namespace Bojka\Roster\Modules;

use Bojka\Roster\Objects\Profile;
use Bokja\Roster\Vendor\Bojaghi\Contract\Module;
use DateTime;
use DateTimeZone;
use Exception;
use WP_Post;
use WP_Query;
use WP_REST_Request;

class RosterApi implements Module
{
    public function __construct()
    {
        $this->addRoutes();
    }

    private function addRoutes(): void
    {
        register_rest_route(
            'bokja/v1',
            '/roster',
            [
                'callback'            => [$this, 'query'],
                'methods'             => 'GET',
                'permission_callback' => fn() => is_user_logged_in(),
            ],
        );
    }

    public function query(WP_REST_Request $request): array
    {
        $page   = max(1, (int)$request->get_param('page'));
        $serach = $request->get_param('search') ?? '';

        $query = new WP_Query(
            [
                'order'          => 'desc',
                'orderby'        => 'date',
                'paged'          => $page,
                'post_status'    => 'publish',
                'post_type'      => ROSTER_CPT_PROFILE,
                'posts_per_page' => 20,
                's'              => $serach,
            ],
        );

        return [
            'result'  => array_map(fn($item) => self::convertResult($item), $query->posts),
            'page'    => $page,
            'maxPage' => $query->max_num_pages,
            'total'   => $query->found_posts,
        ];
    }

    private static function convertResult(WP_Post $post): Profile
    {
        $profile = Profile::get($post->ID);

        // Convert all dates to plain string format.
        $profile->birthday                = self::convertDate($profile->birthday);
        $profile->dateOfDeath             = self::convertDate($profile->dateOfDeath);
        $profile->departureDate           = self::convertDate($profile->departureDate);
        $profile->entranceDate            = self::convertDate($profile->entranceDate);
        $profile->initialProfessionDate   = self::convertDate($profile->initialProfessionDate);
        $profile->ordinationDate          = self::convertDate($profile->ordinationDate);
        $profile->perpetualProfessionDate = self::convertDate($profile->perpetualProfessionDate);
        $profile->profileImage            = self::correctImageUrl($profile->profileImage);
        $profile->isNew                   = self::addIsNew($post);

        return $profile;
    }

    private static function addIsNew(WP_Post $post): bool
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

    private static function correctImageUrl(array $profileImage): array
    {
        if (count($profileImage)) {
            $baseUrl = wp_get_upload_dir()['baseurl'];

            foreach ($profileImage as &$item) {
                if (isset($item['path'])) {
                    $item['path'] = $baseUrl . '/' . $item['path'];
                }
            }
        }

        return $profileImage;
    }

    private static function convertDate(string $string): string
    {
        $output = '';

        if ($string && ($timestamp = strtotime($string))) {
            $format = get_option('date_format');
            $output = wp_date($format, $timestamp);
        }

        return $output;
    }
}
