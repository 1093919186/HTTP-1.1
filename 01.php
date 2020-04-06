<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2020/4/3
 * Time: 20:13
 */

//链接服务器的80端口：telnet 192.168.43.91 80  (ip用ipconfig查)
//连接上后按ctrl+] 按回车 打开回显功能
/* 请求头：
POST /Learn/HTTP/http.class.php HTTP/1.1
Host: localhost
Content-Type: application/x-www-form-urlencoded    //POST，请求头中必须要加这句
Content-Length: 22    //必须在请求头中标明请求主体的长度

username=maxiqi&age=24
*/

$str = implode($_POST, "\n");
file_put_contents('./post.txt', $str);
echo 'write OK';