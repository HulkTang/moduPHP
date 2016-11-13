<?php
    require_once '../../include.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
    <script type='text/javascript' src="../scripts/jquery-ui/js/jquery-1.10.2.js"></script>
    <link rel="stylesheet" href="../styles/common.css">
</head>
<body>
<h3>添加员工</h3>
<form action="../doAdminAction.php" method="post">
    <table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">

        <input type="hidden" name="act" value="addStaff" >
        <tr>
            <td align="right">员工号</td>
            <td><input type="text" name="stf_code" id="stf_code" placehoder="请输入员工号"></td>
        </tr>
        <tr>
            <td align="right">员工姓名</td>
            <td><input type="text" name="stf_name" id="stf_name" placehoder="请输入员工姓名" ></td>
        </tr>
        <tr>
            <td align="right">后台密码</td>
            <td><input type="password" name="stf_password" id="stf_password" placehoder="请输入员工密码" value="<?php echo NORMAL_PSD;?>"></td>
        </tr>
        <tr>
            <td align="right">请再次输入密码</td>
            <td><input type="password" name="stf_password_again" id="stf_password_again" placehoder="请输入员工密码" value="<?php echo NORMAL_PSD;?>"></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" value="添加员工" onclick ="return valid();"></td>
        </tr>
    </table>
</form>

<script type="text/javascript">
    function valid(){
        var newPassword1 = document.getElementById("stf_password").value;
        var newPassword2 = document.getElementById("stf_password_again").value;
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
</body>
</html>