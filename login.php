<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/18
 * Time: 9:23
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
$email = $_POST["email"];
$password = $_POST["password"];
//检测用户名存在且不是一个空格
if(empty(triMall($email))){
    $err->message = "email is required!";
    $isRegister = false;
}
if(empty(triMall($password))){
    $err->message = "password is required!";
    $isRegister = false;
}
//查找邮箱是否存在
$emailSql = "select * from user where email = '$email'";
$emailResult = mysql_query($emailSql);
$emailNum = mysql_num_rows($emailResult); //统计执行结果影响的行数

if($isRegister){
    if($emailNum==0){  //如果不存在
        $err->message = "The email does not exist!";
    }else{
        //登录
        $loginSql = "SELECT * FROM user WHERE password = '$password' AND email = '$email'";
        $loginResult = mysql_query($loginSql); //返回的是当前数据的位置
        $userArray = mysql_fetch_array($loginResult);   //通过便利查询这条表的数据
        $rows = mysql_num_rows($loginResult);
        $user = new User();
        if($rows == 1) {   //登录成功
            $user->id = $userArray["id"];
            $user->userName = $userArray["userName"];
            $user->email = $userArray["email"];
            $user->password = $userArray["password"];
            $user->phone = $userArray["phone"];
            $err->advice = true;
            $err->data = $user;
            $err->message = "Login successfully";
        }else{ //密码错误
            $err->message = "Incorrect password";
        }
    }
}
$login_json = json_encode($err, TRUE);
echo $login_json;