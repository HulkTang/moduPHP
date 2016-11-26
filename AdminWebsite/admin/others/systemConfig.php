<?php

require_once '../../include.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
</head>
<body>
<h3>系统设置</h3>
<form action="../doAdminAction.php" method="post">
    <input type="hidden" name="act" value="systemConfig" >

    <h4>提示信息</h4>
        <label>
            <input type="radio" name="tips" value="0" onclick="changeShowDisplayTips(0)"
                <?php
                var_dump($GLOBALS['show_display_tips']);
                    if(!$GLOBALS['show_display_tips']) echo "checked=checked;"
                ?>
            />隐藏
        </label>
        <label>
            <input type="radio" name="tips" value="1" onclick="changeShowDisplayTips(1)"
                <?php
                if($GLOBALS['show_display_tips']) echo "checked=checked;"
                ?>
            />显示
        </label>

</form>
<script type="text/javascript">

    function changeShowDisplayTips(token){
        window.location="../doAdminAction.php?act=systemConfig&token="+token;
    }

</script>
</body>
</html>