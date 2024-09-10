function errorON(error) {
    $('#error-message').show();
    $('#error-message').text('Ошибка: ' + error);    
}
function errorOFF(error) {
    $('#error-message').hide();
}
