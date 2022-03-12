<?php
//セッション開始
session_start();

//DB接続
require_once('db_info.php');

//ファンクション
require_once('function.php');


//--------------------------------------------------
//現在・前月・翌月日付を取得
//--------------------------------------------------
//getで取得できない場合はdate()から取得
$current_date = $_GET['set_date'];
if($current_date==''){
  $current_date = date('Ymd');
}


//前月を'YYYYMM01'の形式で取得
$before_month = 0;
$result = $mysqli->query("
  select * from T_calendar
  where date in (select min(date) from T_calendar where date=".substr(date('Ymd', strtotime($current_date.'-1 month')),0,6)."01)
  limit 1;
");
$row = $result->fetch_array(MYSQLI_ASSOC);
if($row['date']!=''){
  $before_month = $row['date'];
}
$result->close();


//翌月を'YYYYMM01'の形式で取得
$next_month = 0;
$result = $mysqli->query("
  select * from T_calendar
  where date in (select min(date) from T_calendar where date=".substr(date('Ymd', strtotime($current_date.'+1 month')),0,6)."01)
  limit 1;
");
$row = $result->fetch_array(MYSQLI_ASSOC);
if($row['date']!=''){
  $next_month = $row['date'];
}
$result->close();

//--------------------------------------------------
//月初取得
//--------------------------------------------------
$result = $mysqli->query("
  select * from T_calendar
  where date in (select min(date) from T_calendar where left(date,6)=".substr($current_date,0,6).");
");
$row = $result->fetch_array(MYSQLI_ASSOC);
$begin_month = insertSlash($row['date']);
$begin_weeks = getWeek($row['weeks']);
$result->close();


//--------------------------------------------------
//月末取得
//--------------------------------------------------
$result = $mysqli->query("
  select * from T_calendar
  where date in (select max(date) from T_calendar where left(date,6)=".substr($current_date,0,6).");
");
$row = $result->fetch_array(MYSQLI_ASSOC);
$end_month = insertSlash($row['date']);
$end_weeks = getWeek($row['weeks']);
$result->close();


//--------------------------------------------------
//該当月のログ取得
//--------------------------------------------------
$result = $mysqli->query("
  select
    main.date
    ,main.weeks
    ,work_fr_time
    ,work_to_time
    ,rest_fr_time
    ,rest_to_time
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
?>
<!doctype html>
<html class="no-js" lang="ja">
<head>
<meta charset="utf-8">
<title>タイムカード画面</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- BootStrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<!--Font Awesome-->
<link href="https://use.fontawesome.com/releases/v6.0.0/css/all.css" rel="stylesheet">
<link href="./css/main.css" rel="stylesheet">
<meta name="theme-color" content="#fafafa">
</head>
<body>
<form action="" method="POST" name="main">

<!--***************************************************************************
ヘッダー
***************************************************************************-->
<div class="header">
  <div class="header-menu">
    <ul>
      <li><a href="./index.php"><i class="fa-solid fa-house"></i></a></li>
    </ul>
  </div>
</div>

<!--***************************************************************************
カレンダー
***************************************************************************-->
<div class="container">
  <h2>
    <!--現在年月-->
    <?php echo $begin_month ?><span class="h5"><?php echo $begin_weeks ?></span>〜
    <?php echo $end_month ?><span class="h5"><?php echo $end_weeks ?></span>

    <!--月切り替えボタン-->
    <div class="btn-group">
      <button type="button" class="btn btn-outline-secondary" onclick="changeMonth(<?php echo $before_month ?>);"><i class="fa-solid fa-angle-left"></i></button>
      <button type="button" class="btn btn-outline-secondary" onclick="changeMonth(<?php echo date('Ymd') ?>);">今月</button>
      <button type="button" class="btn btn-outline-secondary" onclick="changeMonth(<?php echo $next_month ?>);"><i class="fa-solid fa-angle-right"></i></button>
    </div>
  </h2>

  <table class="table table-bordered align-middle">
    <thead class="bg-dark text-light sticky">
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
            <i class="fa fa-bars"></i></i>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" onclick="nextRedirect('1',<?php echo $row['date'] ?>);">打刻編集</a></li>
            <li><a class="dropdown-item" href="#" onclick="nextRedirect('2',<?php echo $row['date'] ?>);">休暇登録</a></li>
          </ul>
        </th>
        <!--日付-->
        <td class="<?php echo getColor($row['weeks']) ?>">
          <?php echo insertSlash($row['date']).getWeek($row['weeks']) ?>
        </td>
        <!--スケジュール-->
        <td>通常勤務</td>
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
</form>

<!-- BootStrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
  //--------------------------------------------------
  //次画面に遷移
  //--------------------------------------------------
  const nextRedirect = (prm1,prm2) =>{
    if(prm1==1){
      location.href = './record_edit.php?set_date='+prm2;
    }else{
      location.href = './input.php?set_date='+prm2;
    }
  }

  //--------------------------------------------------
  //指定月へ切り替え
  //--------------------------------------------------
  const changeMonth = (prm) =>{
    if(prm!=0){
      location.href = './timecard.php?set_date='+prm;
    }
  }

</script>
</body>
</html>
