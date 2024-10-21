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

    public function whereDate($key, $operator, $value)
{
    // Asegúrate de que el valor de la fecha esté en el formato correcto
    $formattedDate = date('Y-m-d', strtotime($value));

    if (!isset($this->args['meta_query'])) {
        $this->args['meta_query'] = [];
    }
    $this->args['meta_query'][] = [
        'key' => $key,
        'value' => $formattedDate,
        'compare' => $operator,
        'type' => 'DATE' // Especifica que el tipo es DATE para comparaciones de fecha
    ];
    return $this;
}

    public function findUnique(string $id)
    {
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

    public function count()
    {
        $this->args['fields'] = 'ids';
        $query = new \WP_Query($this->args);
        return $query->found_posts;
    }

    public function delete($id)
    {
        if (!current_user_can('delete_post', $id)) {
            return false;
        }
        return wp_delete_post($id, true);
    }

    public function update($id, $data)
    {
        $post_data = array_merge(['ID' => $id], $data);
        return wp_update_post($post_data);
    }

    public function rawQuery($sql)
    {
        global $wpdb;
        $prepared_sql = $wpdb->prepare($sql);
        return $wpdb->get_results($prepared_sql);
    }
}
