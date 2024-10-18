<?php

namespace TorneosPoker\Database;

class ModalidadQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct('modalidad');
    }

    public function whereBuyinGreaterThan($buyin)
    {
        return $this->where('_modalidad_buyin', $buyin, '>');
    }

    public function whereBuyinLowerThan($buyin)
    {
        return $this->where('_modalidad_buyin', $buyin, '<');
    }

    // Puedes añadir más métodos específicos para Modalidad aquí
}
