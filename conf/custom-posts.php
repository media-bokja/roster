<?php

if (!defined('ABSPATH')) {
    exit;
}

const ROSTER_CPT_PROFILE = 'roster_profile';

return [
    // Begin: roster_profile
    [
        // post_type
        ROSTER_CPT_PROFILE,
        // arguments
        [
            'label'                           => __('회원명부', 'roster'),
            'labels'                          => [
                'name'                     => _x('회원명부', 'roster_profile label name', 'roster'),
                'singular_name'            => _x('회원명부', 'roster_profile label singular_name', 'roster'),
                'add_new'                  => _x('새로 추가', 'roster_profile label', 'roster'),
                'add_new_item'             => _x('새 명부 추가', 'roster_profile label', 'roster'),
                'edit_item'                => _x('명부 수정', 'roster_profile label', 'roster'),
                'new_item'                 => _x('새 명부', 'roster_profile label', 'roster'),
                'view_item'                => _x('명부 보기', 'roster_profile label', 'roster'),
                'view_items'               => _x('명부 보기', 'roster_profile label', 'roster'),
                'search_items'             => _x('명부 찾기', 'roster_profile label', 'roster'),
                'not_found'                => _x('찾을 수 없음', 'roster_profile label', 'roster'),
                'not_found_in_trash'       => _x('휴지통에서 찾을 수 없음', 'roster_profile label', 'roster'),
                'parent_item_colon'        => _x('', 'roster_profile label', 'roster'),
                'all_items'                => _x('모든 명부', 'roster_profile label', 'roster'),
                'archives'                 => _x('', 'roster_profile label', 'roster'),
                'attributes'               => _x('속성', 'roster_profile label', 'roster'),
                'insert_into_item'         => _x('', 'roster_profile label', 'roster'),
                'uploaded_to_this_item'    => _x('', 'roster_profile label', 'roster'),
                'featured_image'           => _x('', 'roster_profile label', 'roster'),
                'set_featured_image'       => _x('', 'roster_profile label', 'roster'),
                'remove_featured_image'    => _x('', 'roster_profile label', 'roster'),
                'use_featured_image'       => _x('', 'roster_profile label', 'roster'),
                'menu_name'                => _x('회원명부', 'roster_profile label', 'roster'),
                'filter_items_list'        => _x('회원명부 목록 필터', 'roster_profile label', 'roster'),
                'filter_by_date'           => _x('날짜로 필터', 'roster_profile label', 'roster'),
                'items_list_navigation'    => _x('', 'roster_profile label', 'roster'),
                'items_list'               => _x('회원명부 목록', 'roster_profile label', 'roster'),
                'item_published'           => _x('회원명부 저장됨', 'roster_profile label', 'roster'),
                'item_published_privately' => _x('', 'roster_profile label', 'roster'),
                'item_reverted_to_draft'   => _x('', 'roster_profile label', 'roster'),
                'item_trashed'             => _x('회원명부 삭제됨', 'roster_profile label', 'roster'),
                'item_scheduled'           => _x('', 'roster_profile label', 'roster'),
                'item_updated'             => _x('회원명부 갱신됨', 'roster_profile label', 'roster'),
                'item_link'                => _x('', 'roster_profile label', 'roster'),
                'item_link_description'    => _x('', 'roster_profile label', 'roster'),
            ],
            'description'                     => _x('회원명부 포스트 타입', 'Description of roster_profile', 'roster'),
            'public'                          => false,
            'hierarchical'                    => false,
            'exclude_from_search'             => true,
            'publicly_queryable'              => false,
            'show_ui'                         => true,
            'show_in_menu'                    => true,
            'show_in_nav_menus'               => false,
            'show_in_admin_bar'               => false,
            'show_in_rest'                    => false,
            'rest_base'                       => 'roster',
            'rest_namespace'                  => 'wp/v2',
            'rest_controller_class'           => \WP_REST_Posts_Controller::class,
            'autosave_rest_controller_class'  => \WP_REST_Autosaves_Controller::class,
            'revisions_rest_controller_class' => \WP_Rest_Revisions_Controller::class,
            'late_route_registration'         => false,
            'menu_position'                   => null,
            'menu_icon'                       => 'dashicons-groups',
            'capability_type'                 => 'post',
            'map_meta_cap'                    => true,
            'supports'                        => false,
            'register_meta_box_cb'            => null,
            'taxonomies'                      => [],
            'has_archive'                     => false,
            'rewrite'                         => [
                'slug'       => '',
                'with_front' => false,
                'feeds'      => false,
                'pages'      => false,
                'ep_mask'    => EP_PERMALINK,
            ],
            'query_var'                       => false,
            'can_export'                      => true,
            'delete_with_user'                => null,
            'template'                        => [],
            'template_lock'                   => false,
        ],
    ],
    // End: ttp_threads
];
