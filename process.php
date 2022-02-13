<?php
require_once('db_info.php');

//セッション開始
session_start();

//初期値
$update = false;
$id = 0;

//Saveボタン押下時の制御
if(isset($_POST['save'])){
    $name = $_POST['name'];
    $location = $_POST['location'];
    $mysqli->query("insert into data(name, location) values('$name', '$location')");

    $_SESSION['message'] = "Record has been saved!";
    $_SESSION['msg_type'] = "success";

    //リダイレクト処理
    header("location: main.php");
    exit();
}

//Deleteボタン押下時の制御
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $mysqli->query("delete from data where id=$id");

    $_SESSION['message'] = "Record has been delete!";
    $_SESSION['msg_type'] = "danger";

    //リダイレクト処理
    header("location: main.php");
    exit();
}

//Editボタン押下時の制御
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $result = $mysqli->query("select * from data where id=$id");
    if(count($result)==1){
        $update = true;
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $location = $row['location'];
    }
}

//Updateボタン押下時の制御
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $mysqli->query("update data set name='$name', location='$location' where id=$id");

    $_SESSION['message'] = "Record has been updated!";
    $_SESSION['msg_type'] = "warning";

    //リダイレクト処理
    header("location: main.php");
    exit();
}
?>
