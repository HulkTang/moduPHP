<?php
require_once '../../include.php';
checkLogined();
$types=getAllCardType();
$rows=getAllCouponConfig();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
    <link rel="stylesheet" href="../styles/common.css">
    <script type='text/javascript' src="../scripts/jquery-ui/js/jquery-1.10.2.js"></script>
    <script type='text/javascript' src="../scripts/common.js"></script>
</head>
<body>
<h3>群体发放</h3>
<form action="../doAdminAction.php" method="post">
    <input type="hidden" name="act" value="sendCouponToCardType" >
    <table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td align="right">会员卡等级</td>
            <td>
                <select name="blc_card_type">
                    <?php foreach($types as $type):?>
                        <option value="<?php echo $type['blc_card_type'];?>"><?php echo $type['blc_card_type'];?></option>
                    <?php endforeach;?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right">优惠券类型</td>
            <td>
                <select name="coupon_id" id="coupon_id" onchange="setCouponEndDate()">
                    <option value="" disabled selected ></option>
                    <?php foreach($rows as $row):?>
                        <option value="<?php echo $row['coupon_id'];?>" >
                            <?php echo $row['coupon_description'].'/'.$row['coupon_catalogue'];?>
                        </option>
                    <?php endforeach;?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right">发放日期</td>
            <td><input type="text" class='immutable' name="coupon_start_date" id="coupon_start_date" value="" readonly="readonly"/></td>
        </tr>
        <tr>
            <td align="right">失效日期</td>
            <td><input type="text" class='immutable' name="coupon_end_date" id="coupon_end_date" value="" readonly="readonly"/></td>
        </tr>
        <tr>
            <td align="right">发放数量</td>
            <td><input type="text" name="coupon_number" placeholder="请输入发放优惠券的数量"/></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit"  value="发放优惠券"/></td>
        </tr>

    </table>
</form>
<script type="application/javascript">

    window.onload = getCouponStartDate();
    function getCouponStartDate(){
        document.getElementById('coupon_start_date').value = getNowFormatDate();
    }

    function setCouponEndDate(){
        var startDate = document.getElementById('coupon_start_date').value;
        var myselect = document.getElementById("coupon_id");
        var index=myselect.selectedIndex;
        var coupon_id = myselect.options[index].value;
        $.ajax({
            type: 'POST',
            url: '../../ajax/cardNumber/getCouponDurationDays.php',
            success:
                function(data){
                    document.getElementById('coupon_end_date').value = addDate(startDate, parseInt(data));
                },
            data:{coupon_id:coupon_id}
        });
    }

    function getCardNumberVerified(){
        var cardNumber = $("#coupon_card_number").val;
        $.ajax({
            type: 'POST',
            url: '../../ajax/cardNumber/getCardNumberVerified.php',
            success:
                function(data){
                    $("#coupon_card_number").val(data);
                },
            data:{cardNumber:cardNumber}
        });
    }
</script>
</body>
</html>