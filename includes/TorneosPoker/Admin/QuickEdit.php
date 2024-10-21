<?php

namespace TorneosPoker\Admin;

class QuickEdit
{
    private $post_type;

    public function __construct($post_type)
    {
        $this->post_type = $post_type;
        add_action('quick_edit_custom_box', [$this, 'agregar_campos_quick_edit'], 10, 2);
        add_action('save_post', [$this, 'guardar_datos_quick_edit']);
    }

    public function agregar_campos_quick_edit($column_name, $post_type)
    {
        if ($post_type == $this->post_type && $column_name == 'torneo_buyin') {
?>
            <fieldset class="inline-edit-col-right">
                <div class="inline-edit-col">
                    <label>
                        <span class="title">Buyin</span>
                        <span class="input-text-wrap">
                            <input type="text" name="torneo_buyin" class="torneo_buyin" value="">
                        </span>
                    </label>
                    <label>
                        <span class="title">Bounty</span>
                        <span class="input-text-wrap">
                            <input type="text" name="torneo_bounty" class="torneo_bounty" value="">
                        </span>
                    </label>
                    <label>
                        <span class="title">Puntos</span>
                        <span class="input-text-wrap">
                            <input type="text" name="torneo_puntos" class="torneo_puntos" value="">
                        </span>
                    </label>
                    <label>
                        <span class="title">Fecha</span>
                        <span class="input-text-wrap">
                            <input type="date" name="torneo_fecha" class="torneo_fecha" value="">
                        </span>
                    </label>
                    <label>
                        <span class="title">Hora</span>
                        <span class="input-text-wrap">
                            <input type="time" name="torneo_hora" class="torneo_hora" value="">
                        </span>
                    </label>
                    <label>
                        <span class="title">Modalidad</span>
                        <span class="input-text-wrap">
                            <select name="torneo_modalidad" class="torneo_modalidad torneo-select2">
                                <option value=""><?php _e('Seleccionar modalidad', 'torneos-poker'); ?></option>
                                <?php
                                $modalidades = get_posts([
                                    'post_type' => 'modalidad',
                                    'numberposts' => -1,
                                    'orderby' => 'title',
                                    'order' => 'ASC'
                                ]);
                                foreach ($modalidades as $modalidad) {
                                    echo '<option value="' . esc_attr($modalidad->ID) . '">' . esc_html($modalidad->post_title) . '</option>';
                                }
                                ?>
                            </select>
                        </span>
                    </label>
                </div>
            </fieldset>
<?php
        }
    }

    public function guardar_datos_quick_edit($post_id)
    {
        $campos = ['torneo_buyin', 'torneo_bounty', 'torneo_puntos', 'torneo_fecha', 'torneo_hora', 'torneo_modalidad'];

        foreach ($campos as $campo) {
            if (isset($_POST[$campo])) {
                update_post_meta($post_id, '_' . $campo, sanitize_text_field($_POST[$campo]));
            }
        }
    }
}
