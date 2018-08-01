<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/10
 * Time: 11:30
 */
//自定义回调类
class responseMessage
{
    public $message = "";
    public $advice = false;
    public $data = null;
}
//user类
class User{
    public $id = null;
    public $userName = null;
    public $email = null;
    public $password = null;
    public $phone = null;
}
//category类
class Category{
    public $id = null;
    public $parentId = null;
    public $categoryName = null;
    public $state = 1;
}
//去除所有空格
function triMall($str)
{
    $oldchar=array(" ","　","\t","\n","\r");
    $newchar=array("","","","","");
    return str_replace($oldchar,$newchar,$str);
}