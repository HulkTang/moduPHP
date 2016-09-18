<?php

$link = connect();
function getBalanceByPage($page,$pageSize){
    global $link;
    $sql="select * from blc_master;";
    global $totalRows;
    $totalRows=getResultNum($link,$sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pageSize);
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>=$totalPage)$page=$totalPage;
    $offset=($page-1)*$pageSize;
    $sql="select blc_openid,blc_balance,blc_last_change from blc_master order by blc_last_change limit {$offset},{$pageSize};";
    $rows=fetchAll($link,$sql);
    return $rows;
}

function getBalanceChangeByPage($page,$pageSize){
    global $link;
    $sql="select * from chg_master;";
    global $totalRows;
    $totalRows=getResultNum($link,$sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pageSize);
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>=$totalPage)$page=$totalPage;
    $offset=($page-1)*$pageSize;
    $sql="select chg_openid,chg_date,chg_amount,chg_after_amount from chg_master order by chg_date limit {$offset},{$pageSize};";
    $rows=fetchAll($link,$sql);
    return $rows;
}