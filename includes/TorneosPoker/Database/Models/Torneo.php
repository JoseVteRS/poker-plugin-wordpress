<?php

namespace TorneosPoker\Models;

class Torneo
{
    protected $id;
    protected $nombre;
    protected $fecha;
    protected $ubicacion;

    public function __construct($id, $nombre, $fecha, $ubicacion)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->fecha = $fecha;
        $this->ubicacion = $ubicacion;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getUbicacion()
    {
        return $this->ubicacion;
    }
}
