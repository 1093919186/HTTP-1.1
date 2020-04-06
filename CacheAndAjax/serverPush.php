<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2020/4/6
 * Time: 20:32
 */

set_time_limit(0);
ob_start();

$empty = str_repeat(' ', 4000);
echo $empty, '<br/>';
ob_flush();
flush();  //把产生的内容立即送给浏览器，而不要等脚本结束一起送

$conn = mysql_connect('localhost','root','');
mysql_query('use bignews');

while(1){
    $sql = 'select articleId from newsarticles';
    $rs = mysql_query($sql, $conn);
    $row = mysql_fetch_assoc($rs);

    if(!empty($row)){
        echo $empty,'<br/>';
        echo $row['articleId'],'<br/>';
    }

//    echo $empty, '<br/>';
//    echo $i, '<br/>';
    ob_flush();
    flush();  //把产生的内容立即送给浏览器，而不要等脚本结束一起送
    sleep(1);
}

/*
 * 思考：如果while循环中不是1,2,3。。。
 * 而是数据库中的内容呢？
 * 而是2人的聊天记录呢？
 * 这样就能达到即时通信
 *
 * 服务器端---不间断---推送信息---到客户端
 * */