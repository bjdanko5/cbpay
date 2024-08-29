<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start(); // Запускаем сессию
ini_set("soap.wsdl_cache_enabled", "0");
//$_SESSION = array();

// Функция для получения списка стран
function getivcBases()
{
    // Закомментируем реальный SOAP-запрос для отладки
    
    $wsdl = "http://192.168.10.128/zkh_lk1/ws/WebСервисLK?wsdl";
    #$wsdl = "http://example.com/your-soap-api?wsdl";
    $options = [
        'login' => "Администратор", 
        'password' => "",
        'trace' => 1,
        'exceptions' => 1
    ];

    try {
        $client = new SoapClient($wsdl, $options);
        $response = $client->GetivcBases(); // Предположим, метод GetivcBases
        return json_decode($response->return,true); // Вернем массив стран
    } catch (SoapFault $e) {
    // Возвращаем тестовые данные для отладки
    session_destroy();
    return [
        ['code' => 'RU', 'name' => 'Russia'],
        ['code' => 'US', 'name' => 'United States'],
        ['code' => 'CN', 'name' => 'China'],
        ['code' => 'JP', 'name' => 'Japan'],
        ['code' => 'DE', 'name' => 'Germany'],
    ];
   }
}

// Функция для получения данных о стране (население и континент)
function getivcBaseDetails($ivcBaseCode)
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
        $response = $client->GetivcBaseDetails(['code' => $ivcBaseCode]); // Предположим, метод GetivcBaseDetails

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

    return isset($details[$ivcBaseCode]) ? $details[$ivcBaseCode] : ['population' => 'N/A', 'continent' => 'N/A'];
}

// Функция для поиска почтового индекса
function getlsCodeDetails($ivcBaseCode, $lsCode, $population, $continent)
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
        $response = $client->GetlsCodeDetails(['code' => $ivcBaseCode, 'lsCode' => $lsCode]);

        return [
            'lsCode' => $response->lsCode,
            'population' => $response->population,
            'continent' => $response->continent
        ];
    } catch (SoapFault $e) {
        return ['lsCode' => $lsCode, 'population' => 'N/A', 'continent' => 'N/A'];
    }
    */

    // Возвращаем тестовые данные для отладки
    return [
        'lsCode' => $lsCode,
        'population' => $population,
        'continent' => $continent
    ];
}
//print $_SERVER['REQUEST_METHOD'];
// Обработка запросов
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['func']) && $_POST['func']==='getivcBases') {

    if (!isset($_SESSION['ivcBases'])) {
//print "Тут1";
        $_SESSION = array();
        $ivcBases = getivcBases(); // Получаем список стран (тестовые данные)
        $_SESSION['ivcBases'] = $ivcBases; // Сохраняем список стран в сессии
        echo json_encode($ivcBases);
    } else {
        $ivcBases = $_SESSION['ivcBases']; // Используем данные из сессии
        echo json_encode($ivcBases);
        session_destroy();
        }
//print var_export ($_SESSION['ivcBases'],true);
    }
}
    // Если запрос содержит код страны, возвращаем детали страны
    if (isset($_POST['ivcBaseCode']) && !isset($_POST['lsCode'])) {
        $ivcBaseCode = $_POST['ivcBaseCode'];
        $details = getivcBaseDetails($ivcBaseCode);
        echo json_encode($details);
    }

    // Если запрос содержит код страны и почтовый индекс, возвращаем данные почтового индекса
    if (isset($_POST['ivcBaseCode']) && isset($_POST['lsCode'])) {
        $ivcBaseCode = $_POST['ivcBaseCode'];
        $lsCode = $_POST['lsCode'];
        $population = $_POST['population'];
        $continent = $_POST['continent'];
        $details = getlsCodeDetails($ivcBaseCode, $lsCode, $population, $continent);
        echo json_encode($details);
    }

?>
