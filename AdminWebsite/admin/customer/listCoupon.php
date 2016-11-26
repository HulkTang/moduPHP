<?php
require_once '../../include.php';

$cardNumber=$_REQUEST['cardNumber'];
$pageSize=5;
$page=isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
$rows=getCouponByCardNumberByPage($page,$pageSize,$cardNumber);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
    <link rel="stylesheet" href="../styles/backstage.css">
</head>
<body>
<div class="details">

    <div class="details_operation clearfix">

        <div class="bui_select">
            <input type="button" value="发放优惠券" class="add"  onclick="sendCouponToCardNumber(<?php echo $cardNumber;?>)">
        </div>
        
    </div>

    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="10%">卡号</th>
            <th width="5%">类型</th>
            <th width="20%">描述</th>
            <th width="10%">发放日期</th>
            <th width="10%">失效日期</th>
            <th width="5%">剩余</th>
            <th width="30%">适用商品分类</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach($rows as $row):?>
            <tr>
                <td><?php echo $row['coupon_card_number'];?></td>
                <td>
                    <?php
                    switch($row['coupon_type']){
                        case 1:
                            echo COUPON_SUB;
                            break;
                        case 2:
                            echo COUPON_DISCOUNT;
                            break;
                    }
                    ?>
                </td>
                <td><?php echo $row['coupon_description'];?></td>
                <td><?php echo $row['coupon_start_date'];?></td>
                <td><?php echo $row['coupon_end_date'];?></td>
                <td><?php echo $row['coupon_number'];?></td>
                <td><?php echo $row['coupon_catalogue'];?></td>
            </tr>
        <?php endforeach;?>
        <?php if($totalRows>$pageSize):?>
            <tr>
                <td colspan="8"><?php echo showPage($page, $totalPage, $where='&cardNumber='.$cardNumber);?></td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
</div>
<script type="text/javascript">

    function listCouponConfig(){
        window.location='listCouponConfig.php';
    }

    function listCouponByCardNumber(cardNumber){
        window.location='listCoupon.php?cardNumber='+cardNumber;
    }

    function sendCouponToCardNumber(cardNumber){
        window.location='sendCouponToCardNumber.php?cardNumber='+cardNumber;
    }
    
</script>
</body>
</html>