

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
    <link rel="stylesheet" href="../styles/backstage.css">
    <script type="text/javascript" src="../scripts/showTodayOrder.js"></script>
    <link rel="stylesheet" href="../scripts/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
    <script src="../scripts/jquery-ui/js/jquery-1.10.2.js"></script>
    <script src="../scripts/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
    <script src="../scripts/jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
</head>
<body>
<div id="mask">
    
</div>
<div class="details" id="details">

</div>
<script type="text/javascript">
    
    function showDetail(id){
        $("#showDetail"+id).dialog({
            height:"auto",
            width: "auto",
            position: {my: "center", at: "center",  collision:"fit"},
            modal:false,
            draggable:true,
            resizable:true,
            title:"订单详情",
            show:"slide",
            hide:"explode"
        });
    }

    window.onload = function(){
        start();
    }
    function printOrder(id){
        if(window.confirm("您确定要打印吗？打印之后不能恢复!")){
            window.location="../doAdminAction.php?act=printOrder&id="+id;
        }
    }
    
    function changeStates(id,state,page){
        window.location="../doAdminAction.php?act=changeStates&id="+id+"&state="+state+"&page="+page;

    }
   
</script>
</body>
</html>