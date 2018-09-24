$(function() {

    var $circle = $('#circle');
    var $trinagle = $('#trinagle');
    var $parallelogram = $('#parallelogram');

    $circle.on("click", function() {
        renderForm('circle');
    })

    $trinagle.on("click", function() {
        renderForm('trinagle');
    })

    $parallelogram.on("click", function() {
        renderForm('parallelogram');
    })

    function renderForm(figureName) {
        var $form = $('#figureForm');
        $form.html("");
        // Заголовок
        var $header = $('<div/>', { class: 'headerForm' });
        var $picture = $('<div/>', { class: 'headerForm__picture' });
        var $figure = $('<span/>', { class: figureName });
        var $title = $('<h5/>', { text: figureName, class: 'headerForm__title ' });

        $picture.append($figure);
        $header.append($picture);
        $header.append($title);
        $form.append($header);
        // Содержимое
        var $content = $('<div/>', { class: 'figureForm__content' });
        var $submit = $('<button/>', { class: 'btn btn-primary', type: 'submit', text: 'Create figure' });
        var $figureType = $('<input/>', { type: "hidden", name: "type", value: figureName });
        $content.append($figureType);
        
        if (figureName === 'circle') {
            var $fieldset1 = $('<fieldset/>', { class: 'form-inline' });
            var $fieldset2 = $('<fieldset/>', { class: 'form-inline' });
            var $legend1 = $('<legend/>', { text: 'Center coordinates' });
            var $legend2 = $('<legend/>', { text: 'Radius coordinates' });
            var $input1x = $('<input/>', {
                class: 'form-control m-2',
                type: "number",
                placeholder: "Input X",
                name: "centerX",
                required: "true"
            });
            var $input2x = $('<input/>', {
                class: 'form-control m-2',
                type: "number",
                placeholder: "Input X",
                name: "radiusX",
                required: "true"
            });
            var $input1y = $('<input/>', {
                class: 'form-control m-2',
                type: "number",
                placeholder: "Input Y",
                name: "centerY",
                required: "true"
            });
            var $input2y = $('<input/>', {
                class: 'form-control m-2',
                type: "number",
                placeholder: "Input Y",
                name: "radiusY",
                required: "true"
            });

            $fieldset1.append($legend1);
            $fieldset1.append($input1x);
            $fieldset1.append($input1y);

            $fieldset2.append($legend2);
            $fieldset2.append($input2x);
            $fieldset2.append($input2y);

            $content.append($fieldset1);
            $content.append($fieldset2);
        } else {
            var $fieldset1 = $('<fieldset/>', { class: 'form-inline' });
            var $fieldset2 = $('<fieldset/>', { class: 'form-inline' });
            var $fieldset3 = $('<fieldset/>', { class: 'form-inline' });
            var $legend1 = $('<legend/>', { text: 'Point #1 coordinates' });
            var $legend2 = $('<legend/>', { text: 'Point #2 coordinates' });
            var $legend3 = $('<legend/>', { text: 'Point #3 coordinates' });
            var $input1x = $('<input/>', {
                class: 'form-control m-2',
                type: "number",
                placeholder: "Input X",
                name: "point1X",
                required: "true"
            });
            var $input2x = $('<input/>', {
                class: 'form-control m-2',
                type: "number",
                placeholder: "Input X",
                name: "point2X",
                required: "true"
            });
            var $input3x = $('<input/>', {
                class: 'form-control m-2',
                type: "number",
                placeholder: "Input X",
                name: "point3X",
                required: "true"
            });
            var $input1y = $('<input/>', {
                class: 'form-control m-2',
                type: "number",
                placeholder: "Input Y",
                name: "point1Y",
                required: "true"
            });
            var $input2y = $('<input/>', {
                class: 'form-control m-2',
                type: "number",
                placeholder: "Input Y",
                name: "point2Y",
                required: "true"
            });
            var $input3y = $('<input/>', {
                class: 'form-control m-2',
                type: "number",
                placeholder: "Input Y",
                name: "point3Y",
                required: "true"
            });

            $fieldset1.append($legend1);
            $fieldset1.append($input1x);
            $fieldset1.append($input1y);

            $fieldset2.append($legend2);
            $fieldset2.append($input2x);
            $fieldset2.append($input2y);

            $fieldset3.append($legend3);
            $fieldset3.append($input3x);
            $fieldset3.append($input3y);

            $content.append($fieldset1);
            $content.append($fieldset2);
            $content.append($fieldset3);
        }
        $form.append($content);
        $form.append($submit);
    }


});

