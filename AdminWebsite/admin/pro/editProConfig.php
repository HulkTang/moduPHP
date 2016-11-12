<?php

require_once '../../include.php';

$proId=$_REQUEST['id'];
$row = getProConfigById($proId);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="../styles/common.css">
    <title>Insert title here</title>
</head>
<body>
<h3>编辑商品配置选项</h3>
<form action="../doAdminAction.php" method="post">
    <input type="hidden" name="act" value="editProConfig" >
    <input type="hidden" name="id" value="<?php echo $row['id'];?>" >
    <input type="hidden" name="gd_id" value="<?php echo $row['gd_id'];?>" >
    <table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td align="right">商品名称</td>
            <td><input type="text" name="gd_name" class='immutable' value="<?php echo $row['gd_name'];?>" readonly/></td>
        </tr>
        <tr>
            <td align="right">配置类型</td>
            <td>
                <select name="gd_config_type">
                    <option value="1" <?php if($row['gd_config_type'] = "1") echo "selected";?> ><?php echo PRO_CONFIG_1;?></option>
                    <option value="2" <?php if($row['gd_config_type'] = "2") echo "selected";?> ><?php echo PRO_CONFIG_2;?></option>
                    <option value="3" <?php if($row['gd_config_type'] = "3") echo "selected";?> ><?php echo PRO_CONFIG_3;?></option>
                </select>

            </td>
        </tr>
        <tr>
            <td align="right">配置内容</td>
            <td><input type="text" name="gd_config" value="<?php echo $row['gd_config'];?>"/></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit"  value="编辑配置"/></td>
        </tr>

    </table>
</form>
"推荐"的内容请确保与商品名称相同，否则将无法生效。
</body>
</html>