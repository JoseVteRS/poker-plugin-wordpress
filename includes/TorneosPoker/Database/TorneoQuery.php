<?php

namespace TorneosPoker\Database;

use TorneosPoker\Models\Torneo;

require_once POKER_PLUGIN_DIR . 'includes/TorneosPoker/Database/Models/Torneo.php';

class TorneoQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct('torneo');
    }

    public function getAll()
    {
        $results = $this->get();
        return $this->mapResultsToModels($results);
    }

    public function getById($id)
    {
        $result = $this->where('id', $id)->first();
        return $result ? $this->mapResultToModel($result) : null;
    }

    public function test()
    {
        $results = $this
            ->whereTaxonomy('casino', 'Benidorm')
            ->orderBy('_torneo_fecha', 'DESC')
            ->limit(10)
            ->get();
        return $this->mapResultsToModels($results);
    }

    public function getByCasino($casino)
    {
        $results = $this->whereTaxonomy('casino', $casino)->get();
        return $this->mapResultsToModels($results);
    }

    public function getByPeriodicidad($periodicidad)
    {
        $results = $this->whereTaxonomy('periodicidad', $periodicidad)->get();
        return $this->mapResultsToModels($results);
    }

    public function getByModalidad($modalidad)
    {
        $results = $this->where('_torneo_modalidad_id', $modalidad)->get();
        return $this->mapResultsToModels($results);
    }

    public function getByDateRange($start_date, $end_date)
    {
        $results = $this
            ->whereDate('_torneo_fecha', '>=', $start_date)
            ->whereDate('_torneo_fecha', '<=', $end_date)
            ->get();
        return $this->mapResultsToModels($results);
    }

    public function getByDateFromToday()
    {
        $today = date('Y-m-d');
        $results = $this->whereDate('_torneo_fecha', '>=', $today)->get();
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
        if (!$post instanceof \WP_Post) {
            return null;
        }

        $name = $post->post_title;
        $casino_terms = wp_get_post_terms($post->ID, 'casino');
        $casino = !empty($casino_terms) ? $casino_terms[0]->name : '';

        $periodicidad_terms = wp_get_post_terms($post->ID, 'periodicidad');
        $periodicidad = !empty($periodicidad_terms) ? $periodicidad_terms[0]->name : '';

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
