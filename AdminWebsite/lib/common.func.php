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
