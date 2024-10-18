<?php

namespace TorneosPoker\PostTypes;

class Modalidad
{
    private $post_type = 'modalidad';

    public function __construct()
    {
        add_action('init', [$this, 'registrar']);
        add_action('add_meta_boxes', [$this, 'agregar_meta_boxes']);
        add_action('save_post', [$this, 'guardar_campos']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
        add_filter('admin_body_class', [$this, 'admin_body_class']);
    }

    public function registrar()
    {
        $labels = [
            'name'                  => _x('Modalidades', 'Post Type General Name', 'torneos-poker'),
            'singular_name'         => _x('Modalidad', 'Post Type Singular Name', 'torneos-poker'),
            'menu_name'             => __('Modalidades', 'torneos-poker'),
            'name_admin_bar'        => __('Modalidad', 'torneos-poker'),
            'archives'              => __('Archivo de Modalidades', 'torneos-poker'),
            'attributes'            => __('Atributos de Modalidad', 'torneos-poker'),
            'parent_item_colon'     => __('Modalidad Padre:', 'torneos-poker'),
            'all_items'             => __('Todas las Modalidades', 'torneos-poker'),
            'add_new_item'          => __('Añadir Nueva Modalidad', 'torneos-poker'),
            'add_new'               => __('Añadir Nueva', 'torneos-poker'),
            'new_item'              => __('Nueva Modalidad', 'torneos-poker'),
            'edit_item'             => __('Editar Modalidad', 'torneos-poker'),
            'update_item'           => __('Actualizar Modalidad', 'torneos-poker'),
            'view_item'             => __('Ver Modalidad', 'torneos-poker'),
            'view_items'            => __('Ver Modalidades', 'torneos-poker'),
            'search_items'          => __('Buscar Modalidad', 'torneos-poker'),
            'not_found'             => __('No encontrado', 'torneos-poker'),
            'not_found_in_trash'    => __('No encontrado en la papelera', 'torneos-poker'),
            'featured_image'        => __('Logo', 'torneos-poker'),
            'set_featured_image'    => __('Establecer logo', 'torneos-poker'),
            'remove_featured_image' => __('Eliminar logo', 'torneos-poker'),
            'use_featured_image'    => __('Usar como logo', 'torneos-poker'),
            'insert_into_item'      => __('Insertar en Modalidad', 'torneos-poker'),
            'uploaded_to_this_item' => __('Subido a esta Modalidad', 'torneos-poker'),
            'items_list'            => __('Lista de Modalidades', 'torneos-poker'),
            'items_list_navigation' => __('Navegación de lista de Modalidades', 'torneos-poker'),
            'filter_items_list'     => __('Filtrar lista de Modalidades', 'torneos-poker'),
        ];

        $args = [
            'label'                 => __('Modalidad', 'torneos-poker'),
            'description'           => __('Modalidades de Torneos de Poker', 'torneos-poker'),
            'labels'                => $labels,
            'supports'              => ['title', 'editor', 'thumbnail'],
            'taxonomies'            => ['tipo'],
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => 'poker_menu',
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
        ];

        register_post_type($this->post_type, $args);
    }

    public function agregar_meta_boxes()
    {
        add_meta_box(
            'modalidad_detalles',
            __('Detalles de la Modalidad', 'torneos-poker'),
            [$this, 'render_meta_box'],
            $this->post_type,
            'normal',
            'high'
        );
    }

    public function render_meta_box($post)
    {
        wp_nonce_field('modalidad_meta_box', 'modalidad_meta_box_nonce');

        $color = get_post_meta($post->ID, '_modalidad_color', true);
        $buyin = get_post_meta($post->ID, '_modalidad_buyin', true);
        $bounty = get_post_meta($post->ID, '_modalidad_bounty', true);
        $puntos = get_post_meta($post->ID, '_modalidad_puntos', true);
        $mas_info = get_post_meta($post->ID, '_modalidad_mas_info', true);
        $mostrar = get_post_meta($post->ID, '_modalidad_mostrar', true);

?>
        <div class="modalidad-meta-box">
            <div class="modalidad-logo">
                <?php
                if (has_post_thumbnail($post->ID)) {
                    echo get_the_post_thumbnail($post->ID, 'thumbnail');
                } else {
                    echo '<p>' . __('No se ha establecido un logo', 'torneos-poker') . '</p>';
                }
                ?>
            </div>
            <div class="modalidad-row">
                <div class="modalidad-col">
                    <label for="modalidad_color"><?php _e('Color', 'torneos-poker'); ?></label>
                    <input type="color" id="modalidad_color" name="modalidad_color" style="height: 50px;" value="<?php echo esc_attr($color); ?>">
                </div>
            </div>
            <div class="modalidad-row">
                <div class="modalidad-col">
                    <label for="modalidad_buyin"><?php _e('Buyin', 'torneos-poker'); ?></label>
                    <input type="text" id="modalidad_buyin" name="modalidad_buyin" value="<?php echo esc_attr($buyin); ?>">
                </div>
                <div class="modalidad-col">
                    <label for="modalidad_bounty"><?php _e('Bounty', 'torneos-poker'); ?></label>
                    <input type="text" id="modalidad_bounty" name="modalidad_bounty" value="<?php echo esc_attr($bounty); ?>">
                </div>
                <div class="modalidad-col">
                    <label for="modalidad_puntos"><?php _e('Puntos', 'torneos-poker'); ?></label>
                    <input type="text" id="modalidad_puntos" name="modalidad_puntos" value="<?php echo esc_attr($puntos); ?>">
                </div>
            </div>
            <div class="modalidad-row">
                <div class="modalidad-col">
                    <label for="modalidad_mas_info"><?php _e('Más Información', 'torneos-poker'); ?></label>
                    <textarea id="modalidad_mas_info" name="modalidad_mas_info"><?php echo esc_textarea($mas_info); ?></textarea>
                </div>
            </div>
            <div class="modalidad-row">
                <div class="modalidad-col">
                    <label class="switch">
                        <input type="checkbox" id="modalidad_mostrar" name="modalidad_mostrar" <?php checked($mostrar, 'on'); ?>>
                        <span class="slider round"></span>
                    </label>
                    <span class="switch-label"><?php _e('Mostrar Modalidad', 'torneos-poker'); ?></span>
                </div>
            </div>
        </div>
<?php
    }

    public function guardar_campos($post_id)
    {
        if (!isset($_POST['modalidad_meta_box_nonce']) || !wp_verify_nonce($_POST['modalidad_meta_box_nonce'], 'modalidad_meta_box')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $campos = [
            'modalidad_color',
            'modalidad_buyin',
            'modalidad_bounty',
            'modalidad_puntos',
            'modalidad_mas_info',
        ];

        foreach ($campos as $campo) {
            if (isset($_POST[$campo])) {
                update_post_meta($post_id, '_' . $campo, sanitize_text_field($_POST[$campo]));
            }
        }

        $mostrar = isset($_POST['modalidad_mostrar']) ? 'on' : 'off';
        update_post_meta($post_id, '_modalidad_mostrar', $mostrar);
    }

    public function enqueue_admin_scripts($hook)
    {
        global $post;

        if ($hook == 'post-new.php' || $hook == 'post.php') {
            if ($post->post_type === $this->post_type) {
                wp_enqueue_style('modalidad-admin-style', plugin_dir_url(__FILE__) . '../../../assets/css/admin-style.css');
            }
        }
    }

    public function admin_body_class($classes)
    {
        global $post;
        if (isset($post->post_type) && $post->post_type === $this->post_type) {
            $classes .= ' modalidad-admin';
        }
        return $classes;
    }
}
