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
                            return in_array($param, ['birthday', 'date', 'entrance', 'name']) ? $param : 'entrance';
                        },
                        'validate_callback' => function ($param) {
                            return in_array($param, ['birthday', 'date', 'entrance', 'name']);
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
                    'perpage' => [
                        'sanitize_callback' => function ($param) {
                            $param = absint($param);
                            return in_array($param, [25, 50, 100], true) ? $param : 50;
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

        $order   = $request->get_param('order');
        $orderby = $request->get_param('orderby');
        $page    = $request->get_param('page');
        $perPage = $request->get_param('perpage');
        $search  = $request->get_param('search');

        $args = [
            'order'          => $order,
            'paged'          => $page,
            'post_status'    => 'publish',
            'post_type'      => ROSTER_CPT_PROFILE,
            'posts_per_page' => $perPage,
            's'              => $search,
            'search_columns' => ['post_title'],
            'search_meta'    => [
                $meta->baptismalName->getKey(),
                $meta->currentAssignment->getKey(),
                $meta->monasticName->getKey()
            ],
        ];

        // Set orderby param
        switch ($orderby) {
            case 'birthday':
                $args['orderby']   = 'meta_value';
                $args['meta_key']  = $meta->birthday->getKey();
                $args['meta_type'] = 'DATE';
                break;

            case 'entrance':
                $args['orderby']   = 'meta_value';
                $args['meta_key']  = $meta->entranceDate->getKey();
                $args['meta_type'] = 'DATE';
                break;

            case 'date':
                $args['orderby'] = 'date';
                break;

            case 'name':
                $args['orderby'] = 'title';
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
