<?php

namespace TorneosPoker\Models;

class Torneo
{
    protected $id;
    protected $permalink;
    protected $name;
    protected $date;
    protected $buyin;
    protected $bounty;
    protected $puntos;
    protected $modalidad_id;
    protected $producto_id;
    protected $periodicidad;
    protected $casino;
    protected $more_info;
    protected $update_info;
    protected $is_visible_in_front;
    protected $is_visible_update_info;

    public function __construct(
        $id,
        $permalink,
        $name,
        $date,
        $buyin,
        $bounty,
        $puntos,
        $modalidad_id,
        $producto_id,
        $periodicidad,
        $casino,
        $more_info = null,
        $update_info = null,
        $is_visible_in_front = true,
        $is_visible_update_info = true
    ) {
        $this->id = $id;
        $this->permalink = $permalink;
        $this->name = $name;
        $this->date = $date;
        $this->buyin = $buyin;
        $this->bounty = $bounty;
        $this->puntos = $puntos;
        $this->modalidad_id = $modalidad_id;
        $this->producto_id = $producto_id;
        $this->periodicidad = $periodicidad;
        $this->casino = $casino;
        $this->more_info = $more_info;
        $this->update_info = $update_info;
        $this->is_visible_in_front = $is_visible_in_front;
        $this->is_visible_update_info = $is_visible_update_info;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_permalink()
    {
        return $this->permalink;
    }

    public function get_name()
    {
        return $this->name;
    }

    public function get_date()
    {
        return $this->date;
    }

    public function get_buyin()
    {
        return $this->buyin;
    }

    public function get_bounty()
    {
        return $this->bounty;
    }

    public function get_puntos()
    {
        return $this->puntos;
    }

    public function get_modalidad_id()
    {
        return $this->modalidad_id;
    }

    public function get_producto_id()
    {
        return $this->producto_id;
    }

    public function get_periodicidad()
    {
        return $this->periodicidad;
    }

    public function get_casino()
    {
        return $this->casino;
    }

    public function get_more_info()
    {
        return $this->more_info;
    }

    public function get_update_info()
    {
        return $this->update_info;
    }

    public function is_visible_in_front()
    {
        return $this->is_visible_in_front;
    }

    public function is_visible_update_info()
    {
        return $this->is_visible_update_info;
    }
}