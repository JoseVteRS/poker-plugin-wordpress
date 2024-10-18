<?php
namespace TorneosPoker\Database;

class TorneoQuery extends QueryBuilder {
    public function __construct() {
        parent::__construct('torneo');
    }

    public function getAll() {
        return $this->get();
    }

    public function whereModalidad($modalidad_id) {
        return $this->where('_torneo_modalidad_id', $modalidad_id);
    }

    public function whereDate($date, $compare = '=') {
        return $this->where('_torneo_fecha', $date, $compare);
    }

    // Puedes añadir más métodos específicos para Torneo aquí
}