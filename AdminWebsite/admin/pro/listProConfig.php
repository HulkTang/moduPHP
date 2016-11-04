<?php

require_once '../../include.php';
$pageSize=2;
$page=isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
$proId=isset($_REQUEST['id'])?(int)$_REQUEST['id']:1;
$rows=getProConfigByPage($page,$pageSize,$proId);

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
            <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addProConfig(<?php echo $proId;?>)">
        </div>

    </div>
    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="15%">商品名称</th>
            <th width="15%">配置类型</th>
            <th width="30%">配置内容</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach($rows as $row):?>
            <tr>
                <td><?php echo $row['gd_name'];?></td>
                <td><?php echo $row['gd_config_type'];?></td>
                <td><?php echo $row['gd_config'];?></td>
                <td align="center"><input type="button" value="修改" class="btn" onclick="editProConfig(<?php echo $row['id'];?>)">
                    <input type="button" value="删除" class="btn"  onclick="delProConfig(<?php echo $row['id'];?>)">
                </td>
            </tr>
        <?php endforeach;?>
        <?php if($totalRows>$pageSize):?>
            <tr>
                <td colspan="4"><?php echo showPage($page, $totalPage, 'id='.$proId);?></td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    function editProConfig(id){
        window.location="editProConfig.php?id="+id;
    }
    function delProConfig(id){
        if(window.confirm("您确定要删除吗？删除之后不能恢复!")){
            window.location="../doAdminAction.php?act=delProConfig&id="+id;
        }
    }
    function addProConfig(id){
        window.location="addProConfig.php?id="+id;
    }
</script>
</body>
</html>