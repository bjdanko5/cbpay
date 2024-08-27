<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start(); // Запускаем сессию
//$_SESSION = array();

// Функция для получения списка стран
function getCountries()
{
    // Закомментируем реальный SOAP-запрос для отладки
    /*
    $wsdl = "http://example.com/your-soap-api?wsdl";
    $options = [
        'trace' => 1,
        'exceptions' => 1
    ];

    try {
        $client = new SoapClient($wsdl, $options);
        $response = $client->GetCountries(); // Предположим, метод GetCountries

        return $response->countries; // Вернем массив стран
    } catch (SoapFault $e) {
        return [];
    }
    */

    // Возвращаем тестовые данные для отладки
    return [
        ['code' => 'RU', 'name' => 'Russia'],
        ['code' => 'US', 'name' => 'United States'],
        ['code' => 'CN', 'name' => 'China'],
        ['code' => 'JP', 'name' => 'Japan'],
        ['code' => 'DE', 'name' => 'Germany'],
    ];
}

// Функция для получения данных о стране (население и континент)
function getCountryDetails($countryCode)
{
    // Закомментируем реальный SOAP-запрос для отладки
    /*
    $wsdl = "http://example.com/your-soap-api?wsdl";
    $options = [
        'trace' => 1,
        'exceptions' => 1
    ];

    try {
        $client = new SoapClient($wsdl, $options);
        $response = $client->GetCountryDetails(['code' => $countryCode]); // Предположим, метод GetCountryDetails

        return [
            'population' => $response->population,
            'continent' => $response->continent
        ];
    } catch (SoapFault $e) {
        return ['population' => 'N/A', 'continent' => 'N/A'];
    }
    */

    // Возвращаем тестовые данные для отладки
    $details = [
        'RU' => ['population' => '146 million', 'continent' => 'Europe/Asia'],
        'US' => ['population' => '331 million', 'continent' => 'North America'],
        'CN' => ['population' => '1.4 billion', 'continent' => 'Asia'],
        'JP' => ['population' => '126 million', 'continent' => 'Asia'],
        'DE' => ['population' => '83 million', 'continent' => 'Europe'],
    ];

    return isset($details[$countryCode]) ? $details[$countryCode] : ['population' => 'N/A', 'continent' => 'N/A'];
}

// Функция для поиска почтового индекса
function getPostalCodeDetails($countryCode, $postalCode, $population, $continent)
{
    // Закомментируем реальный SOAP-запрос для отладки
    /*
    $wsdl = "http://example.com/your-soap-api?wsdl";
    $options = [
        'trace' => 1,
        'exceptions' => 1
    ];

    try {
        $client = new SoapClient($wsdl, $options);
        $response = $client->GetPostalCodeDetails(['code' => $countryCode, 'postalCode' => $postalCode]);

        return [
            'postalCode' => $response->postalCode,
            'population' => $response->population,
            'continent' => $response->continent
        ];
    } catch (SoapFault $e) {
        return ['postalCode' => $postalCode, 'population' => 'N/A', 'continent' => 'N/A'];
    }
    */

    // Возвращаем тестовые данные для отладки
    return [
        'postalCode' => $postalCode,
        'population' => $population,
        'continent' => $continent
    ];
}
//print $_SERVER['REQUEST_METHOD'];
// Обработка запросов
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['func']) && $_POST['func']==='getCountries') {

    if (!isset($_SESSION['countries'])) {
//print "Тут1";
        $_SESSION = array();
        $countries = getCountries(); // Получаем список стран (тестовые данные)
        $_SESSION['countries'] = $countries; // Сохраняем список стран в сессии
        echo json_encode($countries);
    } else {
        $countries = $_SESSION['countries']; // Используем данные из сессии
        echo json_encode($countries);
        }
//print var_export ($_SESSION['countries'],true);
    }
}
    // Если запрос содержит код страны, возвращаем детали страны
    if (isset($_POST['countryCode']) && !isset($_POST['postalCode'])) {
        $countryCode = $_POST['countryCode'];
        $details = getCountryDetails($countryCode);
        echo json_encode($details);
    }

    // Если запрос содержит код страны и почтовый индекс, возвращаем данные почтового индекса
    if (isset($_POST['countryCode']) && isset($_POST['postalCode'])) {
        $countryCode = $_POST['countryCode'];
        $postalCode = $_POST['postalCode'];
        $population = $_POST['population'];
        $continent = $_POST['continent'];
        $details = getPostalCodeDetails($countryCode, $postalCode, $population, $continent);
        echo json_encode($details);
    }

?>
