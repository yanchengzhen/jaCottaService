<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/20
 * Time: 17:31
 */
header('Content-Type:application/json;charset=utf-8');
//屏蔽语法错误导致的数据错误
error_reporting(0);
require_once 'instrument/instrument.php';  //调用工具类
include_once("instrument/connect.php");//连接数据库
$err = new responseMessage();
$id = $_POST["id"];                 //分类id
$page = intval($_POST["page"]);
$size = intval($_POST["size"]);

$sqlAll = "SELECT * FROM product WHERE categoryId = $id";   //查询总条数语句
$resAll = mysql_query($sqlAll);
$queryPage = ($page- 1)*$size;
$sqlPage =  "SELECT * FROM `product` WHERE categoryId = $id LIMIT $queryPage , $size";
$resPage = mysql_query($sqlPage);
$i = 0;
$list_arr = array();
if($page){
    while ($list = mysql_fetch_assoc($resPage)) {
        $list_arr[$i] = $list;
        $i++;
    }
}else{
    while ($list = mysql_fetch_assoc($resAll)) {
        $list_arr[$i] = $list;
        $i++;
    }
}


//将商品图片及详情图片字符串转为数组格式
foreach ($list_arr as $k => $v) {
    //        以逗号分隔返回数组     将最后一个逗号删除返回的字符串
    $desArray = explode(",", rtrim($v['productDes'], ","));
    $v['productDes'] = $desArray;
    $picArray = explode(",", rtrim($v['productPic'], ","));
    $v['productPic'] = $picArray;
    $list_arr[$k] = $v;
}
$err->advice = true;
$err->data = $list_arr;
$err->message = mysql_num_rows($resAll);   //总行数
$register_json = json_encode($err, TRUE);
echo $register_json;