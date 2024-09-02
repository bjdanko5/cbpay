<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start(); // Запускаем сессию
ini_set("soap.wsdl_cache_enabled", "0");
$wsdlLK = "http://192.168.10.128/zkh_lk1/ws/WebСервисLK?wsdl";
//$_SESSION = array();

// Функция для получения списка стран
function getivcBases()
{
    // Закомментируем реальный SOAP-запрос для отладки
    
    global $wsdlLK;
    #$wsdlLK = "http://example.com/your-soap-api?wsdl";
    $options = [
        'login' => "Администратор", 
        'password' => "",
        'trace' => 1,
        'exceptions' => 1
    ];

    try {
        $client = new SoapClient($wsdlLK, $options);
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
    global $wsdlLK;

    $options = [
        'login' => "Администратор", 
        'password' => "",
        'trace' => 1,
        'exceptions' => 1
    ];


    try {
        $client = new SoapClient($wsdlLK, $options);
        $response = $client->GetivcBaseDetails(['code' => $ivcBaseCode]); // Предположим, метод GetivcBaseDetails
        return json_decode($response->return,true);
        /*return [
            'code' => $response->code,
            'wdsl' => $response->wdsl
        ];*/
    } catch (SoapFault $e) {
     //   return ['code' => 'N/A', 'wdsl' => 'N/A'];
     session_destroy(); 
    // Возвращаем тестовые данные для отладки
    $details = [
        'RU' => ['code' => '146 million', 'wdsl' => 'Europe/Asia'],
        'US' => ['code' => '331 million', 'wdsl' => 'North America'],
        'CN' => ['code' => '1.4 billion', 'wdsl' => 'Asia'],
        'JP' => ['code' => '126 million', 'wdsl' => 'Asia'],
        'DE' => ['code' => '83 million', 'wdsl' => 'Europe'],
    ];

    return isset($details[$ivcBaseCode]) ? $details[$ivcBaseCode] : ['code' => 'N/A', 'wdsl' => 'N/A'];
   
    }
  
 
}

// Функция для поиска почтового индекса
function getlsCodeDetails($ivcBaseCode, $lsCode, $code, $wdsl)
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
            'code' => $response->code,
            'wdsl' => $response->wdsl
        ];
    } catch (SoapFault $e) {
        return ['lsCode' => $lsCode, 'code' => 'N/A', 'wdsl' => 'N/A'];
    }
    */

    // Возвращаем тестовые данные для отладки
    return [
        'lsCode' => $lsCode,
        'code' => $code,
        'wdsl' => $wdsl
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
        $code = $_POST['code'];
        $wdsl = $_POST['wdsl'];
        $details = getlsCodeDetails($ivcBaseCode, $lsCode, $code, $wdsl);
        echo json_encode($details);
    }

?>
