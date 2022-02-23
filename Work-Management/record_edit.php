<?php
echo '修正中';
//セッション開始
session_start();

//DB接続
require_once('db_info.php');

//ファンクション
require_once('function.php');

//パラメータ受け取り
$date = $_SESSION['form']['set_date'];


//現在月で絞り込み
$result = $mysqli->query("
  select * from T_log
  where date = ".$date."
  order by date,time
");
?>
<!doctype html>
<html class="no-js" lang="ja">
<head>
<meta charset="utf-8">
<title>カレンダー画面</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- BootStrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<!--Font Awesome-->
<link href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" rel="stylesheet">
<link href="./css/main.css" rel="stylesheet">
<meta name="theme-color" content="#fafafa">
</head>
<body>
<div class="container">
  <table class="table table-bordered">
    <thead  class="bg-dark text-light">
      <tr>
        <th scope="col" width="50%">打刻種別</th>
        <th scope="col" width="50%">打刻時刻</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td>
          <select class="form-select" name="color">
            <option value="">選択してください</option>
            <option value="1" <?php echo selectPulldown('1',$row['pattern']) ?>>出勤</option>
            <option value="2" <?php echo selectPulldown('2',$row['pattern']) ?>>退勤</option>
            <option value="3" <?php echo selectPulldown('3',$row['pattern']) ?>>休憩開始</option>
            <option value="4" <?php echo selectPulldown('4',$row['pattern']) ?>>休憩終了</option>
          </select>
        </td>
        <td><?php echo $row['time'] ?></td>
      </tr>
      <?php endwhile ?>
    </tbody>
  </table>
</div>
<!-- BootStrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
