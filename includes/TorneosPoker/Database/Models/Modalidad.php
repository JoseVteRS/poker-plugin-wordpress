<?php

namespace TorneosPoker\Models;

use WP_Post;

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

    public function __construct($id, $name, $color, $buyin, $bounty, $puntos, $mas_info, $mostrar)
    {
        $this->id = $id;
        $this->name = $name;
        $this->color = $color;
        $this->buyin = $buyin;
        $this->bounty = $bounty;
        $this->puntos = $puntos;
        $this->mas_info = $mas_info;
        $this->mostrar = $mostrar;
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

    public function get_thumbnail(string $size = 'thumbnail')
    {
        return get_the_post_thumbnail($this->get_id(), $size);
    }

    public function get_thumbnail_url(string $size = 'thumbnail')
    {
        return get_the_post_thumbnail_url($this->get_id(), $size);
    }
}
