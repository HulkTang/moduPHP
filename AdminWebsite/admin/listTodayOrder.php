

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
    <link rel="stylesheet" href="styles/backstage.css">
    <script type="text/javascript" src="scripts/showTodayOrder.js"></script>
</head>
<body>
<div id="mask">
    
</div>
<div class="details" id="details">

</div>
<script type="text/javascript">
    window.onload = function(){
        start();
    }
    function editCate(id){
        window.location="editOrder.php?id="+id;
    }
    function delCate(id){
        if(window.confirm("您确定要删除吗？删除之后不能恢复!")){
            window.location="doAdminAction.php?act=delOrder&id="+id;
        }
    }
    function test(text){
        alert(text);
    }
   
</script>
</body>
</html>