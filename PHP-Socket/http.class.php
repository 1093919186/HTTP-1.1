<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2020/4/4
 * Time: 11:13
 */

/* php-socket编程  发送http请求
 * 模拟下载，登录，注册，批量发帖
 * */

//http请求类的接口
interface protocol{
    //连接url
    function conn($url);

    //发送get查询
    function get();

    //发送post查询
    function post();

    //关闭连接
    function close();
}


class Http implements protocol{

    const CRLF = "\r\n";

    protected $errno = -1;
    protected $errstr = '';
    protected $response = '';

    protected $url = null;
    protected $version = 'HTTP/1.1';
    protected $fh = null;

    protected $line = array();
    protected $header = array();
    protected $body = array();

    public function __construct($url)
    {
        $this->conn($url);
        $this->setHeader('Host: ' .$this->url['host']);

    }

    //此方法负责写请求行
    protected function setLine($method){

        $this->line[0] = $method.' '.$this->url['path'].'?'.$this->url['query'].' '. $this->version;
    }
    //此方法负责写头信息
    public function setHeader($headerline){
        $this->header[] = $headerline;
    }
    //次方法负责写主体信息
    protected function setBody($body){
        //用http_build_query这个函数处理%E9%9A%8F%E6%97%B6%E4%BB%BB%E5%8A%A1字符串会出问题
//        $this->body[] = http_build_query($body);
        $http_query = '';
        foreach($body as $k=>$v){
            $http_query .= $k.'='.$v.'&';
        }
        $http_query = substr($http_query, 0, strlen($http_query)-1);
        $this->body[] = $http_query;
    }

    //连接url
    public function conn($url){
        $this->url = parse_url($url);
        //判断端口
        if(!isset($this->url['port'])){
            $this->url['port'] = 80;
        }
        //判断query
        if(!isset($this->url['query'])){
            $this->url['query'] = '';
        }

        $this->fh = fsockopen($this->url['host'], $this->url['port'], $this->errno, $this->errstr, 3);

    }

    //构造get请求的数据
    public function get(){
        $this->setLine('GET');
        $this->request();
        return $this->response;
    }

    //构造post请求的数据
    public function post($body = array()){
        //构造主体信息
        $this->setLine('POST');

        //设置Content-Type
        $this->setHeader('Content-Type: application/x-www-form-urlencoded');

        // 设计主体信息，比GET不一样的地方
        $this->setBody($body);

        //计算Content-Length
        $this->setHeader('Content-Length: '.strlen($this->body[0]));

        $this->request();

        return $this->response;
    }

    //真正请求
    public function request(){
        // 把请求行，头信息，实体信息，放在一个数组里，便于拼接
        $req = array_merge($this->line, $this->header,array(''),$this->body,array(''));
        // print_r($req);
        $req = implode(self::CRLF, $req);

//        print_r($req);
//        exit();

        fwrite($this->fh, $req);

        for($n=0;$n<20000;$n++){
            $current_line = fgets($this->fh);
            if($current_line == "0\r\n"){
                $this->close();  //关闭连接
                return $this->response;
            }else{
                $this->response .= $current_line;
            }
        }

    }

    //关闭连接
    public function close(){
        fclose($this->fh);
    }

}

//$url = 'http://309group.csu.edu.cn/';
//$http = new Http($url);
//echo $http->get();

//关闭执行超时限制，使程序可以永久执行下去
//set_time_limit(0);
//模拟提交也可以登录
//$url = 'http://localhost/workhelp/index.php/Index/suibi';
//$http = new Http($url);
//echo $http->post(array('%E9%9A%8F%E6%97%B6%E4%BB%BB%E5%8A%A1'=>'m245'));