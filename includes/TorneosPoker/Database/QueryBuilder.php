<?php

namespace TorneosPoker\Database;

class QueryBuilder
{
    protected $post_type;
    protected $args = [];

    public function __construct($post_type)
    {
        $this->post_type = $post_type;
        $this->args['post_type'] = $post_type;
    }


    public function where($key, $value, $compare = '=')
    {
        if (!isset($this->args['meta_query'])) {
            $this->args['meta_query'] = [];
        }
        $this->args['meta_query'][] = [
            'key' => $key,
            'value' => $value,
            'compare' => $compare
        ];
        return $this;
    }

    public function findUnique(string $id)
    {
        if (!isset($this->args['tax_query'])) {
            $this->args['tax_query'] = [];
        }
        
        $this->args['p'] = $id;
        return $this;
    }

    public function whereTaxonomy($taxonomy, $terms, $field = 'slug')
    {
        if (!isset($this->args['tax_query'])) {
            $this->args['tax_query'] = [];
        }
        $this->args['tax_query'][] = [
            'taxonomy' => $taxonomy,
            'field' => $field,
            'terms' => $terms
        ];
        return $this;
    }

    public function orderBy($field, $order = 'ASC')
    {
        $this->args['orderby'] = $field;
        $this->args['order'] = $order;
        return $this;
    }

    public function limit($limit)
    {
        $this->args['posts_per_page'] = $limit;
        return $this;
    }

    public function get()
    {
        return get_posts($this->args);
    }

    public function first()
    {
        $this->args['posts_per_page'] = 1;
        $results = get_posts($this->args);
        return !empty($results) ? $results[0] : null;
    }
}
