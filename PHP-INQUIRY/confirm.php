<?php
//セッション開始
session_start();

//入力画面からのアクセスでなければ戻す
if(!isset($_SESSION['form'])){
  header('Location: index.php');
  exit();
}else{
  //入力画面から受け取り
  $post = $_SESSION['form'];
}
?>
<!doctype html>
<html class="no-js" lang="ja">
<head>
<meta charset="utf-8">
<title>お問い合わせ(確認)</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- BootStrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!--Font Awesome-->
<link href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" rel="stylesheet">
<meta name="theme-color" content="#fafafa">
</head>
<body>
<div class="container">
  <div class="m-3">
    <h1>お問い合わせ</h1>
  </div>
  <div class="row m-5">
    <div class="col-3">お名前</div>
    <div class="col-9">
      <?php echo $post['name'] ?>
    </div>
  </div>
  <div class="row m-5">
    <div class="col-3">メールアドレス</div>
    <div class="col-9">
      <?php echo $post['email'] ?>
    </div>
  </div>
  <div class="row m-5">
    <div class="col-3">お問い合わせ内容</div>
    <div class="col-9">
      <?php echo nl2br($post['content']) ?>
    </div>
  </div>
  <div class="row m-5">
    <div class="col-3">
      <button type="submit" class="px-5 btn btn-primary" onclick="location.href='./index.php'">戻る</button>
    </div>
    <div class="col-3">
      <button type="submit" class="px-5 btn btn-primary" onclick="location.href='./update.php'">送信</button>
    </div>
  </div>
</div>
</body>
</html>
