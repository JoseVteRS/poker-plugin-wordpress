<?php

namespace TorneosPoker;

use TorneosPoker\Database\ModalidadQuery;
use TorneosPoker\Database\TorneoQuery;

class Shortcodes
{
    public function __construct()
    {
        add_shortcode('lista_torneos', [$this, 'lista_torneos_shortcode']);
    }

    public function lista_torneos_shortcode($atts)
    {
        $atts = shortcode_atts(
            array(
                'limit' => 10,
                'orderby' => '_torneo_fecha',
                'order' => 'DESC',
            ),
            $atts,
            'lista_torneos'
        );

        $torneo_query = new TorneoQuery();
        $torneos = $torneo_query->getByDateFromToday(); // Obtener torneos a partir de hoy
        $modalidad_query = new ModalidadQuery();

        echo "<pre style='background-color: black; color: white; padding: 10px'>";
        var_dump($torneo_query->test());
        echo "</pre>";

        $output = '<div class="torneo-cards">';
        foreach ($torneos as $torneo) {
            $permalink = $torneo->get_permalink();
            $name = $torneo->get_name();
            $fecha =  formatDate($torneo->get_date());
            $buyin = $torneo->get_buyin();
            $modalidad = $modalidad_query->getById($torneo->get_modalidad_id());

            // Verificar si la modalidad es nula
            $modalidad_color = $modalidad ? $modalidad->get_color() : '#ccc';
            $modalidad_name = $modalidad ? $modalidad->get_name() : 'Desconocida';
            $modalidad_thumbnail = $modalidad ? $modalidad->get_thumbnail('medium') : '';

            $output .= sprintf(
                '<div class="torneo-card">
                    <div class="torneo-card-header" style="background-color: %s;">
                        <h3>%s</h3>
                    </div>
                    <div class="torneo-card-body" >
                        <div class="torneo-logo">
                            %s
                        </div>
                        <p><strong>Fecha:</strong> %s</p>
                        <p><strong>Buy-in:</strong> %s</p>
                        <p><strong>Modalidad:</strong> %s</p>
                        <a href="%s" >Ver más</a>
                    </div>
                </div>',
                esc_html($modalidad_color),
                esc_html($name),
                $modalidad_thumbnail,
                esc_html($fecha),
                esc_html($buyin),
                esc_html($modalidad_name),
                esc_url($permalink)
            );
        }
        $output .= '</div>';

        return $output;
    }
}
