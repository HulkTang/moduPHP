<?php
$link = connect();

//today
function getTodayOrder(){
    global $link;
    $sql="select od_id,od_desk_id,od_date,od_string,od_total_price,od_state from od_hdr;";
    $rows=fetchAll($link,$sql);
    return $rows;
}


function getTodayOrderByPage($page,$pageSize){
    $currentDate = getCurrentDate();

    global $link;
    $sql="select * from od_hdr where date(od_date) = '{$currentDate}';";
    global $totalRows;
    $totalRows=getResultNum($link,$sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pageSize);
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>=$totalPage)$page=$totalPage;
    $offset=($page-1)*$pageSize;
    $sql="select od_id,od_desk_id,od_date,od_string,od_fixed_total_price,od_total_price,od_state,od_isprint,od_coupon_description from od_hdr where date(od_date) = '{$currentDate}' order by od_date desc limit {$offset},{$pageSize};";
    $rows=fetchAll($link,$sql);

    return $rows;
}

function changeStates($id, $state, $page){
    if($state==0)
        alertMes("订单未付款！",'order/listTodayOrder.php?page='.$page);
    if($state==2)
        alertMes("订单已出！",'order/listTodayOrder.php?page='.$page);
    if($state==1){
        global $link;
        $arr['od_state'] = 2;
        update($link,"od_hdr",$arr,"od_id={$id}");
        echo "<script>window.location = 'order/listTodayOrder.php?page='+$page;</script>";
    }

}

//other day
function getOtherDaysOrderNum(){
    $currentDate = getCurrentDate();
    global $link;
    $sql="select * from od_hdr where date(od_date) != '{$currentDate}';";
    return getResultNum($link,$sql);
}

function getAllOrderByPage($page,$pageSize,$from,$to){

    global $link;
    $sql="select * from od_hdr where date(od_hdr.od_date)>='{$from}' and date(od_hdr.od_date)<='{$to}';";
    global $totalRows;
    $totalRows=getResultNum($link,$sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pageSize);
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>=$totalPage)$page=$totalPage;
    $offset=($page-1)*$pageSize;
    $sql="select od_id,od_desk_id,od_date,od_string,od_fixed_total_price,od_total_price,od_state,od_isprint,od_coupon_description from od_hdr where date(od_hdr.od_date)>='{$from}' and date(od_hdr.od_date)<='{$to}' order by od_date desc limit {$offset},{$pageSize};";
    $rows=fetchAll($link,$sql);

    return $rows;
}

function showFormatedProList($proOfOrder){
    $arr = explode(";",$proOfOrder);
    $formatedArr = '';
    foreach($arr as $a):
        $formatedArr = $formatedArr.$a.'</br>';
    endforeach;
    $formatedArr = substr($formatedArr,0,-5);
    return $formatedArr;
}

//analyze sales
function getSalesByPage($page,$pageSize,$from,$to){
    global $link;
    $sql="select distinct(od_ln.gd_name) from od_hdr,od_ln where date(od_hdr.od_date)>='{$from}' and date(od_hdr.od_date)<='{$to}' and od_hdr.od_id = od_ln.od_id;";
    global $totalRows;
    $totalRows=getResultNum($link,$sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pageSize);
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>=$totalPage)$page=$totalPage;
    $offset=($page-1)*$pageSize;
    $sql="select od_ln.gd_name,sum(od_ln.gd_quantity) as gd_total_quantity from od_hdr,od_ln where date(od_hdr.od_date)>='{$from}' and date(od_hdr.od_date)<='{$to}' and od_hdr.od_id = od_ln.od_id group by od_ln.gd_name order by sum(od_ln.gd_quantity) desc limit {$offset},{$pageSize};";
    $rows=fetchAll($link,$sql);

    return $rows;
}

function getIncomeByDate($from,$to){
    global $link;
    $sql="select sum(od_total_price) as od_total_income from od_hdr where date(od_hdr.od_date)>='{$from}' and date(od_hdr.od_date)<='{$to}';";
    $row=fetchOne($link,$sql);
    return $row;
}

//function printOrder($id){
//    global $link;
//    $sql="select od_id,od_desk_id,od_date,od_string,od_total_price,od_state from od_hdr where od_id = '{$id}';";
//    $row=fetchOne($link,$sql);
//    $od_id = $row['od_id'];//订单编号
//    $od_desk_id = $row['od_desk_id'];//桌号
//    $od_date = $row['od_date'];//下单时间
//    $od_string = $row['od_string'];//菜品和数量，格式类似于“苦瓜*1;蛋糕*1;肥牛*1;”
//    $od_total_price = $row['od_total_price'];//订单总价
//    echo "打印数据:".$od_id.'/'.$od_desk_id.'/'.$od_date.'/'.$od_string.'/'.$od_total_price;
//    //在这里加打印的相关函数
//
//
//}

function getProByOrderId($id){
    global $link;
    $sql="select gd_name,gd_quantity,gd_detail from od_ln where od_id = {$id};";
    $rows=fetchAll($link,$sql);
    return $rows;
}

