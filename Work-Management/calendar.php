<?php
//セッション開始
session_start();

//DB接続
require_once('db_info.php');

//ファンクション
require_once('function.php');

//現在日付
$current_date = date('Ymd');

//現在月で絞り込み
$result = $mysqli->query("
  select
    main.date
    ,main.weeks
    ,left(right(CONCAT('000000',work_fr_time),6),4) as work_fr_time
    ,left(right(CONCAT('000000',work_to_time),6),4) as work_to_time
    ,left(right(CONCAT('000000',rest_fr_time),6),4) as rest_fr_time
    ,left(right(CONCAT('000000',rest_to_time),6),4) as rest_to_time
  from T_calendar as main
  left join(
    select date,min(time) as work_fr_time from T_log where pattern='1' group by date
  ) as work_fr on work_fr.date=main.date
  left join(
    select date,max(time) as work_to_time from T_log where pattern='2' group by date
  ) as work_to on work_to.date=main.date
  left join(
    select date,min(time) as rest_fr_time from T_log where pattern='3' group by date
  ) as rest_fr on rest_fr.date=main.date
  left join(
    select date,max(time) as rest_to_time from T_log where pattern='4' group by date
  ) as rest_to on rest_to.date=main.date
  where left(main.date,6) = ".substr($current_date,0,6)."
  order by main.date;
");

//--------------------------------------------------------------------------
//「申請画面へ」ボタン押下時のエラーチェック & 送信済みメッセージの破棄
//--------------------------------------------------------------------------
if($_SERVER['REQUEST_METHOD']=='POST'){
  $_SESSION['form'] = $_POST;
  header('Location: record_edit.php');
  exit();
}
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
<form action="" method="POST" name="main">
<div class="container">
  <table class="table table-bordered align-middle">
    <thead  class="bg-dark text-light">
      <tr>
        <th scope="col" width="5%">編集<br>申請</th>
        <th scope="col" width="15%">日付</th>
        <th scope="col" width="30%">スケジュール</th>
        <th scope="col" width="10%">出勤</th>
        <th scope="col" width="10%">退勤</th>
        <th scope="col" width="10%">休憩開始</th>
        <th scope="col" width="10%">休憩終了</th>
        <th scope="col" width="10%">実働時間</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <!--編集申請-->
        <th scope="row">
          <button type="button" class="btn btn-secondary" data-bs-toggle="dropdown">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" onclick="edit('1',<?php echo $row['date'] ?>);">打刻編集</a></li>
            <li><a class="dropdown-item" href="#" onclick="edit('2',<?php echo $row['date'] ?>);">スケジュール編集</a></li>
          </ul>
        </th>
        <!--日付-->
        <td class="<?php echo getColor($row['weeks']) ?>">
          <?php echo insertSlash($row['date']).getWeek($row['weeks']) ?>
        </td>
        <!--スケジュール-->
        <td>通常勤務(仮)</td>
        <!--出勤-->
        <td><?php echo insertColon($row['work_fr_time']) ?></td>
        <!--退勤-->
        <td><?php echo insertColon($row['work_to_time']) ?></td>
        <!--休憩開始-->
        <td><?php echo insertColon($row['rest_fr_time']) ?></td>
        <!--休憩終了-->
        <td><?php echo insertColon($row['rest_to_time']) ?></td>
        <!--実働時間-->
        <td><?php echo getWorkTime($row['work_fr_time'],$row['work_to_time'],$row['rest_fr_time'],$row['rest_to_time']) ?></td>
      </tr>
      <?php endwhile ?>
    </tbody>
  </table>
</div>
<!--POSTで後続処理に渡す-->
<input type="hidden" id="set_date" name="set_date"></input>
</form>
<!-- BootStrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
  const edit = (prm1,prm2) =>{
    if(prm1==1){
      document.getElementById('set_date').value=prm2;
    }else{
      document.getElementById('set_date').value=prm2;
    }
    document.main.submit();
  }
</script>
</body>
</html>
