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
//获取请求类型 GET POST 等
$type = $_SERVER['REQUEST_METHOD'];
$err = new responseMessage();

$sql = "SELECT * FROM category";
$res = mysql_query($sql);
$i = 0;
$list_arr = array(); //所有分类数据
while ($list = mysql_fetch_assoc($res)){
    $list_arr[$i] = $list;
    $i++;
}
$arr1 = []; //重新组合父子关系二维数组
foreach ($list_arr as $k=>$v) {
    if ($v['parentId'] != 0) {
        $v['Level'] = 2;
        $v['ParentId'] = intval($v['parentId']);
    }else{
        $v['Level'] = 1;
        $v['ParentId'] = null;
    }

    $v['id'] = intval($v['id']);
    $arr1[] = $v;
}
$err->advice = true;
$err->data = $arr1;
$err->message = mysql_num_rows($res);   //总行数
$register_json = json_encode($err, TRUE);
echo $register_json;