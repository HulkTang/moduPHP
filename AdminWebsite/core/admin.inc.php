<?php
$link = connect();
function checkAdmin($link,$sql){
    return fetchOne($link,$sql);
}

function checkLogined(){
    global $link;
    if(!isset($_SESSION['adminCode'])&&($_COOKIE['adminCode']=="")){
        alertMes("请先登录","login.php");
    }
    else if(isset($_SESSION['adminCode']))
        return;
    else{
        $sql = "select stf_mst.* from stf_mst, st_mst where stf_mst.stf_code='{$_COOKIE['adminCode']}' and stf_mst.stf_password='{$_COOKIE['adminPassword']}'";
        $result = checkAdmin($link,$sql);
        if($result){
            $_SESSION['adminCode'] = $result['stf_code'];
        }else{
            alertMes("登录失败，重新登录","login.php");
        }
    }
}

function logout(){
    $_SESSION=array();
    if(isset($_COOKIE[session_name()])){
        setcookie(session_name(),"",time()-1);
    }
    if(isset($_COOKIE['adminPassword'])){
        setcookie('adminPassword',"",time()-1);
    }
    if(isset($_COOKIE['adminCode'])){
        setcookie('adminCode',"",time()-1);
    }
    session_destroy();
    header("location:login.php");

}

function addAdmin(){
    $loginUser = getLoginUser();
    if($loginUser != '00000'){
        alertMes("请勿违规操作，谢谢！","main.php");
        return '';
    }
    global $link;
    $arr = $_POST;
    unset($arr['act']);

    if($arr['stf_name']=='员工编号不存在'){
        $mes = "该员工编号不存在，请重新核对。";
        alertMes($mes,'admin/addAdmin.php');
    }

    $token = true;
    //检测是否重复添加管理员
//    $sql1 = "select * from stf_mst where stf_authority = 'admin'";
//    $row1 = fetchOne($link,$sql1);
//    if($row1!=0) {
//        alertMes("已有管理员，请先删除再添加", "listAdmin.php");
//        $token = false;
//    }

//    //检测是否重复添加某店的管理员
//    $sql1 = "select * from st_mst where st_name = '{$arr['st_name']}'";
//    $row1 = fetchOne($link,$sql1);
//    if($row1!=0) {
//        alertMes("该店已有管理员，请先删除再添加", "listAdmin.php");
//        $token = false;
//    }
    //检测管理员是否在员工列表中
    $sql2 = "select * from stf_mst where stf_name = '{$arr['stf_name']}' and stf_code = '{$arr['stf_code']}'";
    $row2 = fetchOne($link,$sql2);
    if($row2==0) {
        alertMes("管理员不在员工中，请检查姓名或工号是否正确", "admin/addAdmin.php");
        $token = false;
    }
//    //检测是否为一个管理员添加了多个店
//    $sql3 = "select * from st_mst where st_manager_code = '{$arr['st_manager_code']}'";
//    $row3 = fetchOne($link,$sql3);
//    if($row3!=0) {
//        alertMes("管理员只能管理一家店铺，请选择其他管理员", "listAdmin.php");
//        $token = false;
//    }
    //删除以post方式提交的stf_name
    $auth['stf_authority'] = 'admin';
    if($token&&update($link,"stf_mst",$auth,"stf_code = '{$arr['stf_code']}'")){
        $mes = "添加成功!<br/><a href='admin/addAdmin.php'>继续添加</a>|<a href='admin/listAdmin.php'>查看管理员列表</a>";
    }else{
        $mes = "添加失败!<br/><a href='admin/addAdmin.php'>重新添加</a>";
    }
    return $mes;
}

function getAllAdmin(){
    global $link;
    $loginUser = getLoginUser();
    if($loginUser != '00000'){
        alertMes("请勿违规操作，谢谢！","main.php");
        return '';
    }
    $sql="select stf_id, stf_name, stf_code from stf_mst where stf_authority = 'admin';";
    $rows=fetchAll($link,$sql);
    return $rows;
}

//function getAdminByPage($page,$pageSize){
//    global $link;
//    $sql="select stf_id, stf_name, stf_code, from stf_mst where stf_authority = 'admin';";
//    global $totalRows;
//    $totalRows=getResultNum($link,$sql);
//    global $totalPage;
//    $totalPage=ceil($totalRows/$pageSize);
//    if($page<1||$page==null||!is_numeric($page)){
//        $page=1;
//    }
//    if($page>=$totalPage)$page=$totalPage;
//    $offset=($page-1)*$pageSize;
//    $sql="select stf_mst.stf_id, stf_mst.stf_name, stf_mst.stf_code, st_mst.st_name from stf_mst, st_mst
//          where stf_mst.st_id = st_mst.st_id and stf_mst.stf_code = st_mst.st_manager_code limit {$offset},{$pageSize} ";
//    $rows=fetchAll($link,$sql);
//    return $rows;
//}


function delAdmin($id){
    global $link;
    $arr['stf_authority'] = 'normal';
    if(update($link,"stf_mst",$arr,"stf_code={$id}")){
        $mes="删除成功!<br/><a href='admin/listAdmin.php'>查看管理员列表</a>";
    }else{
        $mes="删除失败!<br/><a href='admin/listAdmin.php'>请重新删除</a>";
    }
    return $mes;
}

function changeBossPassword($oldPassword,$newPassword1,$newPassword2){

    global $link;
    $loginUser = getLoginUser();
    if($loginUser != '00000'){
        alertMes("请勿违规操作，谢谢！","main.php");
        return '';
    }
    $oldPassword = md5($oldPassword);
    $newPassword2 = md5($newPassword2);
    //检测原密码是否正确
    $sql1 = "select * from stf_mst where stf_code='{$loginUser}' and stf_password='{$oldPassword}'";
    $row1 = fetchOne($link,$sql1);
    if($row1==0)
        alertMes("密码错误，请重新输入","admin/changeBossPassword.php");
    //更改密码
    $arr['stf_password']=$newPassword2;

    if(update($link,"stf_mst",$arr,"stf_code='{$loginUser}'")>0){
        $msg = '密码修改成功!';
    }else{
        $msg = "密码修改失败!<br/><a href='admin/changeBossPassword.php'>请重新修改</a>";
    }
    return $msg;
}

function getAdminNameForadminNumber($adminNumber){
    global $link;
    $sql = "select stf_name from stf_mst where stf_code = '{$adminNumber}';";
    $row = fetchOne($link,$sql);
    if($row)
        return $row['stf_name'];
    else
        return '员工编号不存在';
}


