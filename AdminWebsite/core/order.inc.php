<?php
$link = connect();

function getTodayOrder(){
    global $link;
    $sql="select od_id,od_desk_id,od_date,od_string,od_total_price,od_state from od_hdr;";
    $rows=fetchAll($link,$sql);
    return $rows;
}


function getTodayOrderByPage($page,$pageSize){
    $currentTime = date("Y-m-d H:i:s");
    $currentDate = formatToDateYmd($currentTime);

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
    $sql="select od_id,od_desk_id,od_date,od_string,od_total_price,od_state from od_hdr where date(od_date) = '{$currentDate}' order by od_date desc limit {$offset},{$pageSize};";
    $rows=fetchAll($link,$sql);

    return $rows;
}

function getOtherDaysOrderNum(){
    $currentTime = date("Y-m-d H:i:s");
    $currentDate = formatToDateYmd($currentTime);
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
    $sql="select od_id,od_desk_id,od_date,od_string,od_total_price,od_state from od_hdr where date(od_hdr.od_date)>='{$from}' and date(od_hdr.od_date)<='{$to}' order by od_date desc limit {$offset},{$pageSize};";
    $rows=fetchAll($link,$sql);

    return $rows;
}

function showFormatedProList($proOfOrder){
    $arr = explode(";",$proOfOrder);
    $formatedArr = '';
    foreach($arr as $a):
        $formatedArr = $formatedArr.$a.'</br>';
    endforeach;
    return $formatedArr;
//    return $proOfOrder;
}

function getSalesByPage($page,$pageSize,$from='2016-09-01',$to='2050-09-01'){
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

function getIncomeByDate($from='2016-09-01',$to='2050-09-01'){
    global $link;
    $sql="select sum(od_total_price) as od_total_income from od_hdr where date(od_hdr.od_date)>='{$from}' and date(od_hdr.od_date)<='{$to}';";
    $row=fetchOne($link,$sql);
    return $row;
}