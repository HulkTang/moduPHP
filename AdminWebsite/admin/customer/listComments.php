<?php

require_once '../../include.php';
$pageSize=6;
$page=isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
$rows=getCommentsByPage($page,$pageSize);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
    <link rel="stylesheet" href="../styles/backstage.css">
</head>
<body>
<div class="details">

    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="10%">姓名</th>
            <th width="20%">手机</th>
            <th width="50%">留言内容</th>
            <th width="10%">发布时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach($rows as $row):?>
            <tr>
                <td><?php echo $row['comment_name'];?></td>
                <td><?php echo $row['comment_phone'];?></td>
                <td><?php echo $row['comment_content'];?></td>
                <td><?php echo $row['comment_date'];?></td>
                <td align="center">
                    <input type="button" value="删除" class="btn"  onclick="delComment(<?php echo $row['comment_id'];?>)">
                </td>
            </tr>
        <?php endforeach;?>
        <?php if($totalRows>$pageSize):?>
            <tr>
                <td colspan="4"><?php echo showPage($page, $totalPage);?></td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
</div>
<script type="text/javascript">

    function delComment(id){
        if(window.confirm("您确定要删除吗？删除之后不能恢复!")){
            window.location="../doAdminAction.php?act=delComment&id="+id;
        }
    }

</script>
</body>
</html>