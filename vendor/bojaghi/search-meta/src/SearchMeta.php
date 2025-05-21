<?php

namespace Bokja\Roster\Vendor\Bojaghi\SearchMeta;

use Bokja\Roster\Vendor\Bojaghi\Contract\Module;
use Bokja\Roster\Vendor\Bojaghi\Helper\Helper;
use WP_Query;

class SearchMeta implements Module
{
    private string $alias;

    private array $clause = [];

    public function __construct(string|array $args = '')
    {
        $this->setup($args);

        add_filter('posts_search', [$this, 'postsSearch'], 10, 2);
    }

    /**
     * Modify a search query
     *
     * @param string $search
     * @param WP_Query $query
     *
     * @return string
     */
    public function postsSearch(string $search, WP_Query $query): string
    {
        $keyword = $query->get('s');
        $meta    = $query->get('search_meta', []);

        if ($keyword && $meta) {
            $clause = $this->createClause((array)$meta, $keyword);

            if ($clause) {
                $search = $this->replaceSearch($search, $clause['where']);

                $this->clause = $clause;
                add_filter('posts_join', [$this, 'replaceJoin'], 10, 2);
                add_filter('posts_groupby', [$this, 'replaceGroupBy'], 10, 2);
            }
        }

        return $search;
    }

    /**
     * @param array $meta
     * @param string $search
     *
     * @return array{where: string, join: string}
     */
    public function createClause(array $meta, string $search): array
    {
        global $wpdb;

        $buffer = [];

        foreach ($meta as $item) {
            if (is_array($item) && 2 === count($item)) {
                $field    = trim($item[0]);
                $operator = trim($item[1]);
            } elseif (is_string($item)) {
                $field    = trim($item);
                $operator = 'LIKE';
            }

            if (!isset($field, $operator)) {
                continue;
            }

            $tmpl = "$this->alias.meta_key=%s AND $this->alias.meta_value";

            switch ($operator) {
                case 'LIKE':
                case 'NOT LIKE':
                    if (preg_match_all('/([^\s"]+)\s|\s([^\s"]+)|"(.+?)"/', $search, $match, PREG_SET_ORDER)) {
                        foreach ($match as $m) {
                            $word = array_pop($m);
                            $buffer[] = $wpdb->prepare("($tmpl $operator '%%%s%%')", $field, $wpdb->esc_like($word));
                        }
                    } else {
                        $buffer[] = $wpdb->prepare("($tmpl $operator '%%%s%%')", $field, $wpdb->esc_like($search));
                    }
                    break;
                case '=':
                case '!=':
                case '>':
                case '>=':
                case '<':
                case '<=':
                    $buffer[] = $wpdb->prepare("($tmpl $operator %s)", $field, $search);
                    break;
            }
        }

        return [
            'join'  => $buffer ? " INNER JOIN $wpdb->postmeta AS $this->alias ON $wpdb->posts.ID = $this->alias.post_id" : '',
            'where' => $buffer ? implode(' OR ', $buffer) : '',
        ];
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
        remove_filter('posts_join', [$this, 'replaceJoin']);

        if ($this->clause['join']) {
            $join .= $this->clause['join'];
        }

        return $join;
    }

    private function replaceSearch(string $search, string $where): string
    {
        global $wpdb;

        $replaced = '';

        if (preg_match_all("/$wpdb->posts\.(?:post_title|post_excerpt|post_content) R?LIKE '\{[a-z0-9]{64}}.+?\{[a-z0-9]{64}}'/", $search, $matches)) {
            $replaced .= implode(' OR ', array_map(fn($m) => "($m)", $matches[0]));
        }

        if ($where) {
            $replaced .= " OR $where";
        }

        if ($replaced) {
            return "AND ($replaced)";
        }

        return $search;
    }

    private function setup(string|array $args): void
    {
        $default = [
            'postmeta_alias' => '_smeta',
        ];

        $args = wp_parse_args(Helper::loadConfig($args), $default);

        if (!$args['postmeta_alias']) {
            $args['postmeta_alias'] = $default['postmeta_alias'];
        }

        $this->alias = $args['postmeta_alias'];
    }
}
