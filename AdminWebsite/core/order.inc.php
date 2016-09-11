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

function getAllOrderByPage($page,$pageSize){

    global $link;
    $sql="select * from od_hdr;";
    global $totalRows;
    $totalRows=getResultNum($link,$sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pageSize);
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>=$totalPage)$page=$totalPage;
    $offset=($page-1)*$pageSize;
    $sql="select od_id,od_desk_id,od_date,od_string,od_total_price,od_state from od_hdr order by od_date desc limit {$offset},{$pageSize};";
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