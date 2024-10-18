<?php
namespace TorneosPoker\Taxonomies;

class PokerTaxonomies {
    public function __construct() {
        add_action('init', [$this, 'registrar_taxonomia_casino'], 0);
        add_action('init', [$this, 'registrar_taxonomia_periodicidad'], 0);
    }

    public function registrar_taxonomia_casino() {
        $labels = array(
            'name'              => _x('Casinos', 'taxonomy general name', 'torneos-poker'),
            'singular_name'     => _x('Casino', 'taxonomy singular name', 'torneos-poker'),
            'search_items'      => __('Buscar Casinos', 'torneos-poker'),
            'all_items'         => __('Todos los Casinos', 'torneos-poker'),
            'parent_item'       => __('Casino Padre', 'torneos-poker'),
            'parent_item_colon' => __('Casino Padre:', 'torneos-poker'),
            'edit_item'         => __('Editar Casino', 'torneos-poker'),
            'update_item'       => __('Actualizar Casino', 'torneos-poker'),
            'add_new_item'      => __('Añadir Nuevo Casino', 'torneos-poker'),
            'new_item_name'     => __('Nombre del Nuevo Casino', 'torneos-poker'),
            'menu_name'         => __('Casinos', 'torneos-poker'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'casino'),
        );

        register_taxonomy('casino', array('torneo', 'modalidad'), $args);
    }

    public function registrar_taxonomia_periodicidad() {
        $labels = array(
            'name'              => _x('Periodicidades', 'taxonomy general name', 'torneos-poker'),
            'singular_name'     => _x('Periodicidad', 'taxonomy singular name', 'torneos-poker'),
            'search_items'      => __('Buscar Periodicidades', 'torneos-poker'),
            'all_items'         => __('Todas las Periodicidades', 'torneos-poker'),
            'parent_item'       => __('Periodicidad Padre', 'torneos-poker'),
            'parent_item_colon' => __('Periodicidad Padre:', 'torneos-poker'),
            'edit_item'         => __('Editar Periodicidad', 'torneos-poker'),
            'update_item'       => __('Actualizar Periodicidad', 'torneos-poker'),
            'add_new_item'      => __('Añadir Nueva Periodicidad', 'torneos-poker'),
            'new_item_name'     => __('Nombre de Nueva Periodicidad', 'torneos-poker'),
            'menu_name'         => __('Periodicidades', 'torneos-poker'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'periodicidad'),
        );

        register_taxonomy('periodicidad', array('torneo', 'modalidad'), $args);
    }
}