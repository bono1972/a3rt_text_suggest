<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>TextSuggest Test</title>
</head>
<body>
<div>
  <!-- 入力フォームを作る（現在のページにPOSTする） -->
<p><em>冒頭の句を入力してください。：</em></p>
<p><input type="text" id="massage" value=""><br></>
<p><input type="button" id="submit" value="送信"></p>
<div id="list"></div>

<HR>
<div id="answer"></div>
<p><input type="button" style="display:none;" id="delete" value="クリア"></p>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="suggest_ajax.js"></script>
</body>
</html>
