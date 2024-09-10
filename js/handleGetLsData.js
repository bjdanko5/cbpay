
function updateCodeSB(CodeSB) {
  var select = $('#CodeSB');
  var selectedCodeSB = $('#CodeSB').text().includes('...') ? '' : $('#CodeSB').text();
  select.html(''); // Очистим список перед добавлением данных
  $.each(CodeSB, function (index, value) {
    var option = $('<option>', {
      value: index, // или другое уникальное значение
      text: value   // текст опции
    });
    if (value === selectedCodeSB || (selectedCodeSB === '' && index === 0)) {
      option.attr('selected', 'selected');
    }
    select.append(option);
  });
}

function updateLsAddress(address) {
    const lsAddressElement = $('#lsAddress');
    lsAddressElement.text(address);
}

function updateLsData(data) {
    const tablePO = $('#tablePO');
    const tableIPU = $('#tableIPU');

    updateTablePO(tablePO, data['ПолучателиСБ']);
    updateTableIPU(tableIPU, data['Приборы']);
}

function updateTablePO(table, data) {
    table.find('tbody').empty();
    data.forEach((item) => {
        const row = $('<tr>');
        row.append($('<td>').text(item.Получатель));
        row.append($('<td class="editable">').append($('<input type="text" value="' + item.Остаток + '">')));
        row.append($('<td hidden="">').text(item.КодПолучателя));
        table.find('tbody').append(row);
    });
    $('#tablePO .editable input').trigger('input');
}

function updateTableIPU(table, data) {
    table.find('tbody').empty();
    data.forEach((item) => {
        const row = $('<tr>');
        row.append($('<td>').text(item.Прибор));
        row.append($('<td>').text(item.ЗаводскойНомер));
        row.append($('<td>').text(item.ПредыдущееПоказание));
        row.append($('<td class="editable">').append($('<input type="text" value="' + item.ТекущееПоказание + '">')));
        row.append($('<td hidden="">').text(item.КодПрибора));
        table.find('tbody').append(row);
    });
}
function handleGetLsDataSuccess(data) {
    const lsAddress = data['ДанныеЛС']['АдресЛС'];
    const lsData = data['ДанныеЛС'];
    const CodeSB = data['ДанныеЛС']['КодыСБ'];
    updateCodeSB(CodeSB);
    updateLsAddress(lsAddress);
    updateLsData(lsData);
    Stage('Детализация');
}