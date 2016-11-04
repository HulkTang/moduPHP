<?php
require_once '../../include.php';
$coupon_id=isset($_REQUEST['coupon_id'])?(int)$_REQUEST['coupon_id']:null;
if($coupon_id==null)
    echo 'error!';
else{
    $coupon_duration = getDurationByCouponId($coupon_id);
//    $today=date("Y-m-d H:i:s");
//    $coupon_end_date = date('Y-m-d',strtotime($showtime . '+'.$coupon_duration.' day'));
//    $coupon_end_date = formatToDateYmd($today . '+'.$coupon_duration.' day');
    echo $coupon_duration;
}

?>