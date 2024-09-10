function handleGetIvcBasesSuccess(data) {

    var select = $('#ivcBase');
    select.html(''); // Очистим список перед добавлением данных

    select.append($('<option>', {
        value: 0, // или другое уникальное значение
        text: 'Выберите...'  // текст опции
    }));

    $.each(data, function (index, value) {
        select.append($('<option>', {
            value: value.code, // или другое уникальное значение
            text: value.name  // текст опции
        }));
    });
    Stage('Инициализация');
}