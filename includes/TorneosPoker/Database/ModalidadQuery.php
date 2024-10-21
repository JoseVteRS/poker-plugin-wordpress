<?php

namespace TorneosPoker\Database;

class ModalidadQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct('modalidad');
    }

    public function get_all()
    {
        return $this->get();
    }

    public function get_by_id(string $id)
    {
        return $this->findUnique($id)->get();
    }

    public function whereBuyinGreaterThan($buyin)
    {
        return $this->where('_modalidad_buyin', $buyin, '>');
    }

    public function whereBuyinLowerThan($buyin)
    {
        return  $this->where('_modalidad_buyin', $buyin, '<');
    }
}
