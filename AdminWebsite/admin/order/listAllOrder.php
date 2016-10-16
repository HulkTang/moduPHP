<?php
require_once '../../include.php';

$from=isset($_REQUEST['from'])?$_REQUEST['from']:'2016-08-01';
$to=isset($_REQUEST['to'])?$_REQUEST['to']:'2088-08-01';
$pageSize=5;
$page=isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
$rows=getAllOrderByPage($page,$pageSize,$from,$to);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
    <link rel="stylesheet" href="../styles/backstage.css">
    <script src="../scripts/showTodayOrder.js"></script>
</head>
<body>
<div class="details">
    <div class="details_operation clearfix">
        <div class="fr">
            <div class="text">
                <span>开始日期：</span>
                <div class="bui_select">
                    <input type="text" value="<?php echo isset($_REQUEST['from'])?$_REQUEST['from']:'';?>" class="search" id="fromDate" placeholder="2016-08-01" onkeypress="search()"/>
                </div>
            </div>
            <div class="text">
                <span>结束日期：</span>
                <div class="bui_select">
                    <input type="text" value="<?php echo isset($_REQUEST['to'])?$_REQUEST['to']:'';?>" class="search" id="toDate" placeholder="2016-10-01" onkeypress="search()"/>
                </div>
            </div>
            <div class="text">
                <input type="button" value="搜索" class="btn" onclick="searchbtn()">
            </div>
        </div>
    </div>

    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="8%">编号</th>
            <th width="7%">桌号</th>
            <th width="18%">下单时间</th>
            <th width="25%">商品</th>
            <th width="7%">总价</th>
            <th width="7%">状态</th>

            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php  foreach($rows as $row):?>
        <tr>
            <td><label for="c1" class="label"><?php echo $row['od_id'];?></label></td>
            <td><?php echo $row['od_desk_id'];?></td>
            <td><?php echo $row['od_date'];?></td>
            <td><?php echo showFormatedProList($row['od_string']);?></td>
            <td><?php echo $row['od_total_price'];?></td>
            <td><?php echo $row['od_state'];?></td>
            <td align="center"><input type="button" value="打印" class="btn" onclick="printOrder(<?php echo $row['od_id'];?>)"><input type="button" value="删除(无效)" class="btn"  onclick="delCate(<?php echo $row['od_id'];?>)"></td>
        </tr>
    <?php endforeach;?>
    <?php if($totalRows>$pageSize):?>
        <tr>
            <td colspan="7"><?php echo showPage($page, $totalPage,$where='&from='.$from.'&to='.$to);?></td>
        </tr>
    <?php endif;?>
    </tbody>
    </table>
</div>
<script type="text/javascript">
    function printOrder(id){
        if(window.confirm("您确定要打印吗？删除之后不能恢复!")){
            window.location="../doAdminAction.php?act=printOrder&id="+id;
        }
    }
    function delCate(id){
        if(window.confirm("您确定要删除吗？删除之后不能恢复!")){

        }
    }
    function search(){
        if(event.keyCode==13){
            alert("press");
            searchbtn();
        }
    }
    function searchbtn(){
        var from=document.getElementById("fromDate").value;
        var to=document.getElementById("toDate").value;
        if(from=='')
            from = '2016-08-01';
        if(to=='')
            to = '2088-08-01';
        if(from>to) {
            alert("开始时间不能晚于结束时间");
            return;
        }
        window.location="listAllOrder.php?from="+from+"&to="+to;
    }
</script>
</body>
</html>