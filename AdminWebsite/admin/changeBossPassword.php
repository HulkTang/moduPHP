<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
</head>

<script type="text/javascript">
    function valid(){
        var newPassword1 = document.getElementById("newPassword1").value;
        var newPassword2 = document.getElementById("newPassword2").value;
        if(newPassword1=="" || newPassword1==null ||newPassword2=="" ||newPassword2==null){
            alert("输入框不能为空!");
            return false;
        }
        if(newPassword1!=newPassword2){
            alert("两次输入的密码不相同!");
            return false;
        }
        return true;
    }
</script>

<body>
<h3>更改密码</h3>
<form action="doAdminAction.php" method="post">
    <table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <!--        表单无法同时以post get传递参数，采用该方法传递。-->
        <input type="hidden" name="act" value="changeBossPassword" >
        <tr>
            <td align="right">原密码</td>
            <td><input type="password" name="oldPassword" id="oldPassword" placehoder="请输入原密码"></td>
        </tr>
        <tr>
            <td align="right">新密码</td>
            <td><input type="password" name="newPassword1" id="newPassword1" placehoder="请输入新密码"></td>
        </tr>
        <tr>
            <td align="right">再次输入新密码</td>
            <td><input type="password" name="newPassword2" id="newPassword2" placehoder="请再次输入新密码"></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" value="更改密码" onclick ="return valid();"></td>
        </tr>
    </table>
</form>



</body>
</html>