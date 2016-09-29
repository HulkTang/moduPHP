<?php
require_once '../../include.php';

$cardNumber=isset($_REQUEST['cardNumber'])?$_REQUEST['cardNumber']:null;
$isEmpty=isset($_REQUEST['isEmpty'])?$_REQUEST['isEmpty']:'EMPTY';

$pageSize=2;
$page=isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
$rows=getBalanceChangeByPage($page,$pageSize,$cardNumber,$isEmpty);

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
            <th width="30%">卡号</th>
            <th width="20%">充值/消费时间</th>
            <th width="15%">变动金额</th>
            <th width="15%">当前余额</th>

            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach($rows as $row):?>
            <tr>
                <td><?php echo $row['blc_card_number'];?></td>
                <td><?php echo $row['chg_date'];?></td>
                <td>
                    <?php
                        if($row['chg_amount']<0):
                            echo "消费".(-1)*$row['chg_amount']."元";
                        else:
                            echo "充值".$row['chg_amount']."元";
                        endif;
                    ?>
                </td>
                <td><?php echo $row['chg_after_amount'];?>元</td>
                <td align="center"><input type="button" value="删除(无效)" class="btn" onclick="delCate(<?php echo $row['blc_card_number'];?>)"></td>
            </tr>
        <?php endforeach;?>
        <?php if($totalRows>$pageSize):?>
            <tr>
                <td colspan="5"><?php echo showPage($page, $totalPage, $where='&cardNumber='.$cardNumber.'&isEmpty='.$isEmpty);?></td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
</div>
<script type="text/javascript">

    function delCate(id){
        if(window.confirm("您确定要删除吗？删除之后不能恢复!")){
            window.location="../doAdminAction.php?act=delCate&id="+id;
        }
    }

    function searchbtn(){
        var cardNumber = document.getElementById("cardNumber").value.trim();
        var isEmpty = 'NOTEMPTY';
        if(cardNumber == '')
            isEmpty = 'EMPTY';
        window.location="listBalanceChange.php?cardNumber="+cardNumber+"&isEmpty="+isEmpty;
    }

</script>
</body>
</html>