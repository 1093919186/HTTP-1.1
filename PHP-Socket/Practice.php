<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2020/4/5
 * Time: 15:48
 */

require('./http.class.php');
$http = new Http('http://localhost/Learn/HTTP/PHP-Socket/03.php');


$http->setHeader('Cookie: user=hejialinzi');
$http->setHeader('User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.120 Safari/537.36');


echo $http->get();








