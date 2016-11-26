
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
<h3>添加微信端首页图片</h3>
<form action="../doAdminAction.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="act" value="addWeChatIndexPicture" >
    <table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td align="right" >首页图片</td>
            <td>
                <a href="javascript:void(0)" id="selectFileBtn">添加附件</a>
                <div id="attachList" class="clear"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit"  value="添加图片"/></td>
        </tr>

    </table>
</form>
</body>
</html>