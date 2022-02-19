<?php
//セッション開始
session_start();

$error = [];
//--------------------------------------------------------------------------
//「申請画面へ」ボタン押下時のエラーチェック & 送信済みメッセージの破棄
//--------------------------------------------------------------------------
if($_SERVER['REQUEST_METHOD']=='POST'){

  //送信済みメッセージを破棄
  unset($_SESSION['message']);

  if($_POST['name']==''){
    $error['name']='blank';
  }

  if($_POST['email']==''){
    $error['email']='blank';
  //メールアドレスの妥当性チェック
  }elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $error['email']='email';
  }

  if($_POST['content']==''){
    $error['content']='blank';
  }

  if(count($error)==0){
    //エラーない場合は確認画面に遷移
    $_SESSION['form'] = $_POST;
    header('Location: confirm.php');
    exit();
  }

//--------------------------------------------------------------------------
//確認画面、更新画面から遷移時した時の処理
//--------------------------------------------------------------------------
}else{
  //更新画面
  if(isset($_SESSION['message'])){
    $message = $_SESSION['message'];

  //確認画面
  }elseif(isset($_SESSION['form'])){
    $_POST = $_SESSION['form'];
  }
}
?>
<!doctype html>
<html class="no-js" lang="ja">
<head>
<meta charset="utf-8">
<title>お問い合わせ</title>
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
  <form action="" method="POST" novalidate>
    <div class="m-3">
      <?php if($message!=''):?>
      <h3 class="text-success"><?php echo $message ?></h3>
      <?php endif; ?>
      <h1>お問い合わせ</h1>
    </div>
    <div class="m-3">
      <label class="form-label">お名前</label>
      <input type="text" name="name" class="form-control" value="<?php echo $_POST['name'] ?>" placeholder="XXX XXX" required>
      <?php if($error['name']=='blank'): ?>
        <p class="error_msg text-danger">※お名前をご記入ください</p>
      <?php endif; ?>
    </div>
    <div class="m-3">
    <label class="form-label">メールアドレス</label>
      <input type="text" name="email" class="form-control" id="exampleFormControlInput1" value="<?php echo $_POST['email'] ?>" placeholder="name@example.com">
      <?php if($error['email']=='blank'): ?>
        <p class="error_msg text-danger">※メールアドレスをご記入ください</p>
      <?php elseif($error['email']=='email'): ?>
        <p class="error_msg text-danger">※メールアドレスを正しくご記入ください</p>
      <?php endif; ?>
    </div>
    <div class="m-3">
      <label class="form-label">お問い合わせ内容</label>
      <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3"><?php echo $_POST['content'] ?></textarea>
      <?php if($error['content']=='blank'): ?>
        <p class="error_msg text-danger">※お問い合わせ内容をご記入ください</p>
      <?php endif; ?>
    </div>
    <div class="m-3">
      <button type="submit" class="btn btn-primary">申請画面へ</button>
    </div>
  </form>
</div>
</body>
</html>
