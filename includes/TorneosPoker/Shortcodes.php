<?php

namespace TorneosPoker;

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

        $query = new TorneoQuery();
        $torneos = $query
            ->orderBy($atts['orderby'], $atts['order'])
            ->limit($atts['limit'])
            ->get();

        echo "<pre style='background-color: black; color: white; padding: 10px'>";
        var_dump($torneos);
        echo "</pre>";

        $output = '<ul class="lista-torneos">';
        foreach ($torneos as $torneo) {
            $fecha = get_post_meta($torneo->ID, '_torneo_fecha', true);
            $buyin = get_post_meta($torneo->ID, '_torneo_buyin', true);
            $output .= sprintf(
                '<li><a href="%s">%s</a> - Fecha: %s, Buy-in: %s</li>',
                get_permalink($torneo->ID),
                esc_html($torneo->post_title),
                esc_html($fecha),
                esc_html($buyin)
            );
        }
        $output .= '</ul>';

        return $output;
    }
}
