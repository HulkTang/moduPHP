<?php

require_once '../../include.php';
$pageSize=6;
$page=isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
$rows=getStaffByPage($page,$pageSize);

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
            <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addStaff()">
        </div>

    </div>
    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="20%">工号</th>
            <th width="20%">名称</th>
            <th width="20%">权限</th>

            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach($rows as $row):?>
            <tr>
                <td><?php echo $row['stf_code'];?></td>
                <td><?php echo $row['stf_name'];?></td>
                <td><?php 
                    switch($row['stf_authority']) {
                        case "admin":
                            echo "管理员";
                            break;
                        case "normal":
                            echo "普通";
                            break;
                    }
                    ?>

                </td>
                <td align="center">
                    <input type="button" value="删除" class="btn"  onclick="delStaff(<?php echo $row['stf_id'];?>)">
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
    function delStaff(id){
        if(window.confirm("您确定要删除吗？删除之后不能恢复!")){
            window.location="../doAdminAction.php?act=delStaff&id="+id;
        }
    }
    function addStaff(){
        window.location="addStaff.php";
    }
</script>
</body>
</html>