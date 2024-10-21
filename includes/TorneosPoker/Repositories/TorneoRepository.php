<?php

namespace TorneosPoker\Repositories;

use TorneosPoker\Models\Torneo;
use TorneosPoker\Database\TorneoQuery;

require_once POKER_PLUGIN_DIR . 'includes/TorneosPoker/Database/Models/Torneo.php';

class TorneoRepository
{
    protected $query;

    public function __construct()
    {
        $this->query = new TorneoQuery();
    }

    public function get_all()
    {
        $results = $this->query->getAll();
        return $this->mapResultsToModels($results);
    }

    public function get_by_id($id)
    {
        $result = $this->query->where('id', $id)->first();
        return $result ? $this->mapResultToModel($result) : null;
    }

    public function get_by_casino($casino)
    {
        $results = $this->query->where('casino', $casino)->get();
        return $this->mapResultsToModels($results);
    }

    public function get_by_modalidad_slug(string $modalidad_slug)
    {
        $results = $this->query->where('name', $modalidad_slug)->get();
        return $this->mapResultsToModels($results);
    }


    public function get_by_date_range($start_date, $end_date)
    {
        $results = $this->query
            ->whereDate($start_date, '>=')
            ->whereDate($end_date, '<=')
            ->get();
        return $this->mapResultsToModels($results);
    }

    // Método para mapear resultados de la base de datos a modelos Torneo
    protected function mapResultsToModels($results)
    {
        $torneos = [];
        foreach ($results as $data) {
            $torneos[] = $this->mapResultToModel($data);
        }
        return $torneos;
    }

    // Método para mapear un solo resultado a un modelo Torneo
    protected function mapResultToModel($post): Torneo
    {
        // Asegúrate de que $post es un objeto WP_Post
        if (!$post instanceof \WP_Post) {
            return null;
        }

        // Obtener el nombre del torneo desde el post_title
        $name = $post->post_title;

        // Obtener la taxonomía 'casino'
        $casino_terms = wp_get_post_terms($post->ID, 'casino');
        $casino = !empty($casino_terms) ? $casino_terms[0]->name : '';

        $periodicidad_terms = wp_get_post_terms($post->ID, 'periodicidad');
        $periodicidad = !empty($periodicidad_terms) ? $periodicidad_terms[0]->name : '';

        // Obtener el permalink
        $permalink = get_permalink($post->ID);

        return new Torneo(
            $post->ID,
            $permalink,
            $name,
            get_post_meta($post->ID, '_torneo_fecha', true),
            get_post_meta($post->ID, '_torneo_buyin', true),
            get_post_meta($post->ID, '_torneo_bounty', true),
            get_post_meta($post->ID, '_torneo_puntos', true),
            get_post_meta($post->ID, '_torneo_modalidad_id', true),
            get_post_meta($post->ID, '_torneo_producto_id', true),
            $periodicidad,
            $casino,
            get_post_meta($post->ID, '_torneo_mas_info', true),
            get_post_meta($post->ID, '_torneo_actualizacion', true),
            get_post_meta($post->ID, '_torneo_mostrar_frontend', true),
            get_post_meta($post->ID, '_torneo_mostrar_actualizacion', true)
        );
    }

    // Puedes añadir más métodos específicos para Torneo aquí
}
