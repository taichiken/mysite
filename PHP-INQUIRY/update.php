<?php
//DB接続
require_once('db_info.php');

//セッション開始
session_start();

//直接アクセスした場合は入力画面に戻す
if(!isset($_SESSION['form'])){
    header('Location: index.php');
    exit();
}else{
    $name = $_SESSION['form']['name'];
    $email = $_SESSION['form']['email'];
    $content = $_SESSION['form']['content'];

    $mysqli->query("insert into F_inquiry(name, email, content) values('$name', '$email', '$content')");
    $_SESSION['message'] = "送信完了しました！";

    //リダイレクト処理
    header('Location: index.php');
    exit();
}
?>
