jQuery(document).ready(function ($) {
    $('.torneo-select2').select2({
        width: '100%',
        placeholder: 'Seleccionar modalidad',
        allowClear: true
    });
});



jQuery(document).ready(function ($) {
    var $wp_inline_edit = inlineEditPost.edit;
    inlineEditPost.edit = function (id) {
        $wp_inline_edit.apply(this, arguments);

        if (typeof (id) == 'object') {
            post_id = parseInt(this.getId(id));
        }

        if (post_id > 0) {
            var $edit_row = $('#edit-' + post_id);
            var $post_row = $('#post-' + post_id);

            var buyin = $('.column-torneo_buyin', $post_row).text();
            var bounty = $('.column-torneo_bounty', $post_row).text();
            var puntos = $('.column-torneo_puntos', $post_row).text();
            var fecha = $('.column-torneo_fecha', $post_row).text();
            var hora = $('.column-torneo_hora', $post_row).text();
            var modalidad = $('.column-torneo_modalidad', $post_row).text();

            $('input[name="torneo_buyin"]', $edit_row).val(buyin);
            $('input[name="torneo_bounty"]', $edit_row).val(bounty);
            $('input[name="torneo_puntos"]', $edit_row).val(puntos);
            $('input[name="torneo_fecha"]', $edit_row).val(fecha);
            $('input[name="torneo_hora"]', $edit_row).val(hora);
            $('input[name="torneo_modalidad"]', $edit_row).val(modalidad);
        }
    };
});