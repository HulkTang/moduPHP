<?php

require_once '../../include.php';
$pageSize=2;
$page=isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
$rows=getBalanceChangeByPage($page,$pageSize);


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

    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="30%">openId</th>
            <th width="20%">充值/消费时间</th>
            <th width="15%">变动金额</th>
            <th width="15%">当前余额</th>

            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach($rows as $row):?>
            <tr>
                <td><?php echo $row['chg_openid'];?></td>
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
                <td align="center"><input type="button" value="删除(无效)" class="btn" onclick="delCate(<?php echo $row['chg_openid'];?>)"></td>
            </tr>
        <?php endforeach;?>
        <?php if($totalRows>$pageSize):?>
            <tr>
                <td colspan="5"><?php echo showPage($page, $totalPage);?></td>
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

</script>
</body>
</html>