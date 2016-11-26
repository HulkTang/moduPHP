<?php
require_once '../../include.php';



$pageSize=5;
$page=isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
$rows=getCouponConfigByPage($page,$pageSize);


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
            <input type="button" value="配置满减券" class="add"  onclick="addSubCoupon()">
        </div>

        <div class="bui_select" style="margin-left:20px;">
            <input type="button" value="配置折扣券" class="add"  onclick="addDiscountCoupon()">
        </div>

    </div>

    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="7%">类型</th>
            <th width="7%">字段1</th>
            <th width="7%">字段2</th>
            <th width="7%">有效期</th>
            <th width="20%">描述</th>
            <th width="25%">适用商品分类</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach($rows as $row):?>
            <tr>
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
                <td><?php echo $row['coupon_amount1'];?></td>
                <td><?php echo $row['coupon_amount2'];?></td>
                <td><?php echo $row['coupon_duration'];?>日</td>
                <td><?php echo $row['coupon_description'];?></td>
                <td><?php echo $row['coupon_catalogue'];?></td>
                <td align="center">
                    <input type="button" value="删除" class="btn" onclick="delCouponConfig(<?php echo $row['coupon_id'];?>)">
                </td>
            </tr>
        <?php endforeach;?>
        <?php if($totalRows>$pageSize):?>
            <tr>
                <td colspan="7"><?php echo showPage($page, $totalPage);?></td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
</div>
<script type="text/javascript">

    function addSubCoupon(){
        window.location='addSubCoupon.php';
    }

    function addDiscountCoupon(){
        window.location='addDiscountCoupon.php';
    }

    function delCouponConfig(id){
        if(window.confirm("您确定要删除吗？删除之后不能恢复!")){
            window.location="../doAdminAction.php?act=delCouponConfig&id="+id;
        }
    }

  
</script>
</body>
</html>