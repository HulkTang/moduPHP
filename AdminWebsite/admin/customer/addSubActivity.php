<?php
require_once '../../include.php';
checkLogined();
$rows=getAllCate();
if(!$rows){
    alertMes("没有相应分类，请先添加分类!!", "addCate.php");
}
$today = getCurrentDate();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="../styles/common.css">
    <link href="../styles/global.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="../scripts/jquery-1.6.4.js"></script>
    <script type="text/javascript" src="../scripts/addFile.js"></script>
    <title>Insert title here</title>
</head>
<body>
<h3>添加满减活动</h3>
<form action="../doAdminAction.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="act" value="addSubActivity" >
    <table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td align="right">类型</td>
            <td><input type="text" class='immutable' name="activity_type" value="满减" readonly/></td>
        </tr>
        <tr>
            <td align="right">字段1(满)</td>
            <td><input type="text" name="activity_amount1" /></td>
        </tr>
        <tr>
            <td align="right">字段2(减)</td>
            <td><input type="text" name="activity_amount2" /></td>
        </tr>
        <tr>
            <td align="right">开始日期</td>
            <td><input type="text" name="activity_start_date" value="<?php echo $today;?>" /></td>
        </tr>
        <tr>
            <td align="right">结束日期</td>
            <td><input type="text" name="activity_end_date" value="<?php echo $today;?>" /></td>
        </tr>
        <tr>
            <td align="right">描述</td>
            <td><input type="text" name="activity_description" placeholder="请输入满减活动描述"/></td>
        </tr>
        <tr>
            <td align="right">对应商品类</td>
            <td>
                <?php
                $count = 0;
                foreach($rows as $row):
                    $count++;
                    ?>
                    <input type="checkbox" value="<?php echo $row['ctlg_name'];?>" name="catalogue[]"/><?php echo $row['ctlg_name'];?>
                    <?php if($count%3==0): ?>
                    </br>
                <?php endif; ?>
                <?php endforeach;?>
            </td>
        </tr>
        <tr>
            <td align="right">活动图片</td>
            <td>
                <a href="javascript:void(0)" id="selectFileBtn">添加附件</a>
                <div id="attachList" class="clear"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit"  value="添加满减活动"/></td>
        </tr>

    </table>
</form>

<script type="text/javascript">

</script>
</body>
</html>