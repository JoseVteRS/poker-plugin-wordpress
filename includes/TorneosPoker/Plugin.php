<?php
namespace TorneosPoker;

class Plugin {
    private $cargadores = [];

    public function __construct() {
        $this->cargar_dependencias();
        $this->definir_hooks();
    }

    private function cargar_dependencias() {
        $this->cargadores['torneos'] = new PostTypes\Torneo();
        $this->cargadores['modalidades'] = new PostTypes\Modalidad();
        // Aquí puedes añadir más cargadores para otros CPTs o funcionalidades
    }

    private function definir_hooks() {
        add_action('init', [$this->cargadores['torneos'], 'registrar']);
        add_action('init', [$this->cargadores['modalidades'], 'registrar']);
        add_action('admin_menu', [$this, 'agregar_menu_poker']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_styles']);
    }

    public function agregar_menu_poker() {
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
        $this->agregar_submenu('poker_menu', 'Torneos', 'edit.php?post_type=torneo');
        $this->agregar_submenu('poker_menu', 'Modalidades', 'edit.php?post_type=modalidad');
        $this->agregar_submenu('poker_menu', 'Casinos', 'edit.php?post_type=casino');
        $this->agregar_submenu('poker_menu', 'Periodicidad', 'edit-tags.php?taxonomy=periodicidad&post_type=torneo');
        $this->agregar_submenu('poker_menu', 'Tipo', 'edit-tags.php?taxonomy=tipo&post_type=modalidad');

        // Remover submenús duplicados
        $this->remover_submenu_duplicado('torneo');
        $this->remover_submenu_duplicado('modalidad');
        $this->remover_submenu_duplicado('casino');
    }

    private function agregar_submenu($menu_padre, $titulo, $slug) {
        add_submenu_page(
            $menu_padre,
            __($titulo, 'torneos-poker'),
            __($titulo, 'torneos-poker'),
            'manage_options',
            $slug
        );
    }

    private function remover_submenu_duplicado($post_type) {
        remove_submenu_page("edit.php?post_type={$post_type}", "edit.php?post_type={$post_type}");
    }

    public function enqueue_admin_styles() {
        wp_enqueue_style('torneo-admin-style', plugin_dir_url(__FILE__) . '../../assets/css/admin-style.css');
    }

    public function run() {
        // Aquí puedes agregar más acciones si es necesario
    }
}