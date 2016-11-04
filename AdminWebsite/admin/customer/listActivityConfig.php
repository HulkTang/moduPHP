<?php
require_once '../../include.php';

$pageSize=5;
$page=isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
$rows=getActivityConfigByPage($page,$pageSize);


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
            <input type="button" value="配置满减活动" class="add"  onclick="addSubActivity()">
        </div>

        <div class="bui_select" style="margin-left:20px;">
            <input type="button" value="配置折扣活动" class="add"  onclick="addDiscountActivity()">
        </div>

    </div>

    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="7%">类型</th>
            <th width="7%">字段1</th>
            <th width="7%">字段2</th>
            <th width="7%">开始日期</th>
            <th width="7%">结束日期</th>
            <th width="20%">描述</th>
            <th width="25%">对应商品种类</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach($rows as $row):?>
            <tr>
                <td><?php echo $row['activity_type'];?></td>
                <td><?php echo $row['activity_amount1'];?></td>
                <td><?php echo $row['activity_amount2'];?></td>
                <td><?php echo $row['activity_start_date'];?></td>
                <td><?php echo $row['activity_end_date'];?></td>
                <td><?php echo $row['activity_description'];?></td>
                <td><?php echo $row['activity_catalogue'];?></td>
                <td align="center">
                    <input type="button" value="删除" class="btn" onclick="delActivityConfig(<?php echo $row['activity_id'];?>)">
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

    function addSubActivity(){
        window.location='addSubActivity.php';
    }

    function addDiscountActivity(){
        window.location='addDiscountActivity.php';
    }

    function delActivityConfig(id){
        if(window.confirm("您确定要删除吗？删除之后不能恢复!")){
            window.location="../doAdminAction.php?act=delActivityConfig&id="+id;
        }
    }


</script>
</body>
</html>