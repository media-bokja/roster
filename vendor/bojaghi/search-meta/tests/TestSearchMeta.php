<?php

namespace Bojaghi\SearchMeta\Tests;

use Bojaghi\SearchMeta\SearchMeta;
use WP_Query;
use WP_UnitTestCase;

class TestSearchMeta extends WP_UnitTestCase
{
    public function test_SearchMeta_LIKE(): void
    {
        new SearchMeta();

        /**
         * Post #1
         * -------
         * custom_field_1 = 'my test keyword 1'
         * custom_field_2 = 'my test 1'
         * custom_field_3 = 'x'
         * custom_field_4 = 'y'
         * -------
         * Therefore, this post should be found.
         */
        $id1 = $this->factory()->post->create(
            [
                'post_title'   => 'Post 1',
                'post_content' => '',
                'post_excerpt' => '',
                'post_type'    => 'post',
                'post-status'  => 'publish',
            ],
        );
        add_post_meta($id1, 'custom_field_1', 'my test keyword 1');
        add_post_meta($id1, 'custom_field_2', 'my test 1');
        add_post_meta($id1, 'custom_field_3', 'x');
        add_post_meta($id1, 'custom_field_4', 'y');

        /**
         * Post #2
         * -------
         * custom_field_1 = 'my test 2'
         * custom_field_2 = 'test 2 keyword'
         * custom_field_3 = 'x'
         * custom_field_4 = 'y'
         * -------
         * Therefore, this post should be found.
         */
        $id2 = $this->factory()->post->create(
            [
                'post_title'   => 'Post 2',
                'post_content' => '',
                'post_excerpt' => '',
                'post_type'    => 'post',
                'post-status'  => 'publish',
            ],
        );
        add_post_meta($id2, 'custom_field_1', 'my test 2');
        add_post_meta($id2, 'custom_field_2', 'test 2 keyword');
        add_post_meta($id2, 'custom_field_3', 'x');
        add_post_meta($id2, 'custom_field_4', 'y');

        /**
         * Post #3
         * -------
         * custom_field_1 = 'my test 3'
         * custom_field_2 = 'test 3 keyword'
         * custom_field_3 = 'z'
         * custom_field_4 = 'w'
         * -------
         * Therefore, this post should not be found.
         */
        $id3 = $this->factory()->post->create(
            [
                'post_title'   => 'Post 3',
                'post_content' => '',
                'post_excerpt' => '',
                'post_type'    => 'post',
                'post-status'  => 'publish',
            ],
        );
        add_post_meta($id3, 'custom_field_1', 'my test 3');
        add_post_meta($id3, 'custom_field_2', 'test-3-keyword');
        add_post_meta($id3, 'custom_field_3', 'z');
        add_post_meta($id3, 'custom_field_4', 'w');

        $query = new WP_Query(
            [
                'orderby'     => 'ID',
                'order'       => 'ASC',
                'post_type'   => 'post',
                'post_status' => 'publish',
                's'           => 'keyword',
                'search_meta' => [
                    'custom_field_1',
                    'custom_field_2',
                ],
                'meta_query'  => [
                    'relation' => 'AND',
                    [
                        'key'   => 'custom_field_3',
                        'value' => 'x',
                    ],
                    [
                        'key'   => 'custom_field_4',
                        'value' => 'y',
                    ],
                ],
            ],
        );

        $this->assertEquals(2, $query->found_posts);
        $this->assertEquals(2, $query->post_count);
        $this->assertEquals($id1, $query->posts[0]->ID);
        $this->assertEquals($id2, $query->posts[1]->ID);

        $query = new WP_Query(
            [
                'orderby'     => 'ID',
                'order'       => 'ASC',
                'post_type'   => 'post',
                'post_status' => 'publish',
                's'           => 'test-3-keyword',
                'search_meta' => [
                    'custom_field_1',
                    ['custom_field_2', '='],
                ]],
        );

        $this->assertEquals(1, $query->found_posts);
        $this->assertEquals(1, $query->post_count);
        $this->assertEquals($id3, $query->posts[0]->ID);
    }
}
