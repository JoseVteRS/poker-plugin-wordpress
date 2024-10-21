<?php

namespace TorneosPoker\Repositories;

use TorneosPoker\Models\Modalidad;
use TorneosPoker\Database\ModalidadQuery;
use WP_Post;

require_once POKER_PLUGIN_DIR . 'includes/TorneosPoker/Database/Models/Modalidad.php';

class ModalidadRepository
{
    protected $query;

    public function __construct()
    {
        $this->query = new ModalidadQuery();
    }

    public function get_all()
    {
        $results = $this->query->get_all();
        return $this->mapResultsToModels($results);
    }

    public function findById(string $id)
    {
        $result = $this->query->get_by_id($id);
        return $result ? $this->mapResultToModel($result[0]) : null;
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

    protected function mapResultToModel(WP_Post $post): Modalidad
    {
        return new Modalidad(
            $post->ID,
            $post->post_title,
            get_post_meta($post->ID, '_modalidad_color', true) ?? "",
            get_post_meta($post->ID, '_modalidad_buyin', true) ?? "",
            get_post_meta($post->ID, '_modalidad_bounty', true) ?? "",
            get_post_meta($post->ID, '_modalidad_puntos', true) ?? "",
            get_post_meta($post->ID, '_modalidad_mas_info', true) ?? "",
            get_post_meta($post->ID, '_modalidad_mostrar', true) ?? "",
            get_the_post_thumbnail($post->ID, 'thumbnail'),
            get_the_post_thumbnail_url($post->ID, 'thumbnail'),
        );
    }
}
