<?php

$link = connect();
function getBalanceByPage($page,$pageSize,$cardNumber,$isEmpty){
    global $link;
    $sql="select * from blc_benefit_config where ('EMPTY' = '{$isEmpty}' or blc_card_number = '{$cardNumber}');";
    global $totalRows;
    $totalRows=getResultNum($link,$sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pageSize);
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>=$totalPage)$page=$totalPage;
    $offset=($page-1)*$pageSize;
    $sql = "select m.blc_card_number,m.blc_card_type,m.blc_balance,m.blc_last_change,m.blc_card_type,b.id,b.blc_benefit_type,b.blc_benefit_balance,b.blc_benefit_unit 
            from blc_master m,blc_benefit_config b   
            where m.blc_card_number = b.blc_card_number and ('EMPTY' = '{$isEmpty}' or m.blc_card_number = '{$cardNumber}')  
            order by blc_card_number limit {$offset},{$pageSize};";
    $rows=fetchAll($link,$sql);
    return $rows;
}

function getBalanceChangeByPage($page,$pageSize,$cardNumber,$isEmpty){
    global $link;
    $sql="select * from chg_master where ('EMPTY' = '{$isEmpty}' or blc_card_number = '{$cardNumber}');";
    global $totalRows;
    $totalRows=getResultNum($link,$sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pageSize);
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>=$totalPage)$page=$totalPage;
    $offset=($page-1)*$pageSize;
    $sql="select blc_card_number,chg_date,chg_amount,chg_after_amount from chg_master 
          where ('EMPTY' = '{$isEmpty}' or blc_card_number = '{$cardNumber}')  
          order by chg_date limit {$offset},{$pageSize};";
    $rows=fetchAll($link,$sql);
    return $rows;
}

function getBenefitById($id){
    global $link;
    $sql="select blc_card_number,blc_card_type,blc_benefit_type,blc_benefit_balance,blc_benefit_unit from blc_benefit_config where id= {$id}";
    $row=fetchOne($link,$sql);
    return $row;
}

function getAllBenefitsType(){
    global $link;
    $sql="select distinct(blc_benefit_type),blc_benefit_unit from blc_benefit_config";
    $rows=fetchAll($link,$sql);
    return $rows;
}

function editBenefit(){
    global $link;
    $arr = $_POST;
    var_dump($arr);
    unset($arr['act']);

    $row = getBenefitById($arr['id']);
    unset($arr['id']);

    $arr['blc_benefit_balance'] = $arr['blc_benefit_balance'] + $row['blc_benefit_balance'];
    $where = " blc_card_number='{$arr['blc_card_number']}' and blc_benefit_type='{$arr['blc_benefit_type']}' ";
    $res = update($link, "blc_benefit_config", $arr, $where);

    if ($res) {
        $mes = "<p>发放成功!</p><a href='customer/listBalance.php' target='mainFrame'>查看会员卡</a>";
    } else {
        $mes = "<p>发放失败!</p><a href='customer/listBalance.php' target='mainFrame'>重新发放</a>";

    }
    return $mes;
}

function addBenefit()
{

    global $link;
    $arr = $_POST;
    if($arr['blc_card_type']=='卡号不存在'){
        $mes = "该卡号不存在，请重新核对。";
        alertMes($mes,'customer/listBalance.php');
    }

    unset($arr['act']);

    $sql = "select * from blc_benefit_config  
            where blc_card_number = '{$arr['blc_card_number']}' and blc_benefit_type = '{$arr['blc_benefit_type']}';";
    $row=fetchOne($link,$sql);
    //更新
    if($row){
        $arr['blc_benefit_balance'] = $arr['blc_benefit_balance'] + $row['blc_benefit_balance'];
        $where = " blc_card_number='{$arr['blc_card_number']}' and blc_benefit_type='{$arr['blc_benefit_type']}' ";
        $res = update($link, "blc_benefit_config", $arr, $where);
    }
    //插入
    else{
        $res = insert($link,"blc_benefit_config",$arr);
    }



    if ($res) {
        $mes = "<p>发放成功!</p><a href='customer/listBalance.php' target='mainFrame'>查看会员卡</a>";
    } else {
        $mes = "<p>发放失败!</p><a href='customer/listBalance.php' target='mainFrame'>重新发放</a>";

    }
    return $mes;
}

function getCardTypeForCardNumber($cardNumber){
    global $link;
    $sql = "select blc_card_type from blc_master where blc_card_number = '{$cardNumber}';";
    $row = fetchOne($link,$sql);
    if($row)
        return $row['blc_card_type'];
    else
        return '卡号不存在';
}