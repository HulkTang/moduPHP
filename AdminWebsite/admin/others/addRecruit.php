
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
</head>
<body>
<h3>添加招聘信息</h3>
<form action="../doAdminAction.php" method="post">
    <!--        表单无法同时以post get传递参数，采用该方法传递。-->
    <input type="hidden" name="act" value="addRecruit" >
    <table width="50%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td align="right">标题</td>
            <td><input name="recruit_title" placeholder="15字以内" /></td>
        </tr>
        <tr>
            <td align="right">招聘信息</td>
            <td><textarea name="recruit_content" placeholder="100字以内" style="width:90%;height:120px;"></textarea></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit"  value="添加招聘信息"/></td>
        </tr>

    </table>
</form>
</body>
</html>