function handleGetIvcBasesDetails(data){
$('#ivcBaseCode').text(data[0].ivcBaseCode);
$('#ivcBaseWdsl').text(data[0].ivcBaseWdsl);
$('#ivcBaseName').text(data[0].ivcBaseName);
Stage('Выбрана территория');
}