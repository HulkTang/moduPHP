<?php
require_once '../include.php';
$ctlg_id = $_REQUEST['id'];
$row = getOneCate($ctlg_id);
ob_clean();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
</head>
<body>
<h3>编辑分类</h3>
<form action="doAdminAction.php?id=<?php echo $ctlg_id;?>" method="post">
    <input type="hidden" name="act" value="editCate" >
    <table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td align="right">分类名称</td>
            <td><input type="text" name="ctlg_name" value="<?php echo $row['ctlg_name'];?>" placeholder="请输入分类名称"/></td>
        </tr>
        <tr>
            <td align="right">分类描述</td>
            <td><input type="text" name="ctlg_description" value="<?php echo $row['ctlg_description'];?>" placeholder="请输入分类描述"/></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" value="编辑分类"></td>
        </tr>
    </table>
</form>

</body>
</html>