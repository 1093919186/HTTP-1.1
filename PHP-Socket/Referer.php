<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2020/4/5
 * Time: 17:59
 */

require('./http.class.php');

$http = new Http('http://localhost/Learn/HTTP/PHP-Socket/gwheader.jpg');

//摆脱防盗链
$http->setHeader('Referer: http://localhost');

$result = $http->get();

//判断图片格式
$infoall = substr($result, 0,strripos($result,"\r\n\r\n"));
$imageType = substr(strrchr($infoall,"/"),1);

//生成图片
if($imageType=='jpeg') {
    file_put_contents('./refererImage1.jpg', substr(strstr($result, "\r\n\r\n"), 4));
}elseif($imageType=='png'){
    file_put_contents('./refererImage1.png', substr(strstr($result, "\r\n\r\n"), 4));
}else{
    //先不写
}
echo 'success';