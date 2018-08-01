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
//获取请求类型 GET POST 等
$type = $_SERVER['REQUEST_METHOD'];
$err = new responseMessage();
$isPerform = true;      //是否可以执行
//获取到的值
$id = $_POST["id"];
$parentId = $_POST["parentId"];         //父级id
$categoryName = $_POST["categoryName"]; //分类名称
$state = $_POST["state"]; //分类状态 0停用 1启用

//检测分类名称存在且不为一个控制
if(empty(triMall($categoryName))){
    $err->message = "categoryName is required!";
    $isPerform = false;
}
if($isPerform){
    //修改分类信息
    $sql = "UPDATE category SET parentId = '$parentId', categoryName = '$categoryName', state = '$state' WHERE id = '$id';";
    $result = mysql_query($sql); //返回的是当前数据的位置
    if($result) {   //修改成功
        $err->advice = true;
        $err->message = "Update successfully";
    }else{
        $err->message = "Server error, please contact the administrator";
    }
}
$register_json = json_encode($err, TRUE);
echo $register_json;