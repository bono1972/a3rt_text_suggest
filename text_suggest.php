<?php

ini_set( 'display_errors', 1 );

try{
    require_once (__DIR__ ."/credentials.php"); 
    require_once (__DIR__ ."/util.php");
} catch (Exception $e){
  echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>TextSuggest Test</title>
</head>
<body onload="document.form.message.focus();">
<div>
  <!-- 入力フォームを作る（現在のページにPOSTする） -->
  <form name ="form" method="POST" action="">
  <p><em>回答をもらう：</em></p>
   <p><input type="text" name="message"></p>
   <p><input type="submit" value="つぶやく"></p>
  </form>
<?php
  // エラーフラグ
  $isError = false;
  // 回答を取り出す
  if (isset($_POST['message'])){
    $messege = es(trim($_POST['message']));
    if ($messege===""){
      // 空白のときエラー
      $isError = true;
    }
  } else {
    // 未設定のときエラー
    $isError = true;
  }
?>

<?php if ($isError): ?>
  <!-- エラーがあったとき -->
  <p>文字を入力してください。</p>
<?php else: ?>
  <!-- エラーがなかったとき -->
<?php	
  $message = $_POST["message"];
  //aveContext($res->context);
?>

  <HR>
	<p>
  <?php
		$res = getSuggest($message);
		$count = count($res->suggestion);
		echo "<br/>".$count."<br/>";
		//echo $res->suggestion[0];
		
		for ($i=0;$i<$count;$i++){
			echo $res->suggestion[$i];
		}

	?>
  </p>
<?php endif; ?>
<?php
function getSuggest ($text) {
	// A3RT TalkAPI
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
	$obj = json_decode($res, false);
	var_dump ($obj);
	
	return $obj;
}
?>
