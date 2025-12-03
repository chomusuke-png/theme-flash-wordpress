jQuery(document).ready(function ($) {

    function updateField(wrapper) {
        let items = [];

        wrapper.find('.halal-repeater-item').each(function () {
            items.push({
                title: $(this).find('.title-field').val(),
                icon: $(this).find('.icon-field').val(),
                url: $(this).find('.url-field').val()
            });

        });

        wrapper.find('.halal-repeater-hidden').val(JSON.stringify(items)).trigger('change');
    }

    $('.halal-repeater-wrapper').each(function () {
        const wrapper = $(this);

        // Drag & Drop
        wrapper.find('.halal-repeater-list').sortable({
            handle: '.drag-handle',
            update: function () {
                updateField(wrapper);
            }
        });

        // Añadir
        wrapper.on('click', '.add-social', function () {
            wrapper.find('.halal-repeater-list').append(`
                <li class="halal-repeater-item">
                    <input type="text" class="title-field" placeholder="Título del sitio">

                    <select class="icon-select">
                        <option value="">Elegir icono…</option>
                        <option value="fa-solid fa-newspaper">Noticia</option>
                        <option value="fa-solid fa-building">Empresa</option>
                        <option value="fa-solid fa-globe">Globo</option>
                    </select>

                    <input type="text" class="icon-field" placeholder="o escribe icono (fa-solid fa-x)">
                    <input type="text" class="url-field" placeholder="URL">

                    <span class="drag-handle">☰</span>
                    <button type="button" class="button remove-social">Eliminar</button>
                </li>

            `);

            updateField(wrapper);
        });

        // Eliminar
        wrapper.on('click', '.remove-social', function () {
            $(this).closest('.halal-repeater-item').remove();
            updateField(wrapper);
        });

        // Select sincroniza con input
        wrapper.on('change', '.icon-select', function () {
            $(this).closest('.halal-repeater-item')
                   .find('.icon-field')
                   .val($(this).val());
            updateField(wrapper);
        });

        // Input sincroniza con select
        wrapper.on('input', '.title-field, .icon-field, .url-field', function () {
            updateField(wrapper);
        });


    });

});
