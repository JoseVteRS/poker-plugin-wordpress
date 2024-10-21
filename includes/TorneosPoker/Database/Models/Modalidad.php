<?php

namespace TorneosPoker\Models;

class Modalidad
{
    protected $id;
    protected $name;
    protected $thumbnail;
    protected $thumbnail_url;
    protected $color;
    protected $buyin;
    protected $bounty;
    protected $puntos;
    protected $mas_info;
    protected $mostrar;

    public function __construct($id, $name, $color, $buyin, $bounty, $puntos, $mas_info, $mostrar, $thumbnail, $thumbnail_url)
    {
        $this->id = $id;
        $this->name = $name;
        $this->color = $color;
        $this->buyin = $buyin;
        $this->bounty = $bounty;
        $this->puntos = $puntos;
        $this->mas_info = $mas_info;
        $this->mostrar = $mostrar;
        $this->thumbnail = $thumbnail;
        $this->thumbnail_url = $thumbnail_url;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_name()
    {
        return $this->name;
    }

    public function get_color()
    {
        return $this->color;
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

    public function get_mas_info()
    {
        return $this->mas_info;
    }

    public function is_visible_in_front()
    {
        return $this->mostrar === 'on';
    }

    public function get_thumbnail()
    {
        return $this->thumbnail;
    }

    public function get_thumbnail_url()
    {
        return $this->thumbnail_url;
    }
}
