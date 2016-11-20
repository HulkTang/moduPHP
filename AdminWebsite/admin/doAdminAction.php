<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/3
 * Time: 13:03
 */
require_once "../include.php";
ob_clean();
$act = $_REQUEST['act'];
if($act=="logout"){
    logout();
}
//admin
elseif($act=="addAdmin"){
    $mes = addAdmin();
}elseif($act=='delAdmin'){
    $mes = delAdmin($_REQUEST['id']);
}elseif($act=='changeBossPassword'){
    $mes = changeBossPassword($_REQUEST['oldPassword'],$_REQUEST['newPassword1'],$_REQUEST['newPassword2']);
}elseif($act=='delStaff'){
    $mes = delStaff($_REQUEST['id']);
}elseif($act=='addStaff'){
    $mes = addStaff();
}
//Cate
elseif($act=='addCate'){
    $mes = addCate();
}elseif($act=='delCate'){
    $mes = delCate($_REQUEST['id']);
}elseif($act=='editCate'){
    $mes = editCate($_REQUEST['id']);
}
//Pro
elseif($act=='addPro'){
    $mes = addPro();
}elseif($act=='delPro'){
    $mes = delPro($_REQUEST['id']);
}elseif($act=='editPro'){
    $mes = editPro($_REQUEST['id']);
}elseif($act=='addProConfig'){
    $mes = addProConfig();
}elseif($act=='editProConfig'){
    $mes = editProConfig();
}elseif($act=='delProConfig'){
    $mes = delProConfig($_REQUEST['id']);
}elseif($act=='getQRForPro'){
    $mes = getQRForPro($_REQUEST['id']);
}
//Order
elseif($act=='printOrder'){
    printOrder($_REQUEST['id']);
}
//Customer
elseif($act=='addBenefit'){
    $mes = addBenefit();
}elseif($act=='addSubCoupon'){
    $mes = addSubCoupon();
}elseif($act=='addDiscountCoupon'){
    $mes = addDiscountCoupon();
}elseif($act=='delCouponConfig'){
    $mes = delCouponConfig($_REQUEST['id']);
}elseif($act=='sendCouponToCardNumber'){
    $mes = sendCouponToCardNumber();
}elseif($act=='delActivityConfigForcible'){
    $mes = delActivityConfigForcible($_REQUEST['id']);
}elseif($act=='addDiscountActivity'){
    $mes = addDiscountActivity();
}elseif($act=='addSubActivity'){
    $mes = addSubActivity();
}elseif($act=='delActivityConfig'){
    $mes = delActivityConfig($_REQUEST['id']);
}elseif($act=='delActivityConfigForcible'){
    $mes = delActivityConfigForcible($_REQUEST['id']);
}elseif($act=='delComment'){
    $mes = delComment($_REQUEST['id']);
}
//others
elseif($act=='addRecruit'){
    $mes = addRecruit();
}elseif($act=='delRecruit'){
    $mes = delRecruit($_REQUEST['id']);
}elseif($act=='editRecruit'){
    $mes = editRecruit($_REQUEST['id']);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
</head>
<body>
<?php
if(isset($mes))
    echo $mes;
?>

</body>
</html>
