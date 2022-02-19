<?php
//DB接続 ＆ 選択
$mysqli = mysqli_connect('localhost', 'root', 'root','db1');
if (!$mysqli) {
  die('DB接続失敗'.mysqli_error());
}
?>
