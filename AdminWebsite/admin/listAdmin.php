<?php
require_once '../include.php';
$rows=getAllAdmin();
//$pageSize=2;
//$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
//$rows=getAdminByPage($page,$pageSize);
if(!$rows){
    alertMes("sorry,没有管理员,请添加!","addAdmin.php");
    exit;
}
ob_clean();
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>-.-</title>
    <link rel="stylesheet" href="styles/backstage.css">
</head>

<body>
<div class="details">
    <div class="details_operation clearfix">
        <div class="bui_select">
            <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addAdmin()">
        </div>

    </div>

    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="30%">管理员名称</th>
            <th width="30%">管理员工号</th>
<!--            <th width="40%">店名</th>-->
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach($rows as $row):?>
            <tr>
                <td><label for="c1" class="label"><?php echo $row['stf_name'];?></label></td>
                <td><?php echo $row['stf_code'];?></td>
<!--                <td>--><?php //echo $row['st_name'];?><!--</td>-->
                <td align="center"><input type="button" value="删除" class="btn"  onclick="delAdmin(<?php echo $row['stf_code'];?>)"></td>
            </tr>
        <?php endforeach;?>
<!--        全局变量，定义在admin.inc.php中-->
<!--        --><?php
//            if($totalRows>$pageSize):
//        ?>
<!--            <tr>-->
<!--                <td colspan="4">--><?php //echo showPage($page, $totalPage);?><!--</td>-->
<!--            </tr>-->
<!--        --><?php //endif;?>
        </tbody>
    </table>
</div>
</body>
<script type="text/javascript">

    function addAdmin(){
        window.location="addAdmin.php";
    }

    function delAdmin(id){
        if(window.confirm("您确定要删除吗？删除之后不可以恢复!")){
            window.location="doAdminAction.php?act=delAdmin&id="+id;
        }
    }
</script>
</html>