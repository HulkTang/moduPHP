
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
</head>
<body>
<h3>添加分类</h3>
<form action="../doAdminAction.php" method="post">
    <!--        表单无法同时以post get传递参数，采用该方法传递。-->
    <input type="hidden" name="act" value="addCate" >
    <table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td align="right">分类名称</td>
            <td><input type="text" name="ctlg_name" placeholder="请输入分类名称"/></td>
        </tr>
        <tr>
            <td align="right">分类描述</td>
            <td><input type="text" name="ctlg_description" placeholder="请输入分类描述"/></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit"  value="添加分类"/></td>
        </tr>

    </table>
</form>
</body>
</html>