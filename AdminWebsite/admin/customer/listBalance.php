<?php
require_once '../../include.php';

$cardNumber=isset($_REQUEST['cardNumber'])?$_REQUEST['cardNumber']:null;
$isEmpty=isset($_REQUEST['isEmpty'])?$_REQUEST['isEmpty']:'EMPTY';

$pageSize=2;
$page=isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
$rows=getBalanceByPage($page,$pageSize,$cardNumber,$isEmpty);

var_dump($page);
var_dump($totalRows);
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
            <input type="button" value="发放优惠券" class="add"  onclick="addBenefit()">
        </div>

        <div class="fr">
            <div class="text">
                <span>卡号：</span>
                <div class="bui_select">
                    <input type="text" value="<?php echo isset($_REQUEST['cardNumber'])?$_REQUEST['cardNumber']:'';?>" class="search" id="cardNumber" placeholder="请输入卡号"/>
                </div>
            </div>
            <div class="text">
                <input type="button" value="搜索" class="btn" onclick="searchbtn()">
            </div>
        </div>
    </div>

    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="15%">卡号</th>
            <th width="5%">等级</th>
            <th width="20%">最后修改时间</th>
            <th width="15%">余额</th>
            <th width="15%">优惠类型</th>
            <th width="15%">优惠剩余</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach($rows as $row):?>
            <tr>
                <td><?php echo $row['blc_card_number'];?></td>
                <td><?php echo $row['blc_card_type'];?></td>
                <td><?php echo $row['blc_last_change'];?></td>
                <td><?php echo $row['blc_balance'];?>元</td>
                <td><?php echo $row['blc_benefit_type'];?></td>
                <td><?php echo $row['blc_benefit_balance'].$row['blc_benefit_unit'];?></td>
                <td align="center"><input type="button" value="发放优惠券" class="btn" onclick="editBenefit(<?php echo $row['id'];?>)"></td>
            </tr>
        <?php endforeach;?>
        <?php if($totalRows>$pageSize):?>
            <tr>
                <td colspan="7"><?php echo showPage($page, $totalPage, $where='&cardNumber='.$cardNumber.'&isEmpty='.$isEmpty);?></td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
</div>
<script type="text/javascript">

    function editBenefit(id){
        window.location='editBenefit.php?id='+id;
    }

    function addBenefit(){
        window.location='addBenefit.php';
    }

    function searchbtn(){
        var cardNumber = document.getElementById("cardNumber").value.trim();
        var isEmpty = 'NOTEMPTY';
        if(cardNumber == '')
            isEmpty = 'EMPTY';
        window.location="listBalance.php?cardNumber="+cardNumber+"&isEmpty="+isEmpty;
    }
</script>
</body>
</html>