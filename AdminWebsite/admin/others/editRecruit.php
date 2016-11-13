<?php
require_once '../../include.php';
$id = $_REQUEST['id'];
$row = getRecruitById($id);
ob_clean();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
</head>
<body>
<h3>编辑招聘信息</h3>
<form action="../doAdminAction.php?id=<?php echo $id;?>" method="post">
    <input type="hidden" name="act" value="editRecruit" >
    <table width="50%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td align="right">标题</td>
            <td><input name="recruit_title" value="<?php echo $row['recruit_title'];?>" /></td>
        </tr>
        <tr>
            <td align="right">招聘信息</td>
            <td><textarea name="recruit_content" style="width:90%;height:120px;"><?php echo $row['recruit_content'];?></textarea></td>
        </tr>
      
        <tr>
            <td colspan="2" align="center"><input type="submit" value="编辑招聘信息"></td>
        </tr>
    </table>
</form>

</body>
</html>