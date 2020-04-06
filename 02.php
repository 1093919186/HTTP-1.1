<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2020/4/3
 * Time: 22:15
 */

//对重定向的地址都是GET请求
//重定向
//header('Location: http://www.baidu.com');   //返回302状态码

//指定用301重定向
//header('Location: https://www.baidu.com',true,301);

//-------------------------------------------
//301/302都是不能带数据的，如果要重定向后把数据也重定向需要用307重定向
header('Location: 03.php',true,307);