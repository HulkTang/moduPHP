<?php
require_once '../../include.php';
checkLogined();
$rows=getAllBenefitsType();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
    <script type='text/javascript' src="../scripts/jquery-ui/js/jquery-1.10.2.js"></script>
</head>
<body>
<h3>发放优惠</h3>
<form action="../doAdminAction.php" method="post">
    <input type="hidden" name="act" value="addBenefit" >
    <table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td align="right">卡号</td>
            <td><input type="text" name="blc_card_number" id="blc_card_number" value="" placeholder="请输入卡号" onblur="getCardType()"/></td>
        </tr>
        <tr>
            <td align="right">等级</td>
            <td><input type="text" name="blc_card_type" id="blc_card_type" value="" readonly="readonly"/></td>
        </tr>
        <tr>
            <td align="right">优惠类型</td>
            <td>
                <select name="blc_benefit_type" id="blc_benefit_type" onchange="setUnit()">
                    <?php foreach($rows as $row):?>
                        <option value="<?php echo $row['blc_benefit_type'];?>" id="<?php echo $row['blc_benefit_unit'];?>">
                            <?php echo $row['blc_benefit_type'];?>
                        </option>
                    <?php endforeach;?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right">单位</td>
            <td><input type="text" id='unit' name="blc_benefit_unit" value="<?php echo $rows[0]['blc_benefit_unit'];?>" readonly/></td>
        </tr>
        <tr>
            <td align="right">发放数量</td>
            <td><input type="text" name="blc_benefit_balance" placeholder="请输入发放优惠券的数量"/></td>
        </tr>

        <tr>
            <td colspan="2" align="center"><input type="submit"  value="发放优惠"/></td>
        </tr>

    </table>
</form>
<script type="application/javascript">

    function setUnit(){
        var myselect = document.getElementById("blc_benefit_type");
        var index=myselect.selectedIndex;
        document.getElementById('unit').setAttribute('value',myselect.options[index].id);
    }
    
   function getCardType(){
        var cardNumber = document.getElementById('blc_card_number').value;
        $.ajax({
            type: 'POST',
            url: '../../ajax/showCardTypeForCardNumber.php',
            success:function(data){document.getElementById('blc_card_type').value = data},
            data:{cardNumber:cardNumber}
        });
    }
</script>
</body>
</html>