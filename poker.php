<?php

/**
 * Plugin Name: Gestor de Torneos de Poker
 * Plugin URI: https://tudominio.com/plugin-torneos-poker
 * Description: Un plugin para manejar y organizar torneos de poker en WordPress.
 * Version: 1.0.0
 * Author: Tu Nombre
 * Author URI: https://tudominio.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: torneos-poker
 * Domain Path: /languages
 */

// Si este archivo es llamado directamente, abortar.
if (!defined('WPINC')) {
    die;
}


// Define la constante para la ruta base del plugin
if (!defined('POKER_PLUGIN_DIR')) {
    define('POKER_PLUGIN_DIR', plugin_dir_path(__FILE__));
}


// Autoload de clases
spl_autoload_register(function ($class_name) {
    $classes_dir = plugin_dir_path(__FILE__) . 'includes/';
    $class_file = str_replace('\\', '/', $class_name) . '.php';
    if (file_exists($classes_dir . $class_file)) {
        require_once $classes_dir . $class_file;
    }
});

// Inicializar el plugin
function iniciar_plugin_torneos_poker()
{
    $plugin = new TorneosPoker\Plugin();
    $plugin->run();
}
add_action('plugins_loaded', 'iniciar_plugin_torneos_poker');
