<?php

namespace TorneosPoker\PostTypes;

class Torneo
{
    private $post_type = 'torneo';

    public function __construct()
    {
        add_action('init', [$this, 'registrar']);
        add_action('add_meta_boxes', [$this, 'agregar_meta_boxes']);
        add_action('save_post', [$this, 'guardar_campos']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
    }

    public function registrar()
    {
        $labels = [
            'name'                  => _x('Torneos', 'Post Type General Name', 'torneos-poker'),
            'singular_name'         => _x('Torneo', 'Post Type Singular Name', 'torneos-poker'),
            'menu_name'             => __('Torneos', 'torneos-poker'),
            'name_admin_bar'        => __('Torneo', 'torneos-poker'),
            'archives'              => __('Archivo de Torneos', 'torneos-poker'),
            'attributes'            => __('Atributos del Torneo', 'torneos-poker'),
            'parent_item_colon'     => __('Torneo Padre:', 'torneos-poker'),
            'all_items'             => __('Todos los Torneos', 'torneos-poker'),
            'add_new_item'          => __('Añadir Nuevo Torneo', 'torneos-poker'),
            'add_new'               => __('Añadir Nuevo', 'torneos-poker'),
            'new_item'              => __('Nuevo Torneo', 'torneos-poker'),
            'edit_item'             => __('Editar Torneo', 'torneos-poker'),
            'update_item'           => __('Actualizar Torneo', 'torneos-poker'),
            'view_item'             => __('Ver Torneo', 'torneos-poker'),
            'view_items'            => __('Ver Torneos', 'torneos-poker'),
            'search_items'          => __('Buscar Torneo', 'torneos-poker'),
            'not_found'             => __('No encontrado', 'torneos-poker'),
            'not_found_in_trash'    => __('No encontrado en la papelera', 'torneos-poker'),
            'featured_image'        => __('Imagen Destacada', 'torneos-poker'),
            'set_featured_image'    => __('Establecer imagen destacada', 'torneos-poker'),
            'remove_featured_image' => __('Eliminar imagen destacada', 'torneos-poker'),
            'use_featured_image'    => __('Usar como imagen destacada', 'torneos-poker'),
            'insert_into_item'      => __('Insertar en Torneo', 'torneos-poker'),
            'uploaded_to_this_item' => __('Subido a este Torneo', 'torneos-poker'),
            'items_list'            => __('Lista de Torneos', 'torneos-poker'),
            'items_list_navigation' => __('Navegación de lista de Torneos', 'torneos-poker'),
            'filter_items_list'     => __('Filtrar lista de Torneos', 'torneos-poker'),
        ];

        $args = [
            'label'                 => __('Torneo', 'torneos-poker'),
            'description'           => __('Torneos de Poker', 'torneos-poker'),
            'labels'                => $labels,
            'supports'              => ['title', 'thumbnail'],
            'taxonomies'            => ['periodicidad'],
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-games',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rewrite'               => ['slug' => 'torneos'],
        ];

        register_post_type($this->post_type, $args);
    }


    public function agregar_meta_boxes()
    {
        add_meta_box(
            'torneo_detalles',
            __('Detalles del Torneo', 'torneos-poker'),
            [$this, 'render_meta_box'],
            $this->post_type,
            'normal',
            'high'
        );

        add_meta_box(
            'torneo_visibilidad',
            __('Visibilidad', 'torneos-poker'),
            [$this, 'render_visibilidad_meta_box'],
            $this->post_type,
            'side',
            'default'
        );
    }


    public function render_meta_box($post)
    {
        wp_nonce_field('torneo_meta_box', 'torneo_meta_box_nonce');

        $buyin = get_post_meta($post->ID, '_torneo_buyin', true);
        $bounty = get_post_meta($post->ID, '_torneo_bounty', true);
        $puntos = get_post_meta($post->ID, '_torneo_puntos', true);
        $fecha = get_post_meta($post->ID, '_torneo_fecha', true);
        $hora = get_post_meta($post->ID, '_torneo_hora', true);
        $mas_info = get_post_meta($post->ID, '_torneo_mas_info', true);
        $product_id = get_post_meta($post->ID, '_torneo_product_id', true);
        $actualizacion = get_post_meta($post->ID, '_torneo_actualizacion', true);
        $modalidad_id = get_post_meta($post->ID, '_torneo_modalidad_id', true);

?>
        <div class="torneo-meta-box">
            <div class="torneo-row">
                <div class="torneo-col">
                    <div id="modalidad_imagen_container" style="margin-top: 10px; text-align: center;">
                        <?php
                        if ($modalidad_id) {
                            echo get_the_post_thumbnail($modalidad_id, 'thumbnail');
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="torneo-row">
                <div class="torneo-col">
                    <label for="torneo_modalidad_id"><?php _e('Modalidad', 'torneos-poker'); ?></label>
                    <select id="torneo_modalidad_id" name="torneo_modalidad_id" class="torneo-select2">
                        <option value=""><?php _e('Seleccionar modalidad', 'torneos-poker'); ?></option>
                        <?php
                        $modalidades = get_posts([
                            'post_type' => 'modalidad',
                            'numberposts' => -1,
                            'orderby' => 'title',
                            'order' => 'ASC'
                        ]);
                        foreach ($modalidades as $modalidad) {
                            echo '<option value="' . esc_attr($modalidad->ID) . '" ' . selected($modalidad_id, $modalidad->ID, false) . '>' . esc_html($modalidad->post_title) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="torneo-row">
                <div class="torneo-col">
                    <label for="torneo_buyin"><?php _e('Buyin', 'torneos-poker'); ?></label>
                    <input type="text" id="torneo_buyin" name="torneo_buyin" value="<?php echo esc_attr($buyin); ?>">
                </div>
                <div class="torneo-col">
                    <label for="torneo_bounty"><?php _e('Bounty', 'torneos-poker'); ?></label>
                    <input type="text" id="torneo_bounty" name="torneo_bounty" value="<?php echo esc_attr($bounty); ?>">
                </div>
                <div class="torneo-col">
                    <label for="torneo_puntos"><?php _e('Puntos', 'torneos-poker'); ?></label>
                    <input type="text" id="torneo_puntos" name="torneo_puntos" value="<?php echo esc_attr($puntos); ?>">
                </div>
            </div>
            <div class="torneo-row">
                <div class="torneo-col">
                    <label for="torneo_fecha"><?php _e('Fecha', 'torneos-poker'); ?></label>
                    <input type="date" id="torneo_fecha" name="torneo_fecha" value="<?php echo esc_attr($fecha); ?>">
                </div>
                <div class="torneo-col">
                    <label for="torneo_hora"><?php _e('Hora', 'torneos-poker'); ?></label>
                    <input type="time" id="torneo_hora" name="torneo_hora" value="<?php echo esc_attr($hora); ?>">
                </div>
            </div>
            <div class="torneo-row">
                <div class="torneo-col">
                    <label for="torneo_product_id"><?php _e('ID del Producto', 'torneos-poker'); ?></label>
                    <input type="text" id="torneo_product_id" name="torneo_product_id" value="<?php echo esc_attr($product_id); ?>">
                </div>
            </div>
            <div class="torneo-row">
                <div class="torneo-col">
                    <label for="torneo_mas_info"><?php _e('Más Información', 'torneos-poker'); ?></label>
                    <?php wp_editor($mas_info, 'torneo_mas_info', ['textarea_name' => 'torneo_mas_info', 'media_buttons' => false, 'textarea_rows' => 5]); ?>
                </div>
            </div>
            <div class="torneo-row">
                <div class="torneo-col">
                    <label for="torneo_actualizacion"><?php _e('Actualización', 'torneos-poker'); ?></label>
                    <?php wp_editor($actualizacion, 'torneo_actualizacion', ['textarea_name' => 'torneo_actualizacion', 'media_buttons' => false, 'textarea_rows' => 5]); ?>
                </div>
            </div>
        </div>
    <?php
    }


    public function render_visibilidad_meta_box($post)
    {
        $mostrar_frontend = get_post_meta($post->ID, '_torneo_mostrar_frontend', true);
        $mostrar_actualizacion = get_post_meta($post->ID, '_torneo_mostrar_actualizacion', true);

    ?>
        <div class="torneo-visibilidad">
            <div class="torneo-switch-container">
                <label class="switch">
                    <input type="checkbox" id="torneo_mostrar_frontend" name="torneo_mostrar_frontend" <?php checked($mostrar_frontend, 'on'); ?>>
                    <span class="slider round"></span>
                </label>
                <span class="switch-label"><?php _e('Mostrar en Frontend', 'torneos-poker'); ?></span>
            </div>
            <div class="torneo-switch-container">
                <label class="switch">
                    <input type="checkbox" id="torneo_mostrar_actualizacion" name="torneo_mostrar_actualizacion" <?php checked($mostrar_actualizacion, 'on'); ?>>
                    <span class="slider round"></span>
                </label>
                <span class="switch-label"><?php _e('Mostrar Actualización', 'torneos-poker'); ?></span>
            </div>
        </div>
<?php
    }

    public function guardar_campos($post_id)
    {
        if (!isset($_POST['torneo_meta_box_nonce']) || !wp_verify_nonce($_POST['torneo_meta_box_nonce'], 'torneo_meta_box')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $campos_texto = [
            'torneo_buyin',
            'torneo_bounty',
            'torneo_puntos',
            'torneo_fecha',
            'torneo_hora',
            'torneo_product_id',
        ];

        foreach ($campos_texto as $campo) {
            if (isset($_POST[$campo])) {
                update_post_meta($post_id, '_' . $campo, sanitize_text_field($_POST[$campo]));
            }
        }

        $campos_html = [
            'torneo_mas_info',
            'torneo_actualizacion',
        ];

        foreach ($campos_html as $campo) {
            if (isset($_POST[$campo])) {
                update_post_meta($post_id, '_' . $campo, wp_kses_post($_POST[$campo]));
            }
        }

        $checkboxes = [
            'torneo_mostrar_frontend',
            'torneo_mostrar_actualizacion',
        ];

        foreach ($checkboxes as $checkbox) {
            update_post_meta($post_id, '_' . $checkbox, isset($_POST[$checkbox]) ? 'on' : 'off');
        }

        if (isset($_POST['torneo_modalidad_id'])) {
            update_post_meta($post_id, '_torneo_modalidad_id', sanitize_text_field($_POST['torneo_modalidad_id']));
        }
    }

    public function enqueue_admin_scripts($hook)
    {
        global $post;

        if ($hook == 'post-new.php' || $hook == 'post.php') {
            if ($post->post_type === $this->post_type) {
                wp_enqueue_style('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
                wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', ['jquery'], '4.0.13', true);
                wp_enqueue_script('torneo-admin-script', plugin_dir_url(__FILE__) . '../../../assets/js/admin-script.js', ['jquery', 'select2'], '1.0.0', true);
            }
        }
    }
}
