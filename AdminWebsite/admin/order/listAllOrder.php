<?php
require_once '../../include.php';

$from=isset($_REQUEST['from'])?$_REQUEST['from']:'2016-11-01';
$to=isset($_REQUEST['to'])?$_REQUEST['to']:getCurrentDate();
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
    <script src="../scripts/common.js"></script>
    <link rel="stylesheet" href="../scripts/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
    <script src="../scripts/jquery-ui/js/jquery-1.10.2.js"></script>
    <script src="../scripts/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
    <script src="../scripts/jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
</head>
<body>
<div class="details">
    <div class="details_operation clearfix">
        <div class="fr">
            <div class="text">
                <span>开始日期：</span>
                <div class="bui_select">
                    <input type="text" value="<?php echo isset($_REQUEST['from'])?$_REQUEST['from']:'2016-11-01';?>" class="search" id="fromDate" placeholder="yyyy-MM-dd" onkeypress="search()"/>
                </div>
            </div>
            <div class="text">
                <span>结束日期：</span>
                <div class="bui_select">
                    <input type="text" value="<?php echo isset($_REQUEST['to'])?$_REQUEST['to']:getCurrentDate();?>" class="search" id="toDate" placeholder="yyyy-MM-dd" onkeypress="search()"/>
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
            <th width="5%">桌号</th>
            <th width="15%">下单时间</th>
            <th width="22%">商品</th>
            <th width="7%">原价</th>
            <th width="7%">总价</th>
            <th width="7%">状态</th>
            <th width="7%">打印</th>

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
            <td><?php echo $row['od_fixed_total_price'];?>元</td>
            <td><?php echo $row['od_total_price'];?>元</td>
            <td>
                <?php
                    switch($row['od_state']) {
                        case 0:
                            echo ORDER_STATE_0;
                            break;
                        case 1:
                            echo ORDER_STATE_1;
                            break;
                        case 2:
                            echo ORDER_STATE_2;
                            break;
                    }?>
            </td>
            <td><?php echo $row['od_isprint'];?></td>
            <td align="center">
                <input type="button" value="打印" class="btn" onclick="printOrder(<?php echo $row['od_id'];?>)">
                <input type="button" value="详情" class="btn" onclick="showDetail(<?php echo $row['od_id'];?>)">
                <div id="showDetail<?php echo $row['od_id'];?>" style="display:none;">
                    <table class="table" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="20%"  align="right">优惠券</td>
                            <td><?php echo $row['od_coupon_description'];?> </td>
                        </tr>
                        <?php
                            $od_pros = getProByOrderId($row['od_id']);
                            foreach($od_pros as $od_pro):
                        ?>
                            <tr>
                                <td width="20%"  align="right"><?php echo $od_pro['gd_name'].'*'.$od_pro['gd_quantity'];?></td>
                                <td><?php echo $od_pro['gd_detail'];?> </td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            </td>
        </tr>
    <?php endforeach;?>
    <?php if($totalRows>$pageSize):?>
        <tr>
            <td colspan="9"><?php echo showPage($page, $totalPage,$where='&from='.$from.'&to='.$to);?></td>
        </tr>
    <?php endif;?>
    </tbody>
    </table>
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

    function printOrder(id){
        if(window.confirm("您确定要打印吗？删除之后不能恢复!")){
            window.location="../doAdminAction.php?act=printOrder&id="+id;
        }
    }
    function search(){
        if(event.keyCode==13){
            searchbtn();
        }
    }
    function searchbtn(){
        var from=document.getElementById("fromDate").value;
        var to=document.getElementById("toDate").value;
        if(from=='')
            from = '2016-11-01';
        if(to=='')
              to = getNowFormatDate();
        if(checkDateFormat(from)&&checkDateFormat(to)){
            if(from>to) {
                alert("开始时间不能晚于结束时间");
                return;
            }
            window.location="listAllOrder.php?from="+from+"&to="+to;
        }
        else{
            alert('请输入正确的日期格式!');
        }

    }
</script>
</body>
</html>