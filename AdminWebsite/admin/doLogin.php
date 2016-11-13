<?php

require_once "../include.php";
$username = $_POST['username'];
$password = md5($_POST['password']);
$verify = $_POST['verify'];
$verify1 = $_SESSION['verify'];
if(isset($_POST['autoFlag']))
    $autoFlag = $_POST['autoFlag'];
$link = connect();
if($verify==$verify1){
    if(strtoupper($username) == BOSS_CODE)   //只为老板写的登录逻辑
        $sql = "select * from stf_mst where stf_code='{$username}' and stf_password='{$password}';";
    else
        $sql = "select * from stf_mst where stf_code='{$username}' and stf_password='{$password}'
                and stf_authority='admin';";

    $result = checkAdmin($link,$sql);
    if($result){
        $_SESSION['adminCode'] = $result['stf_code'];
        if(isset($autoFlag)&&$autoFlag==1){
            setcookie("adminCode",$result['stf_code'],time()+7*24*3600);
            setcookie("adminPassword",$result['stf_password'],time()+7*24*3600);
        }
        echo "<script>window.location='index.php';</script>";
    }else{
        alertMes("登录失败，重新登录","login.php");
    }
}else{
    alertMes("验证码错误","login.php");
}
