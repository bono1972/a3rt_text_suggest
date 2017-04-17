<?php

ini_set( 'display_errors', 1 );

try{
    require_once (__DIR__ ."/credentials.php");
    require_once (__DIR__ ."/util.php");
} catch (Exception $e){
  echo $e->getMessage();
}
$text = $_POST["message"];

// A3RT Text Suggest API
$url = "https://api.a3rt.recruit-tech.co.jp/text_suggest/v1/predict";
// ポストするデータ
$param = [
	"apikey" => A3RT_KEY,
	"previous_description" => $text,
];
$query = http_build_query($param);
$url = $url ."?".$query;
// セッションを初期化
$conn = curl_init();
// オプション
curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($conn, CURLOPT_RETURNTRANSFER, true);
curl_setopt($conn, CURLOPT_URL,  $url);
// 実行
$res = curl_exec($conn);
// close
curl_close($conn);
//$res = mb_convert_encoding($res,'UTF-8');
$suggest_obj = json_decode($res, false);

//var_dump ($suggest_obj);
$count = count($suggest_obj->suggestion);

$html[] = "<select name=\"select\" size=\"{$count}\">";
for ($i=0;$i<$count;$i++){
	$html[] = "<option>{$suggest_obj->suggestion[$i]}</option>";
	}
$html[] ="</select>";
$html = implode($html);

$array = [
	'html' => $html,
	'text' => $text
];

echo json_encode($array);