<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/18
 * Time: 16:25
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
$id = $_POST["id"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$userName = $_POST["userName"];
//检测用户名存在且不是一个空格
if(empty(triMall($email))){
    $err->message = "email is required!";
    $isRegister = false;
}
if(empty(triMall($phone))){
    $err->message = "phone is required!";
    $isRegister = false;
}
if(empty(triMall($userName))){
    $err->message = "userName is required!";
    $isRegister = false;
}
//查找邮箱是否存在
$emailSql = "select * from user where email = '$email'";
$emailResult = mysql_query($emailSql);
$emailNum = mysql_num_rows($emailResult); //统计执行结果影响的行数
//查找手机号是否存在
$phoneSql = "select * from user where phone = '$phone'";
$phoneResult = mysql_query($phoneSql);
$phoneNum = mysql_num_rows($phoneResult); //统计执行结果影响的行数

if($isRegister){
    if($emailNum){  //如果已经存在
        $err->message = "The email does not exist!";
    }elseif($phoneNum){
        $err->message = "The phone already exists!";
    }else{
        //修改用户信息
        $sql = "UPDATE user SET userName = '$userName', email = '$email', phone = '$phone' WHERE id = '$id';";
        $result = mysql_query($sql); //返回的是当前数据的位置
        $user = new User();
        if($result) {   //修改成功
            $selectUserSql = "SELECT * FROM user WHERE id = '$id'";
            $selectUserResult = mysql_query($selectUserSql); //返回的是当前数据的位置
            $userArray = mysql_fetch_array($selectUserResult);   //通过便利查询这条表的数据
            $user->id = $userArray["id"];
            $user->userName = $userArray["userName"];
            $user->email = $userArray["email"];
            $user->password = $userArray["password"];
            $user->phone = $userArray["phone"];
            $err->advice = true;
            $err->data = $user;
            $err->message = "Update successfully";
        }else{ //密码错误
            $err->message = "Server error, please contact the administrator";
        }
    }
}
$login_json = json_encode($err, TRUE);
echo $login_json;