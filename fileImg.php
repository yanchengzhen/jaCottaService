<?php
date_default_timezone_set("PRC");
require_once 'instrument/instrument.php';  //调用工具类

$err = new responseMessage();
$upFile = $_FILES['file'];
/**
 * 创建文件夹函数,用于创建保存文件的文件夹
 * @param str $dirPath 文件夹名称
 * @return str $dirPath 文件夹名称
 */
function creaDir($dirPath){
    $curPath = dirname(__FILE__);
    $path = $curPath.'\\'.$dirPath;
    if (is_dir($path) || mkdir($path,0777,true)) {
        return $dirPath;
    }
}

//判断文件是否为空或者出错
if ($upFile['error']==0 && !empty($upFile)) {
    $allowtype=array("png", "gif", "jpg", "jpeg");
    $arr=explode(".",$_FILES['file']['name']);
    $hz=$arr[count($arr)-1];
    if(!in_array($hz, $allowtype)){
        $err->message = "This type is not allowed!";
        exit;
    }
    $randname=date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999).".".$hz;
    $dirpath = creaDir('productImg');
    $queryPath = $dirpath.'/'.$randname;
    //move_uploaded_file将浏览器缓存file转移到服务器文件夹
    if(move_uploaded_file($_FILES['file']['tmp_name'],$queryPath)){
        $err->advice = true;
        $err->data = $queryPath;
        $err->message = "fileImg successfully";
    }else{
        $err->message = "The system is busy, please try again later";
    }
}
$register_json = json_encode($err, TRUE);
echo $register_json;