<?php

namespace Bojka\Roster\Modules;

use Bojka\Roster\Objects\Profile;
use Bokja\Roster\Vendor\Bojaghi\Contract\Module;
use WP_Query;
use WP_REST_Request;

use function Bojka\Roster\Facades\rosterGet;

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
        $meta   = rosterGet(PostMeta::class);
        $page   = max(1, (int)$request->get_param('page'));
        $search = $request->get_param('search') ?? '';

        // Replace AND to OR.
        $callback = function ($sql, $queries, $type) use ($meta): array {
            if (
                'post' === $type &&
                $meta->baptismalName->getKey() === $queries[0]['key'] &&
                $meta->currentAssignment->getKey() === $queries[1]['key'] &&
                $meta->monasticName->getKey() === $queries[2]['key']
            ) {
                $sql['where'] = ' OR' . substr($sql['where'], 4);
            }

            return $sql;
        };

        if ($search) {
            add_filter('get_meta_sql', $callback, 10, 6);
        }

        $query = new WP_Query(
            [
                'order'          => 'desc',
                'orderby'        => 'date',
                'paged'          => $page,
                'post_status'    => 'publish',
                'post_type'      => ROSTER_CPT_PROFILE,
                'posts_per_page' => 20,
                's'              => $search,
                'meta_query'     => [
                    'relation' => 'OR',
                    [
                        'key'     => $meta->baptismalName->getKey(),
                        'value'   => $search,
                        'compare' => 'LIKE',
                    ],
                    [
                        'key'     => $meta->currentAssignment->getKey(),
                        'value'   => $search,
                        'compare' => 'LIKE',
                    ],
                    [
                        'key'     => $meta->monasticName->getKey(),
                        'value'   => $search,
                        'compare' => 'LIKE',
                    ]
                ],
            ],
        );

        if ($search) {
            remove_filter('get_meta_sql', $callback);
        }

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
