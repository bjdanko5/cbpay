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
        $response = $client->GetivcBaseDetails(['ivcBaseCode' => $ivcBaseCode]); // Предположим, метод GetivcBaseDetails
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
        'RU' => ['ivcBaseCode' => '146 million', 'ivcBaseWdsl' => 'Europe/Asia'],
        'US' => ['ivcBaseCode' => '331 million', 'ivcBaseWdsl' => 'North America'],
        'CN' => ['ivcBaseCode' => '1.4 billion', 'ivcBaseWdsl' => 'Asia'],
        'JP' => ['ivcBaseCode' => '126 million', 'ivcBaseWdsl' => 'Asia'],
        'DE' => ['ivcBaseCode' => '83 million', 'ivcBaseWdsl' => 'Europe'],
    ];

    return isset($details[$ivcBaseCode]) ? $details[$ivcBaseCode] : ['ivcBaseCode' => 'N/A', 'ivcBaseWdsl' => 'N/A'];
   
    }
  
 
}
function getByaccessCodeLs($accessCodeLs)
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
        $response = $client->getByaccessCodeLs(['accessCodeLs' => $accessCodeLs]); 
        return json_decode($response->return,true);
     } catch (SoapFault $e) {
          session_destroy(); 
    // Возвращаем тестовые данные для отладки
    $details = [
        'Реквизиты' => ['ivcBaseCode' => '146 million', 'ivcBaseWdsl' => 'Europe/Asia','Ls' => 'Ошибка запроса...','Address'=>'Ошибка запроса...'],
    ];

    return $details;
    }
}
// Функция для поиска почтового индекса
function getLsData($ivcBaseCode, $ivcBaseWdsl,$Ls,$codeSB='')
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
     $response = $client->getLsData(['ivcBaseCode' => $ivcBaseCode,'Ls' => $Ls,'codeSB' => $codeSB]); 
     return json_decode($response->return,true);
     } catch (SoapFault $e) {
          session_destroy(); 
    $details = [
        'АдресЛС'=> 'отладка АдресЛС',
        'КодыСБ'=> ['53356','95677']
    ];
    return $details;
    }
}
//print $_SERVER['REQUEST_METHOD'];
// Обработка запросов
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['func']) && $_POST['func']==='getivcBases') {

    if (!isset($_SESSION['ivcBases'])) {

        $_SESSION = array();
        $ivcBases = getivcBases(); // Получаем список стран (тестовые данные)
        $_SESSION['ivcBases'] = $ivcBases; // Сохраняем список стран в сессии
        echo json_encode($ivcBases);
    } else {
        $ivcBases = $_SESSION['ivcBases']; // Используем данные из сессии
        echo json_encode($ivcBases);
        session_destroy();
        }
        unset($_POST['func']);
    }
    if (isset($_POST['func']) && $_POST['func']==='getByaccessCodeLs') {
        $accessCodeLs = $_POST['accessCodeLs'];
        $getLsData= getByaccessCodeLs($accessCodeLs); 
        if ($getLsData['Реквизиты']['Ls'] === ''){
            $getLsData['Реквизиты']['Ls'] = 'Не найден'; 
        }
        unset($_POST['func']);
        echo json_encode($getLsData);
    }    
}
    
    if (isset($_POST['ivcBaseCode']) && !isset($_POST['Ls'])) {
        $ivcBaseCode = $_POST['ivcBaseCode'];
        $details = getivcBaseDetails($ivcBaseCode);
        echo json_encode($details);
    }

   
    if (isset($_POST['ivcBaseCode']) && isset($_POST['Ls'])) {
        $ivcBaseCode = $_POST['ivcBaseCode'];
        $Ls = $_POST['Ls'];
        $ivcBaseWdsl = $_POST['ivcBaseWdsl'];
        $codeSB = $_POST['codeSB'];
        $LsData = getlsData($ivcBaseCode, $ivcBaseWdsl,$Ls,$codeSB);
        echo json_encode($LsData);
    }

?>
