<?php

require_once '../../include.php';

$proId=$_REQUEST['id'];
$row = getProById($proId);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="../styles/common.css">
    <title>Insert title here</title>
</head>
<body>
<h3>添加商品配置选项</h3>
<form action="../doAdminAction.php" method="post">
    <input type="hidden" name="act" value="addProConfig" >
    <input type="hidden" name="gd_id" value="<?php echo $row['gd_id'];?>" >
    <table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td align="right">商品名称</td>
            <td><input type="text" name="gd_name" class='immutable' value="<?php echo $row['gd_name'];?>" readonly/></td>
        </tr>
        <tr>
            <td align="right">配置类型</td>
            <td>
                <select name="gd_config_type" >
                    <option value="规格">规格</option>
                    <option value="其他">其他</option>
                    <option value="推荐配菜">推荐配菜</option>
                </select>

            </td>
        </tr>
        <tr>
            <td align="right">配置内容</td>
            <td><input type="text" name="gd_config" placeholder="请输入配置内容"/></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit"  value="添加配置"/></td>
        </tr>

    </table>
</form>
<p>
Tips:</br>
    配置类型选择”推荐配菜“时，配菜名称请确保与商品名称相同，多个配菜请多次配置。</br>

</p>

</body>
</html>