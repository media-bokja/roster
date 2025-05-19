<?php

namespace Bokja\Roster\Modules;

use Bokja\Roster\Vendor\Bojaghi\Contract\Module;
use WP_Meta_Query;
use WP_Query;

/**
 * Let WP_Qeury search for custom fields with 's' parameter value.
 *
 * Provide 'meta_search', just like 'meta_query'
 */
class SearchMeta implements Module
{
    private array $clause = [];

    private string $alias;

    public function __construct(string $alias = '_ms')
    {
        $this->alias = $alias;

        add_filter('posts_search', [$this, 'postsSearch'], 10, 2);
    }

    public function postsSearch(string $search, WP_Query $query): string
    {
        global $wpdb;

        $metaSearch = $query->get('meta_search', []);

        if (empty($search) || empty($metaSearch)) {
            return $search;
        }

        $meta = new WP_Meta_Query();
        $meta->parse_query_vars(['meta_query' => $metaSearch]);

        $clause = $meta->get_sql('post', $wpdb->posts, 'ID', $query);
        if ($clause) {
            add_filter('posts_join', [$this, 'replaceJoin'], 10, 2);
            add_filter('posts_groupby', [$this, 'replaceGroupBy'], 10, 2);

            $this->clause = $clause;
            $search       = $this->replaceSearch($search, $clause['where']);
        }

        return $search;
    }

    public function replaceGroupBy(string $groupby): string
    {
        global $wpdb;

        remove_filter('posts_groupby', [$this, 'replaceGroupBy']);

        if (empty($groupby)) {
            $groupby = "$wpdb->posts.ID";
        }

        return $groupby;
    }

    public function replaceJoin(string $join): string
    {
        global $wpdb;

        remove_filter('posts_join', [$this, 'replaceJoin']);

        if ($this->clause) {
            // Use alias
            $join .= str_replace(
                search: ["$wpdb->postmeta ON", "$wpdb->postmeta.post_id"],
                replace: ["$wpdb->postmeta AS $this->alias ON", "$this->alias.post_id"],
                subject: $this->clause['join'],
            );
        }

        return $join;
    }

    private function replaceSearch(string $search, string $where): string
    {
        global $wpdb;

        /**
         * Sample of $search:
         * AND (((wp_posts.post_title LIKE '%keyword%') OR (wp_posts.post_excerpt LIKE '%keyword%') OR (wp_posts.post_content LIKE '%keyword%')))
         *
         * Sample of $where:
         * AND (
         * ( wp_postmeta.meta_key = 'roster_baptismal_name' AND wp_postmeta.meta_value LIKE '%keyword%' )
         * OR
         * ( wp_postmeta.meta_key = 'roster_current_assignment' AND wp_postmeta.meta_value LIKE '%keyword%' )
         * OR
         * ( wp_postmeta.meta_key = 'roster_monastic_name' AND wp_postmeta.meta_value LIKE '%keyword%' )
         */

        $replaced = '';

        if (preg_match_all("/$wpdb->posts\.(?:post_title|post_excerpt|post_content) R?LIKE '\{[a-z0-9]{64}}.+?\{[a-z0-9]{64}}'/", $search, $matches)) {
            $replaced .= implode(' OR ', array_map(fn($m) => "($m)", $matches[0]));
        }

        if (preg_match_all("/\( ($wpdb->postmeta.meta_key =.+)\)/", $where, $matches)) {
            if ($replaced) {
                $replaced .= ' OR ';
            }
            $replaced .= implode(
                ' OR ',
                array_map(
                    // Use alias
                    fn($m) => '(' . str_replace(
                            ["$wpdb->postmeta.meta_key", "$wpdb->postmeta.meta_value"],
                            ["$this->alias.meta_key", "$this->alias.meta_value"], $m,
                        ) . ')',
                    $matches[1],
                ),
            );
        }

        if ($replaced) {
            return "AND ($replaced)";
        }

        return $search;
    }
}
