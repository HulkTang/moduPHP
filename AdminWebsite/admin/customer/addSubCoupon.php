<?php
require_once '../../include.php';
checkLogined();
$rows=getAllCate();
if(!$rows){
    alertMes("没有相应分类，请先添加分类!!", "addCate.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="../styles/common.css">
    <title>Insert title here</title>
</head>
<body>
<h3>添加满减券</h3>
<form action="../doAdminAction.php" method="post">
    <input type="hidden" name="act" value="addSubCoupon" >
    <table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td align="right">类型</td>
            <td><input type="text" class='immutable' name="coupon_type" value="满减" readonly/></td>
        </tr>
        <tr>
            <td align="right">字段1(满)</td>
            <td><input type="text" name="coupon_amount1" /></td>
        </tr>
        <tr>
            <td align="right">字段(减)</td>
            <td><input type="text" name="coupon_amount2" /></td>
        </tr>
        <tr>
            <td align="right">有效期(日)</td>
            <td><input type="text" name="coupon_duration" /></td>
        </tr>
        <tr>
            <td align="right">描述</td>
            <td><input type="text" name="coupon_description" placeholder="请输入满减券描述"/></td>
        </tr>
        <tr>
            <td align="right">对应商品类</td>
            <td>
                <?php
                    $count = 0;
                    foreach($rows as $row):
                        $count++;
                ?>
                    <input type="checkbox" value="<?php echo $row['ctlg_name'];?>" name="catalogue[]"/><?php echo $row['ctlg_name'];?>
                    <?php if($count%3==0): ?>
                        </br>
                    <?php endif; ?>
                <?php endforeach;?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit"  value="添加满减券"/></td>
        </tr>

    </table>
</form>
</body>
</html>