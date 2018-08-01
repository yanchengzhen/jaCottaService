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
$categoryId = $_POST["categoryId"];                 //分类id
$productName = $_POST["productName"];               //产品名称
$productModel = $_POST["productModel"];             //产品型号
$productUnit = $_POST["productUnit"];               //产品单位
$productPrice = $_POST["productPrice"];             //产品价格
$productIntroduce = $_POST["productIntroduce"];     //产品介绍
$productSize = $_POST["productSize"];               //产品尺寸
$picArr = $_POST['productPic'];                     //商品图片集合
$desArr = $_POST['productDes'];                     //详情图片集合
$productPic = "";                                   //将图片路径拼接, 成字符串保存数据库
$productDes = "";                                   //将图片路径拼接, 成字符串保存数据库
foreach ($picArr as $k) {
    $productPic .= $k . ",";
}
foreach ($desArr as $k) {
    $productDes .= $k . ",";
}

//检测分类名称存在且不为一个控制
if (empty(triMall($productName))) {
    $err->message = "productName is required!";
    $isPerform = false;
}
if (empty(triMall($categoryId))) {
    $err->message = "categoryId is required!";
    $isPerform = false;
}

if ($isPerform) {
    //向表中插入数据
    $addSql = "INSERT INTO `jaCotta`.`product` (`categoryId`, `productName`, `productModel`, `productUnit`, `productPrice`, `productIntroduce`, `productSize`, `productPic`, `productDes`) VALUES ('" . $categoryId . "','" . $productName . "','" . $productModel . "','" . $productUnit . "','" . $productPrice . "','" . $productIntroduce . "','" . $productSize . "','" . $productPic . "','" . $productDes . "');";
    $addResult = mysql_query($addSql);
    if ($addResult) {   //注册成功
        $err->advice = true;
        $err->data = $addResult;
        $err->message = "addProduct successfully";
    } else { //系统忙碌,请稍后重试
        $err->message = "The system is busy, please try again later";
    }
}
$register_json = json_encode($err, TRUE);
echo $register_json;