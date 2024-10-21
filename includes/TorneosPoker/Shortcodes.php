<?php

namespace TorneosPoker;

use TorneosPoker\Repositories\ModalidadRepository;
use TorneosPoker\Repositories\TorneoRepository;

require_once POKER_PLUGIN_DIR . 'includes/TorneosPoker/Repositories/ModalidadRepository.php';

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

        $torneo_repository = new TorneoRepository();
        $torneos = $torneo_repository->get_all();
        $modalidad_repository = new ModalidadRepository();


        $output = '<div class="torneo-cards" style="display: grid; grid-template-columns: repeat(2, 1fr)">';
        foreach ($torneos as $torneo) {
            $permalink = $torneo->get_permalink();
            $name = $torneo->get_name();
            $fecha = $torneo->get_date();
            $buyin = $torneo->get_buyin();
            $modalidad = $modalidad_repository->findById($torneo->get_modalidad_id());

            $output .= sprintf(
                '<div class="torneo-card" style="border: 1px solid #ccc; border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
                    <div class="torneo-card-header" style="background-color: %s; padding: 10px;">
                        <h3 style="margin: 0; color: #fff;">%s</h3>
                    </div>
                    <div class="torneo-card-body" style="padding: 15px;">
                        <div class="torneo-logo" style="text-align: center; margin-bottom: 10px;">
                            %s
                        </div>
                        <p><strong>Fecha:</strong> %s</p>
                        <p><strong>Buy-in:</strong> %s</p>
                        <p><strong>Modalidad:</strong> %s</p>
                        <a href="%s" style="display: inline-block; margin-top: 10px; padding: 10px 15px; background-color: #0073aa; color: #fff; text-decoration: none; border-radius: 4px;">Ver más</a>
                    </div>
                </div>',
                esc_html($modalidad->get_color()),
                esc_html($name),
                $modalidad->get_thumbnail(),
                esc_html($fecha),
                esc_html($buyin),
                esc_html($modalidad->get_name()),
                $permalink
            );
        }
        $output .= '</div>';

        return $output;
    }
}
