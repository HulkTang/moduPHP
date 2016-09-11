<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/2
 * Time: 14:18
 */

//产生验证码用到的随机字符串

function buildRandomString(){
    //$chars = join("",array_merge(range("a","z"),range(0,9)));
    $chars = join("",range(0,9));
    $chars = str_shuffle($chars);
    return substr($chars,0,4);
}

function getUniName(){
    return md5(uniqid(microtime(true),true));
}


function getExt($filename){
    $temp = explode(".",$filename);
    return strtolower(end($temp));
}