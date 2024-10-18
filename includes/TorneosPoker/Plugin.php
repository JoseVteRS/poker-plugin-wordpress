<?php

namespace TorneosPoker;

use TorneosPoker\PostTypes\Torneo;
use TorneosPoker\PostTypes\Modalidad;
use TorneosPoker\Taxonomies\PokerTaxonomies;
use TorneosPoker\Database\TorneoQuery;
use TorneosPoker\Database\ModalidadQuery;
use TorneosPoker\Shortcodes;

class Plugin
{
    private $cargadores = [];

    public function __construct()
    {
        $this->cargar_dependencias();
        $this->definir_hooks();
    }

    private function cargar_dependencias()
    {
        $this->cargadores['torneos'] = new Torneo();
        $this->cargadores['modalidades'] = new Modalidad();
        $this->cargadores['poker_taxonomies'] = new PokerTaxonomies();
        $this->cargadores['shortcodes'] = new Shortcodes();
        // Aquí puedes añadir más cargadores para otros CPTs o funcionalidades
    }

    private function definir_hooks()
    {
        add_action('init', [$this->cargadores['torneos'], 'registrar']);
        add_action('init', [$this->cargadores['modalidades'], 'registrar']);
        add_action('admin_menu', [$this, 'agregar_menu_poker']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_styles']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_styles']);
    }

    public function agregar_menu_poker()
    {
        // Menú principal
        add_menu_page(
            __('Poker', 'torneos-poker'),
            __('Poker', 'torneos-poker'),
            'manage_options',
            'poker_menu',
            '',
            'dashicons-games',
            25
        );

        // Submenús
        $this->agregar_submenu('poker_menu', 'TORNEOS', 'edit.php?post_type=torneo');
        $this->agregar_submenu('poker_menu', 'MODALIDADES', 'edit.php?post_type=modalidad');
        $this->agregar_submenu('poker_menu', 'Casinos', 'edit-tags.php?taxonomy=casino');
        $this->agregar_submenu('poker_menu', 'Periodicidad', 'edit-tags.php?taxonomy=periodicidad');

        // Remover submenús duplicados
        $this->remover_submenu_duplicado('torneo');
        $this->remover_submenu_duplicado('modalidad');
        $this->remover_submenu_duplicado('casino');
    }

    private function agregar_submenu($menu_padre, $titulo, $slug)
    {
        add_submenu_page(
            $menu_padre,
            __($titulo, 'torneos-poker'),
            __($titulo, 'torneos-poker'),
            'manage_options',
            $slug
        );
    }

    private function remover_submenu_duplicado($post_type)
    {
        remove_submenu_page("edit.php?post_type={$post_type}", "edit.php?post_type={$post_type}");
    }

    public function enqueue_admin_styles()
    {
        wp_enqueue_style('torneo-admin-style', plugin_dir_url(__FILE__) . '../../assets/css/admin-style.css');
    }

    public function enqueue_frontend_styles() {
        wp_enqueue_style('torneos-poker-frontend', plugin_dir_url(__FILE__) . '../../assets/css/frontend-style.css');
    }

    public function run()
    {
        // Aquí puedes agregar más acciones si es necesario
    }
}
