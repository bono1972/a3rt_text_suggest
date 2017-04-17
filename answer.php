<?php

ini_set( 'display_errors', 1 );

try{
    require_once (__DIR__ ."/util.php");
} catch (Exception $e){
  echo $e->getMessage();
}
$text = es($_POST["text"]);
$list_head = es($_POST["listhead"]);

echo "<p>".$list_head.$text."</p>";