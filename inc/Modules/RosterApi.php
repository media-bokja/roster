<?php

namespace Bokja\Roster\Modules;

use Bokja\Roster\Objects\Profile;
use Bokja\Roster\Vendor\Bojaghi\Contract\Module;
use WP_Query;
use WP_REST_Request;

use function Bokja\Roster\Facades\rosterGet;

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
                'args'                => [
                    'order'   => [
                        'sanitize_callback' => function ($param) {
                            return 'desc' === strtolower($param) ? 'desc' : 'asc';
                        },
                        'validate_callback' => function ($param) {
                            return in_array(strtolower($param), ['asc', 'desc']);
                        },
                    ],
                    'orderby' => [
                        'sanitize_callback' => function ($param) {
                            $param = sanitize_key(strtolower($param));
                            return in_array($param, ['birthday', 'date', 'name']) ? $param : 'date';
                        },
                        'validate_callback' => function ($param) {
                            return in_array($param, ['birthday', 'date', 'name']);
                        },
                    ],
                    'page'    => [
                        'sanitize_callback' => function ($param) {
                            return max(1, absint($param));
                        },
                        'validate_callback' => function ($param) {
                            return is_numeric($param);
                        },
                    ],
                    'search'  => [
                        'sanitize_callback' => function ($param) {
                            return sanitize_text_field($param);
                        },
                    ],
                ],
            ],
        );
    }

    public function query(WP_REST_Request $request): array
    {
        $meta = rosterGet(PostMeta::class);

        $order   = $request->get_param('order') ?? 'desc';
        $orderby = $request->get_param('orderby') ?? 'date';
        $page    = $request->get_param('page');
        $search  = $request->get_param('search');

        $args = [
            'meta_search'    => [],
            'order'          => $order,
            'orderby'        => $orderby,
            'paged'          => $page,
            'post_status'    => 'publish',
            'post_type'      => ROSTER_CPT_PROFILE,
            'posts_per_page' => 20,
            's'              => $search,
            'search_columns' => ['post_title'],
        ];

        if ($search) {
            $args['meta_search'] = [
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
                ],
            ];
        }

        switch ($orderby) {
            case 'birthday':
                $args['orderby']   = 'meta_value';
                $args['meta_key']  = $meta->birthday->getKey();
                $args['meta_type'] = 'DATE';
                break;

            case 'date':
                $args['orderby']   = 'date';
                break;

            case 'name':
                $args['orderby']   = 'title';
                break;
        }

        $query = new WP_Query($args);

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
