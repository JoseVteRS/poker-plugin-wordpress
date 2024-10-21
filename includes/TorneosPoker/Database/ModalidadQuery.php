<?php

namespace TorneosPoker\Database;

use TorneosPoker\Models\Modalidad;

require_once POKER_PLUGIN_DIR . 'includes/TorneosPoker/Database/Models/Modalidad.php';

class ModalidadQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct('modalidad');
    }

    public function getAll()
    {
        $results = $this->get();
        return $this->mapResultsToModels($results);
    }

    public function getById(string $id)
    {
        $result = $this->findUnique($id)->first();
        return $result ? $this->mapResultToModel($result) : null;
    }

    public function whereBuyinGreaterThan($buyin)
    {
        return $this->where('_modalidad_buyin', $buyin, '>');
    }

    public function whereBuyinLowerThan($buyin)
    {
        return $this->where('_modalidad_buyin', $buyin, '<');
    }

    // Método para mapear resultados de la base de datos a modelos Modalidad
    protected function mapResultsToModels($results)
    {
        $modalidades = [];
        foreach ($results as $data) {
            $modalidades[] = $this->mapResultToModel($data);
        }
        return $modalidades;
    }

    // Método para mapear un solo resultado a un modelo Modalidad
    protected function mapResultToModel($post, string $size = 'thumbnail'): null|Modalidad
    {
        if (!$post instanceof \WP_Post) {
            return null;
        }

        return new Modalidad(
            $post->ID,
            $post->post_title,
            get_post_meta($post->ID, '_modalidad_color', true) ?? "",
            get_post_meta($post->ID, '_modalidad_buyin', true) ?? "",
            get_post_meta($post->ID, '_modalidad_bounty', true) ?? "",
            get_post_meta($post->ID, '_modalidad_puntos', true) ?? "",
            get_post_meta($post->ID, '_modalidad_mas_info', true) ?? "",
            get_post_meta($post->ID, '_modalidad_mostrar', true) ?? "",

        );
    }
}
