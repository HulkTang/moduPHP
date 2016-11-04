<?php

function alertMes($mes,$url){
    echo "<script>alert('{$mes}');</script>";
    echo "<script>window.location='{$url}';</script>";
}


function getLoginUser(){
    if(isset($_SESSION['adminCode'])){
        return $_SESSION['adminCode'];
    }elseif(isset($_COOKIE['adminCode'])){
        return $_COOKIE['adminCode'];
    }
}

function getFileNameThroughPath($filePath){
    $arr = explode("/",$filePath);
    $length = count($arr);
    return $arr[$length-1];
}

function formatToDateYmd($time){
    $time = strtotime($time);
    $Date = date('Y',$time)."-".date('m',$time)."-".date('d',$time);
    return $Date;
}


function getRecommendPro($left,$right){
    //生成随机数
    if($left>$right)
        return getRecommendPro($right,$left);
    $arr=range($left,$right);
    shuffle($arr);
    return $arr[0];
}

//YYYY-mm-dd
function checkDateFormat($date) {

    if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts)) {
        if (checkdate($parts[2], $parts[3], $parts[1])) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
    
    

} 
