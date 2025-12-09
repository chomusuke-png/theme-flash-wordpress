jQuery(document).ready(function ($) {

    function updateField(wrapper) {
        let items = [];

        wrapper.find('.custom-repeater-item').each(function () {
            items.push({
                title: $(this).find('.title-field').val(),
                icon: $(this).find('.icon-field').val(),
                url: $(this).find('.url-field').val()
            });
        });

        wrapper.find('.custom-repeater-hidden').val(JSON.stringify(items)).trigger('change');
    }

    $('.custom-repeater-wrapper').each(function () {
        const wrapper = $(this);
        
        // LEER LOS ICONOS DINÁMICAMENTE DESDE PHP
        // (Viene del atributo data-icons que pusimos en functions.php)
        const iconsData = wrapper.data('icons');

        // Drag & Drop
        wrapper.find('.custom-repeater-list').sortable({
            handle: '.drag-handle',
            update: function () {
                updateField(wrapper);
            }
        });

        // Añadir elemento dinámico
        wrapper.on('click', '.add-item', function () {
            
            // Generar las opciones del select basadas en la lista específica de esta sección
            let optionsHtml = '<option value="">Elegir icono...</option>';
            
            if (iconsData) {
                // Iterar sobre el objeto de iconos (clave: clase, valor: nombre)
                for (const [iconClass, iconLabel] of Object.entries(iconsData)) {
                    optionsHtml += `<option value="${iconClass}">${iconLabel}</option>`;
                }
            }

            // Insertar el nuevo item con el select correcto
            wrapper.find('.custom-repeater-list').append(`
                <li class="custom-repeater-item">
                    <input type="text" class="title-field" placeholder="Título">

                    <select class="icon-select">
                        ${optionsHtml}
                    </select>

                    <input type="text" class="icon-field" placeholder="o escribe icono (fa-solid fa-x)">
                    <input type="text" class="url-field" placeholder="URL">

                    <span class="drag-handle">☰</span>
                    <button type="button" class="button remove-item">Eliminar</button>
                </li>
            `);

            updateField(wrapper);
        });

        // Eliminar
        wrapper.on('click', '.remove-item', function () {
            $(this).closest('.custom-repeater-item').remove();
            updateField(wrapper);
        });

        // Select sincroniza con input manual
        wrapper.on('change', '.icon-select', function () {
            $(this).closest('.custom-repeater-item')
                   .find('.icon-field')
                   .val($(this).val());
            updateField(wrapper);
        });

        // Input manual sincroniza con select (si coincide)
        wrapper.on('input', '.title-field, .icon-field, .url-field', function () {
            updateField(wrapper);
        });
    });

});