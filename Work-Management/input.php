<!doctype html>
<html class="no-js" lang="ja">
<head>
<meta charset="utf-8">
<title>勤務時間入力画面</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="./css/main.css" rel="stylesheet">
<!-- BootStrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!--Font Awesome-->
<link href="https://use.fontawesome.com/releases/v6.0.0/css/all.css" rel="stylesheet">
<meta name="theme-color" content="#fafafa">
</head>
<body>
<div class="container m-5">
  <div class="row div_border pt-4 pb-4">
    <div class="col">スケジュール編集</div>
  </div>
  <div class="row div_border pt-3 pb-3">
    <div class="col-3">パターン</div>
    <div class="col-9">
      <select class="px-2" name="example">
        <option value="">--</option>
        <option value="01">有給</option>
        <option value="02">午前休暇</option>
        <option value="03">午後休暇</option>
        <option value="04">代休</option>
      </select>
    </div>
  </div>
  <div class="row div_border pt-3 pb-3">
    <div class="col-3">出勤/退勤予定</div>
    <div class="col-2">出勤</div>
    <div class="col-2">
      <select class="px-2" name="example">
        <option value="">--</option>
        <option value="09">09:00</option>
        <option value="10">10:00</option>
        <option value="11">11:00</option>
        <option value="12">12:00</option>
        <option value="13">13:00</option>
        <option value="14">14:00</option>
        <option value="15">15:00</option>
        <option value="16">16:00</option>
        <option value="17">17:00</option>
        <option value="18">18:00</option>
        <option value="19">19:00</option>
        <option value="20">20:00</option>
        <option value="21">21:00</option>
      </select>
    </div>
    <div class="col-2">退勤</div>
    <div class="col-3">
      <select class="px-2" name="example">
        <option value="">--</option>
        <option value="09">09:00</option>
        <option value="10">10:00</option>
        <option value="11">11:00</option>
        <option value="12">12:00</option>
        <option value="13">13:00</option>
        <option value="14">14:00</option>
        <option value="15">15:00</option>
        <option value="16">16:00</option>
        <option value="17">17:00</option>
        <option value="18">18:00</option>
        <option value="19">19:00</option>
        <option value="20">20:00</option>
        <option value="21">21:00</option>
      </select>
    </div>
  </div>
  <div class="row div_border pt-3 pb-3">
    <div class="col-3">休憩予定</div>
    <div class="col-2">休憩開始</div>
    <div class="col-2">
      <select class="px-2" name="example">
        <option value="">--</option>
        <option value="09">09:00</option>
        <option value="10">10:00</option>
        <option value="11">11:00</option>
        <option value="12">12:00</option>
        <option value="13">13:00</option>
        <option value="14">14:00</option>
        <option value="15">15:00</option>
        <option value="16">16:00</option>
        <option value="17">17:00</option>
        <option value="18">18:00</option>
        <option value="19">19:00</option>
        <option value="20">20:00</option>
        <option value="21">21:00</option>
      </select>
    </div>
    <div class="col-2">休憩終了</div>
    <div class="col-3">
      <select class="px-2" name="example">
        <option value="">--</option>
        <option value="09">09:00</option>
        <option value="10">10:00</option>
        <option value="11">11:00</option>
        <option value="12">12:00</option>
        <option value="13">13:00</option>
        <option value="14">14:00</option>
        <option value="15">15:00</option>
        <option value="16">16:00</option>
        <option value="17">17:00</option>
        <option value="18">18:00</option>
        <option value="19">19:00</option>
        <option value="20">20:00</option>
        <option value="21">21:00</option>
      </select>
    </div>
  </div>
  <div class="row div_border pt-3 pb-3">
    <div class="col-3">申請メッセージ</div>
    <div class="col-9">
      <textarea class="form-control" id="floatingTextarea2" style="height: 100px"></textarea>
    </div>
  </div>
  <div class="pt-3 pb-3">
    <button type="submit" class="btn btn-primary">登録</button>
  </div>
  </div>
</body>
</html>
