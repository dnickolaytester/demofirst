<?php

require 'func.php';

const IBODY = 1;
const IHEADERS = 0;

$is_debug = true;

// first step

// выполнять тестовый запрос к wsdl сервису
// $response = xmlrpc_decode_request(xml, method)
$url2wsdl = 'http://82.138.16.126:8888/TaxiPublic/Service.svc?wsdl';

$url = 'http://127.0.0.1:8001/response.php?foo=yes.we_can&baz=foo-bar';

ob_start();
doRequest($is_debug ? $url : $url2wsdl);
$response_full = ob_get_contents();
ob_end_clean();


$response = explode("\n\r", $response_full);

$body_response = $response[IBODY];
$headers_response = $response[IHEADERS];

//print_r($body_response);
//print_r($headers_response);

// сравнивать его ответ с эталоном
// ...
//print_r($_REQUEST);
//print_r($_SERVER['REQUEST_TIME']);

// сохранять результат сравнения
$compare_result = 0;

//временем реакции (время выполнения запроса)
$time_execute = isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : strtotime(date("Ymd"));
//echo PHP_EOL;
//print_r($time_execute);


//вердиктом (OK|FAIL) в базу
$is_fail = !isCorrectAnswer($body_response, $tag = 'RegNum', $value = 'em33377');


// если сравнение выдало FAIL
if($is_fail) {
    // необходимо сохранять тело ответа сервиса (и по желанию, хедеры)
    $info = [
        $time_execute,
        $wail = 1,  //@todo
        $is_fail,
        $body_response,
        $headers_response
    ];
    doSave($info);
    //doSave($id_request, $body_response);
    // doSave($id_request, $headers_response);
/*
Желательно ограничить размер сохраняемых данных, во избежание переполнения базы (15 КБ на ответ, 3 КБ на хедеры).
*/
}

/*
При выборе одного из результатов, система должна показать всю имеющуюся информацию о выбранном запросе:
    - дата/время выполнения запроса
    - дата/время получения ответа
    - время ожидания [ формат: «% c (% мс)]
    - результат сравнения (ок/fail)
    - для запросов со статусом fail – тело ответа (+ хедеры по желанию)
*/
