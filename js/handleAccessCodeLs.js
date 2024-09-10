$('#accessCodeLs').on('keydown', function (e) {
    if (e.which === 13) { // Enter
        e.preventDefault(); // предотвратить дефолтное поведение
        $('#accessCodeLs').trigger('change');
    }
});
function handleAccessCodeLs(data){
$('#ivcBaseCode').text(data['Реквизиты'].ivcBaseCode);
$('#ivcBaseWdsl').text(data['Реквизиты'].ivcBaseWdsl);
$('#ivcBaseName').text(data['Реквизиты'].ivcBaseName);
$('#Ls').val(data['Реквизиты'].Ls);
if(data['Реквизиты'].Ls == 'Не найден') {
    return;
}
$('#lsAddress').text(data['Реквизиты'].Address);
$('#getlsDataButton').trigger('click');
Stage('Выбран код доступа');
}