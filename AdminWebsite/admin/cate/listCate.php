<?php

require_once '../../include.php';
$pageSize=6;
$page=isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
$rows=getCateByPage($page,$pageSize);
if(!$rows){
    alertMes("sorry,没有分类,请添加!","addCate.php");
    exit;
}

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
            <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addCate()">
        </div>

    </div>
    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="20%">名称</th>
            <th width="40%">描述</th>
            <th width="20%">优先级</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach($rows as $row):?>
            <tr>
                <td><label for="c1" class="label"><?php echo $row['ctlg_name'];?></label></td>
                <td><?php echo $row['ctlg_description'];?></td>
                <td><?php echo $row['ctlg_priority'];?></td>
                <td align="center"><input type="button" value="修改" class="btn" onclick="editCate(<?php echo $row['ctlg_id'];?>)">
                    <input type="button" value="删除" class="btn"  onclick="delCate(<?php echo $row['ctlg_id'];?>)">
                </td>
            </tr>
        <?php endforeach;?>
        <?php if($totalRows>$pageSize):?>
            <tr>
                <td colspan="4"><?php echo showPage($page, $totalPage);?></td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    function editCate(id){
        window.location="editCate.php?id="+id;
    }
    function delCate(id){
        if(window.confirm("您确定要删除吗？删除之后不能恢复!")){
            window.location="../doAdminAction.php?act=delCate&id="+id;
        }
    }
    function addCate(){
        window.location="addCate.php";
    }
</script>
</body>
</html>