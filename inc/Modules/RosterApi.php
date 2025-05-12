<?php

namespace Bojka\Roster\Modules;

use Bojka\Roster\Objects\Profile;
use Bokja\Roster\Vendor\Bojaghi\Contract\Module;
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
            'result'  => array_map(
                fn($item) => Profile::get($item, "treat_date=string&treat_image=url"),
                $query->posts,
            ),
            'page'    => $page,
            'maxPage' => $query->max_num_pages,
            'total'   => $query->found_posts,
        ];
    }
}
