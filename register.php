<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/9
 * Time: 17:37
 */
header('Content-Type:application/json;charset=utf-8');
//屏蔽语法错误导致的数据错误
error_reporting(0);
require_once 'instrument/instrument.php';  //调用error类
include_once("instrument/connect.php");//连接数据库
//获取请求类型 GET POST 等
$type = $_SERVER['REQUEST_METHOD'];

$err = new responseMessage();
$isRegister = true;
//获取到的值
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$email = $_POST["email"];
$password = $_POST["password"];
$phone = $_POST["phone"];
$name = $firstName.$lastName;
//检测用户名存在且不是一个空格
if(empty(triMall($firstName))){
    $err->message = "firstName is required!";
    $isRegister = false;
}
if(empty(triMall($lastName))){
    $err->message = "lastName is required!";
    $isRegister = false;
}
if(empty(triMall($email))){
    $err->message = "email is required!";
    $isRegister = false;
}
if(empty(triMall($password))){
    $err->message = "password is required!";
    $isRegister = false;
}
if(empty(triMall($phone))){
    $err->message = "phone is required!";
    $isRegister = false;
}
//查找手机号是否存在
$phoneSql = "select * from user where phone = '$phone'";
$phoneResult = mysql_query($phoneSql);
$phoneNum = mysql_num_rows($phoneResult); //统计执行结果影响的行数
//查找邮箱是否存在
$emailSql = "select * from user where email = '$email'";
$emailResult = mysql_query($emailSql);
$emailNum = mysql_num_rows($emailResult); //统计执行结果影响的行数
if($isRegister){
    if($phoneNum) {   //如果已经存在该手机号
        $err->message = "The phone already exists!";
    }elseif($emailNum){
        $err->message = "The email already exists!";
    }else{
        //向表中插入数据
        $addUserSql = "INSERT INTO `jaCotta`.`User` (`userName`, `email`, `password`, `phone`) VALUES ('".$name."','".$email."','".$password."','".$phone."');";
        $addUserResult = mysql_query($addUserSql);
        if($addUserResult) {   //注册成功
            $err->advice = true;
            $err->data = $addUserResult;
            $err->message = "Registered successfully";
        }
        else { //系统忙碌,请稍后重试
            $err->message = "The system is busy, please try again later";
        }
    }
}

$register_json = json_encode($err, TRUE);
echo $register_json;