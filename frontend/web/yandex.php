<?php 


define("TOKEN" ,"AgAAAAAM1JhtAAY_zFpE9UklKUorjFLFPrLMngo");//токен пользователя (см. Директ API)

function curl_get($ch,$postdata){

    $data_string = json_encode($postdata, JSON_UNESCAPED_UNICODE);
        
    curl_setopt($ch,CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . TOKEN,
        'Accept-Language: ru',
        'Content-Type: application/json; charset=utf-8'
    )); 
	    curl_setopt($curl, CURLOPT_URL, 'https://api-sandbox.direct.yandex.com/json/v5');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    
    // для отладки
    // $fOut = fopen($_SERVER["DOCUMENT_ROOT"].'/'.'curl_out.txt', "w" );
    // curl_setopt ($ch, CURLOPT_VERBOSE, 1);
    // curl_setopt ($ch, CURLOPT_STDERR, $fOut );

    $data = curl_exec($ch);
	l( $data);
	l($postdata);
    $data2 = json_decode($data, true);
    return $data2;
}


//запрос на формирование отчета по выбраным словам
function formReport($ch, $wordsArr, $area){

    $postdata = array(
        "method" => "CreateNewWordstatReport",
        "param" => [
            "Phrases" => $wordsArr,
            "GeoID"=> [$area]
        ],
        "locale" => "ru",
        "token" => TOKEN
    );
    //print_r($postdata);
    $data = curl_get($ch, $postdata);
	l($data);
}

//Проверка готовности отчета
function checkReport($ch){

    $postdata = array(
        "method" => "GetWordstatReportList",
        "locale" => "ru",
        "token" => TOKEN
    );
    $reportsArr = array();
    $data = curl_get($ch, $postdata);

    foreach ($data["data"] as $i => $report){
        $reportsArr[$report["ReportID"]] = $report["StatusReport"];
    }
    return $reportsArr;

}

//Загрузка отчета по выбраным словам
function downloadReport($ch,$reportNum){

    $postdata = array(
        "method" => "GetWordstatReport",
        "param" => $reportNum,
        "locale" => "ru",
        "token" => TOKEN
    );

    return curl_get($ch, $postdata);
}

//удаление отчета с сервера Яндекса
function deleteReport($ch,$reportNum){

    $postdata = array(
        "method" => "DeleteWordstatReport",
        "param" => $reportNum,
        "locale" => "ru",
        "token" => TOKEN
    );

    $html = curl_get($ch, $postdata);
}

//удаление всех отчетов с сервера Яндекса
function deleteAllReport($ch,$reportsArr){
    foreach ($reportsArr as $reportNum => $status) {
        deleteReport($ch,$reportNum);
    }
}

//добавление результатов отчетов по словам в массив 
function getWordsUseCount($data,$WordsUseCount){
    foreach ($data["data"] as $i => $word) {
        foreach ($word['SearchedWith'] as $j => $option) {
            if ($option['Phrase']==$word['Phrase']) {
                $WordsUseCount[$option['Phrase']]=$option['Shows'];
                break;
            }
        }
    }
    return $WordsUseCount;

}

//генерация файла
function createFile($WordsUseCount){
    
    header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
     header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
     header ( "Cache-Control: no-cache, must-revalidate" );
     header ( "Pragma: no-cache" );
     header ( "Content-type: application/vnd.ms-excel" );
     header ( "Content-Disposition: attachment; filename=matrix.xls" );
 
    //
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Записываем данные в файл

    $counter = 1;
    foreach ($WordsUseCount as $key => $value) {
        $sheet->setCellValue("A".$counter, $key);
        $sheet->setCellValue("B".$counter, $value);
        $counter++;
    } 

    $writer = new Xlsx($spreadsheet);
    $writer->save('Results/Result.xlsx');
}

$ch = curl_init('https://api-sandbox.direct.yandex.com/v4/json/');//https://api-sandbox.direct.yandex.com/v4/json/ --- так как работа в песочнице, должно быть https://api.direct.yandex.com/v4/json/
$text = $_POST['keywords'];
$area =  $_POST['area'];
$keywords = preg_split("/[\n]/", $text);
$wordCounter = 0;
$requestCounter = 0;

$WordsUseCount = array();
$wordsArr=array();

switch ($area) {
    case 'all':
        $area = 0;
        break;
    case 'moscow':
        $area = 213;
        break;
    case 'dubna':
        $area = 215;
        break;
    default:
        $area = 0;
        break;
}
formReport($ch, $keywords, 213);



function l($arr) {
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

