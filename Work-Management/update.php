<?php
//セッション開始
session_start();

echo $_SERVER['REQUEST_METHOD'].'(session)'.'<br>';

//パラメータ受け取り
$date = $_SESSION['form']['set_id5'];

echo $date.'<br>';


//DB接続
require_once('db_info.php');

echo '成功';
?>
