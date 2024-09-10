function handleAccessCodeLs(data){
$('#ivcBaseCode').text(data['Реквизиты'].ivcBaseCode);
$('#ivcBaseWdsl').text(data['Реквизиты'].ivcBaseWdsl);
$('#ivcBaseName').text(data['Реквизиты'].ivcBaseName);
$('#Ls').val(data['Реквизиты'].Ls);
$('#lsAddress').text(data['Реквизиты'].Address);

$('#getlsDataButton').trigger('click');
Stage('Выбран код доступа');
}