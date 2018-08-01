<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/20
 * Time: 17:50
 */
header('Content-Type:application/json;charset=utf-8');
//屏蔽语法错误导致的数据错误
error_reporting(0);
require_once 'instrument/instrument.php';  //调用工具类
include_once("instrument/connect.php");//连接数据库
$err = new responseMessage();
//获取到的值
$id = $_POST["id"];
$sql = "DELETE FROM product WHERE id = '$id'";
$result = mysql_query($sql);
if($result) {   //删除成功
    $err->advice = true;
    $err->message = "Delete successfully";
}else{
    $err->message = "Server error, please contact the administrator";
}

$register_json = json_encode($err, TRUE);
echo $register_json;