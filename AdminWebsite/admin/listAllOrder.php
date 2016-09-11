<?php

require_once '../include.php';
$pageSize=5;
$page=isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
$rows=getAllOrderByPage($page,$pageSize);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
    <link rel="stylesheet" href="styles/backstage.css">
    <script src="scripts/showTodayOrder.js"></script>
</head>
<body>
<div class="details">
    <div class="details_operation clearfix">
        <div class="bui_select">
            <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addCate()" style="display:none">
        </div>
    </div>

    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="8%">编号</th>
            <th width="7%">桌号</th>
            <th width="18%">下单时间</th>
            <th width="25%">商品</th>
            <th width="7%">总价</th>
            <th width="7%">状态</th>

            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php  foreach($rows as $row):?>
        <tr>
            <td><label for="c1" class="label"><?php echo $row['od_id'];?></label></td>
            <td><?php echo $row['od_desk_id'];?></td>
            <td><?php echo $row['od_date'];?></td>
            <td><?php echo $row['od_string'];?></td>
            <td><?php echo $row['od_total_price'];?></td>
            <td><?php echo $row['od_state'];?></td>
            <td align="center"><input type="button" value="修改" class="btn" onclick="editCate(<?php echo $row['od_id'];?>)"><input type="button" value="删除" class="btn"  onclick="delCate(<?php echo $row['od_id'];?>)"></td>
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
    function editCate(id){
        window.location="editOrder.php?id="+id;
    }
    function delCate(id){
        if(window.confirm("您确定要删除吗？删除之后不能恢复!")){
            window.location="doAdminAction.php?act=delOrder&id="+id;
        }
    }
   
</script>
</body>
</html>