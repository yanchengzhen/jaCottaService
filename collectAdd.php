<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/27
 * Time: 11:44
 */
header('Content-Type:application/json;charset=utf-8');
//屏蔽语法错误导致的数据错误
error_reporting(0);
require_once 'instrument/instrument.php';  //调用工具类
include_once("instrument/connect.php");//连接数据库
$err = new responseMessage();
$isPerform = true;      //是否可以执行
//获取到的值
$uid = intval($_POST["uid"]);                 //用户id
$pid = intval($_POST["pid"]);                 //产品id
$createTime = date("Y-m-d H:i:s",time());

//检测分类名称存在且不为一个控制
if (empty(triMall($uid))) {
    $err->message = "uid is required!";
    $isPerform = false;
}
if (empty(triMall($pid))) {
    $err->message = "pid is required!";
    $isPerform = false;
}

//查找是否已经收藏
$selectSql = "select * from collect where uid = '$uid'and pid = '$pid'";
$selectResult = mysql_query($selectSql);
$selectNum = mysql_num_rows($selectResult); //统计执行结果影响的行数
if ($isPerform) {
    if($selectNum) {   //如果已经收藏
        $err->message = "The product has been collected!";
    }else{
        //向表中插入数据
        $addSql = "INSERT INTO `jaCotta`.`collect` (`uid`, `pid`, `createTime`) VALUES ('" . $uid . "','" . $pid . "','" . $createTime . "');";
        $addResult = mysql_query($addSql);
        if ($addResult) {   //成功
            $err->advice = true;
            $err->data = $addResult;
            $err->message = "addProduct successfully";
        } else { //系统忙碌,请稍后重试
            $err->message = "The system is busy, please try again later";
        }
    }
}
$register_json = json_encode($err, TRUE);
echo $register_json;