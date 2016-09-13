<?php
require_once '../include.php';

$from=isset($_REQUEST['from'])?$_REQUEST['from']:'2016-08-01';
$to=isset($_REQUEST['to'])?$_REQUEST['to']:'2088-08-01';

$pageSize=5;
$page=isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
$rows=getSalesByPage($page,$pageSize,$from,$to);
$income=getIncomeByDate($from,$to);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
    <link rel="stylesheet" href="styles/backstage.css">
    <script src="scripts/showTodayOrder.js"></script>
</head>
<body>
<div class="details">
    <div class="details_operation clearfix">
        <div class="fr">
            <div class="text">
                <span>开始日期：</span>
                <div class="bui_select">
                    <input type="text" value="<?php echo isset($_REQUEST['from'])?$_REQUEST['from']:'';?>" class="search" id="fromDate" placeholder="2016-08-01"/>
                </div>
            </div>
            <div class="text">
                <span>结束日期：</span>
                <div class="bui_select">
                    <input type="text" value="<?php echo isset($_REQUEST['to'])?$_REQUEST['to']:'';?>" class="search" id="toDate" placeholder="2088-08-01"/>
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
            <th width="35%">商品名称</th>
            <th width="35%">商品销量</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach($rows as $row):?>
            <tr>
                <td><?php echo $row['gd_name'];?></td>
                <td><?php echo $row['gd_total_quantity'];?></td>
                <td align="center"><input type="button" value="修改(无效)" class="btn" onclick="editCate(<?php echo $row['gd_name'];?>)"><input type="button" value="删除(无效)" class="btn"  onclick="delCate(<?php echo $row['gd_name'];?>)"></td>
            </tr>
        <?php endforeach;?>
        <?php if($totalRows>$pageSize):?>
            <tr>
                <td colspan="7"><?php echo showPage($page, $totalPage,$where='&from='.$from.'&to='.$to);?></td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>

    <br>
    <div><?php echo $from.'~'.$to.' ';?>总销售额:<?php echo $income['od_total_income']; ?>元</div>
</div>
<script type="text/javascript">
    function editCate(id){
        window.location="editOrder.php?id="+id;
    }
    function delCate(id){
        if(window.confirm("您确定要删除吗？删除之后不能恢复!")){
            window.location="doAdminAction.php?act=delOrder&id="+id;
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
        window.location="listAllSales.php?from="+from+"&to="+to;
    }

</script>
</body>
</html>