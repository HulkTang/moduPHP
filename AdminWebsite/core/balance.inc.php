<?php

$link = connect();

/**
 * balance
 */
function getBalanceByPage($page,$pageSize,$cardNumber,$isEmpty){
    global $link;
    $sql="select * from blc_master where ('EMPTY' = '{$isEmpty}' or blc_card_number like '%{$cardNumber}%');";
    global $totalRows;
    $totalRows=getResultNum($link,$sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pageSize);
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>=$totalPage)$page=$totalPage;
    $offset=($page-1)*$pageSize;
    $sql = "select b.blc_card_number,b.blc_balance,b.blc_last_change,b.blc_card_type
            from blc_master b 
            where ('EMPTY' = '{$isEmpty}' or b.blc_card_number like '%{$cardNumber}%')  
            order by b.blc_card_number limit {$offset},{$pageSize};";
    $rows=fetchAll($link,$sql);
    return $rows;
}

function getTotalConsumeByCardNumber($cardNumber){
    global $link;
    $sql = "select sum(chg_amount) as totalConsume from chg_master 
            where chg_amount < 0 and blc_card_number = '{$cardNumber}'";
    $row = fetchOne($link,$sql);
    return $row['totalConsume']*(-1);
}

function getTotalCouponNumberByCardNumber($cardNumber){
    global $link;
    $sql = "select sum(c.coupon_number) as totalNumber from blc_master b,coupon_master c 
            where b.blc_card_number = '{$cardNumber}' and b.blc_card_number = c.coupon_card_number";
    $row = fetchOne($link,$sql);
    return $row['totalNumber']?$row['totalNumber']:0;
}

function getCouponByCardNumberByPage($page,$pageSize,$cardNumber){
    global $link;
    $sql="select * from coupon_master where coupon_card_number = '{$cardNumber}';";
    global $totalRows;
    $totalRows=getResultNum($link,$sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pageSize);
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>=$totalPage)$page=$totalPage;
    $offset=($page-1)*$pageSize;
    $sql="select m.coupon_card_number,m.coupon_start_date,m.coupon_end_date,m.coupon_number,
          c.coupon_type,c.coupon_amount1,c.coupon_amount2,c.coupon_description,c.coupon_catalogue
          from coupon_master m,coupon_config c 
          where m.coupon_card_number = '{$cardNumber}' and m.coupon_id = c.coupon_id 
          order by m.coupon_end_date limit {$offset},{$pageSize};";
    $rows=fetchAll($link,$sql);
    return $rows;
}


function getBalanceChangeByPage($page,$pageSize,$cardNumber,$isEmpty){
    global $link;
    $sql="select * from chg_master where ('EMPTY' = '{$isEmpty}' or blc_card_number like '%{$cardNumber}%');";
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
          where ('EMPTY' = '{$isEmpty}' or blc_card_number like '%{$cardNumber}%')  
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
    if(strstr($arr['coupon_card_number'],'卡号')!==false){
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




/**
  coupon config
 */
function getCouponConfigByPage($page, $pageSize){
    global $link;
    $sql="select * from coupon_config";
    global $totalRows;
    $totalRows=getResultNum($link,$sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pageSize);
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>=$totalPage)$page=$totalPage;
    $offset=($page-1)*$pageSize;
    $sql="select coupon_id,coupon_type,coupon_amount1,coupon_amount2,coupon_duration,coupon_description,coupon_catalogue
          from coupon_config
          order by coupon_type limit {$offset},{$pageSize};";
    $rows=fetchAll($link,$sql);
    return $rows;
}

function addSubCoupon(){
    global $link;
    $arr = $_POST;

    unset($arr['act']);
    $arr['coupon_catalogue'] = null;
    foreach($arr['catalogue'] as $catalogue) {
        $arr['coupon_catalogue'] .= $catalogue.";";
    }
    unset($arr['catalogue']);

    $res = insert($link,"coupon_config",$arr);
    if ($res) {
        $mes = "<p>满减券添加成功!</p><a href='customer/listCouponConfig.php' target='mainFrame'>查看优惠券</a>";
    } else {
        $mes = "<p>满减券添加失败!</p><a href='customer/addSubCoupon.php' target='mainFrame'>重新添加</a>";

    }
    return $mes;
}

function addDiscountCoupon(){
    global $link;
    $arr = $_POST;

    unset($arr['act']);
    $arr['coupon_catalogue'] = null;
    foreach($arr['catalogue'] as $catalogue) {
        $arr['coupon_catalogue'] .= $catalogue.";";
    }
    unset($arr['catalogue']);

    $res = insert($link,"coupon_config",$arr);
    if ($res) {
        $mes = "<p>折扣券添加成功!</p><a href='customer/listCouponConfig.php' target='mainFrame'>查看优惠券</a>";
    } else {
        $mes = "<p>折扣券添加失败!</p><a href='customer/addDiscountCoupon.php' target='mainFrame'>重新添加</a>";

    }
    return $mes;
}

function checkCouponConfigUsed($id){
    global $link;
    $sql = "select * from coupon_master where coupon_id={$id} and coupon_status='Y';";
    $row = fetchOne($link,$sql);
    return $row;
}

function delCouponConfig($id){

    global $link;
    $res=checkCouponConfigUsed($id);

    if($res){
        alertMes("不能删除该优惠券配置，顾客仍然在使用中", "customer/listCouponConfig.php");
    }else{
        $where="coupon_id=".$id;
        if(delete($link,"coupon_config",$where)){
            $mes="优惠券配置删除成功!<br/><a href='customer/listCouponConfig.php'>查看优惠券配置</a>";
        }else{
            $mes="删除失败！<br/><a href='customer/listCouponConfig.php'>请重新操作</a>";
        }
        return $mes;
    }

}

function getAllCouponConfig(){
    global $link;
    $sql = "select coupon_id,coupon_type,coupon_duration,coupon_description,coupon_catalogue
            from coupon_config";
    $rows = fetchAll($link,$sql);
    return $rows;
}

function sendCouponToCardNumber(){
    global $link;
    $arr = $_POST;

    if(strstr($arr['coupon_card_number'],'卡号')!==false){
        $mes = "该卡号不存在，请重新核对。";
        alertMes($mes,'customer/sendCouponToCardNumber.php');
    }
    if($arr['coupon_end_date']==null){
        $mes = "请填写失效日期";
        alertMes($mes,'customer/sendCouponToCardNumber.php');
    }


    $endDate = explode("-",$arr['coupon_end_date']);
    unset($arr['act']);
    $arr['coupon_status'] = 'Y';
    $arr['coupon_start_date'] = date("Y-m-d",strtotime($arr['coupon_start_date']));
    $arr['coupon_end_date'] = date("Y-m-d",mktime(0,0,0,intval($endDate[1]),intval($endDate[2]),intval($endDate[0])));
    $sql = "select * from coupon_master  
            where coupon_id = {$arr['coupon_id']} and coupon_card_number = '{$arr['coupon_card_number']}' and coupon_start_date = '{$arr['coupon_start_date']}';";
    $row=fetchOne($link,$sql);
    //更新
    if($row){
        $arr['coupon_number'] = $arr['coupon_number'] + $row['coupon_number'];
        $where = " coupon_id = {$arr['coupon_id']} and coupon_card_number = '{$arr['coupon_card_number']}' and coupon_start_date = '{$arr['coupon_start_date']}';";
        $res = update($link, "coupon_master", $arr, $where);
    }
    //插入
    else{
        $res = insert($link,"coupon_master",$arr);
    }



    if ($res) {
        $mes = "<p>发放成功!</p><a href='customer/listCoupon.php?cardNumber={$arr['coupon_card_number']}' target='mainFrame'>查看优惠券</a>";
    } else {
        $mes = "<p>发放失败!</p><a href='customer/sendCouponToCardNumber.php' target='mainFrame'>重新发放</a>";

    }
    return $mes;
}
/**
 * activity config
 */

function getActivityConfigByPage($page, $pageSize){
    global $link;
    $sql="select * from activity_config";
    global $totalRows;
    $totalRows=getResultNum($link,$sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pageSize);
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>=$totalPage)$page=$totalPage;
    $offset=($page-1)*$pageSize;
    $sql="select activity_id,activity_type,activity_amount1,activity_amount2,activity_start_date,activity_end_date,activity_description,activity_catalogue
          from activity_config
          order by activity_type limit {$offset},{$pageSize};";
    $rows=fetchAll($link,$sql);
    return $rows;
}

function addDiscountActivity(){
    global $link;
    $arr = $_POST;

    unset($arr['act']);
    $arr['activity_catalogue'] = null;
    foreach($arr['catalogue'] as $catalogue) {
        $arr['activity_catalogue'] .= $catalogue.";";
    }
    unset($arr['catalogue']);

    $res = insert($link,"activity_config",$arr);
    if ($res) {
        $mes = "<p>折扣活动添加成功!</p><a href='customer/listActivityConfig.php' target='mainFrame'>查看活动</a>";
    } else {
        $mes = "<p>折扣活动添加失败!</p><a href='customer/addDiscountActivity.php' target='mainFrame'>重新添加</a>";

    }
    return $mes;
}

function addSubActivity(){
    global $link;
    $arr = $_POST;

    unset($arr['act']);
    $arr['activity_catalogue'] = null;
    foreach($arr['catalogue'] as $catalogue) {
        $arr['activity_catalogue'] .= $catalogue.";";
    }
    unset($arr['catalogue']);

    $res = insert($link,"activity_config",$arr);
    if ($res) {
        $mes = "<p>满减活动添加成功!</p><a href='customer/listActivityConfig.php' target='mainFrame'>查看活动</a>";
    } else {
        $mes = "<p>满减活动添加失败!</p><a href='customer/addSubActivity.php' target='mainFrame'>重新添加</a>";

    }
    return $mes;
}

function checkActivityConfigUsed($id){
    global $link;
    $sql = "select activity_end_date from activity_config where activity_id={$id};";
    $row = fetchOne($link,$sql);
    return $row;
}

function delActivityConfig($id){
    global $link;
    $res=checkActivityConfigUsed($id);
    var_dump($res['activity_end_date']);
    var_dump($res['activity_end_date']>=formatToDateYmd(time()));
    if($res['activity_end_date']>=formatToDateYmd(time())){
        echo "<script>
                if(window.confirm(\"活动尚未结束，您确定要删除该活动吗？\"))
                    window.location = \"doAdminAction.php?act=delActivityConfigForcible&id={$id}\";
                else
                    window.location = \"customer/listActivityConfig.php\";
              </script>";
    }
    else{
        return delActivityConfigForcible($id);
    }

}

function delActivityConfigForcible($id){
    global $link;
    $where="activity_id=".$id;
    if(delete($link,"activity_config",$where)){
        $mes="活动配置删除成功!<br/><a href='customer/listActivityConfig.php'>查看活动配置</a>";
    }else{
        $mes="删除失败！<br/><a href='customer/listActivityConfig.php'>请重新操作</a>";
    }
    return $mes;
}

/**
 * ajax
 */
function getCardNumberVerified($cardNumber){
    global $link;
    $sql = "select blc_card_number from blc_master where blc_card_number = '{$cardNumber}';";
    $row = fetchOne($link,$sql);
    if($row)
        return $row['blc_card_number'];
    else
        return '卡号不存在';
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

function getDurationByCouponId($coupon_id){
    global $link;
    $sql = "select coupon_duration from coupon_config where coupon_id = {$coupon_id}";
    $row = fetchOne($link,$sql);
    return $row['coupon_duration'];
}