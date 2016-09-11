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
            $_SESSION['adminStoreId'] = $result['st_id'];
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
    //删除以post方式提交的act
    unset($arr['act']);

    $token = true;
    //检测是否重复添加管理员
    $sql1 = "select * from stf_mst where stf_authority = 'admin'";
    $row1 = fetchOne($link,$sql1);
    if($row1!=0) {
        alertMes("已有管理员，请先删除再添加", "listAdmin.php");
        $token = false;
    }
//    //检测是否重复添加某店的管理员
//    $sql1 = "select * from st_mst where st_name = '{$arr['st_name']}'";
//    $row1 = fetchOne($link,$sql1);
//    if($row1!=0) {
//        alertMes("该店已有管理员，请先删除再添加", "listAdmin.php");
//        $token = false;
//    }
    //检测管理员是否在员工列表中
    $sql2 = "select * from stf_mst where stf_name = '{$arr['stf_name']}' and stf_code = '{$arr['st_manager_code']}'";
    $row2 = fetchOne($link,$sql2);
    if($row2==0) {
        alertMes("管理员不在员工中，请检查姓名或工号是否正确", "addAdmin.php");
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
    if($token&&update($link,"stf_mst",$auth,"stf_code = '{$arr['st_manager_code']}'")){
        $mes = "添加成功!<br/><a href='addAdmin.php'>继续添加</a>|<a href='listAdmin.php'>查看管理员列表</a>";
    }else{
        $mes = "添加失败!<br/><a href='addAdmin.php'>重新添加</a>";
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
        $mes="删除成功!<br/><a href='listAdmin.php'>查看管理员列表</a>";
    }else{
        $mes="删除失败!<br/><a href='listAdmin.php'>请重新删除</a>";
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

    //检测原密码是否正确
    $sql1 = "select * from stf_mst where stf_code='{$loginUser}' and stf_password='{$oldPassword}'";
    $row1 = fetchOne($link,$sql1);
    if($row1==0)
        alertMes("密码错误，请重新输入","changeBossPassword.php");
    //更改密码
    $arr['stf_password']=$newPassword2;

    if(update($link,"stf_mst",$arr,"stf_code='{$loginUser}'")>0){
        $msg = '密码修改成功!';
    }else{
        $msg = "密码修改失败!<br/><a href='changeBossPassword.php'>请重新修改</a>";
    }
    return $msg;
}

function addUser()
{

    global $link;
    $arr = $_POST;

    $arr['regTime']=time();
    $uploadFile = uploadFile("../uploads");
//    $uploadFile = uploadFile("/usr/local/wechat_node_server/public/images");
    if ($uploadFile&&is_array($uploadFile)) {
        $arr['face'] = $uploadFile[0]['name'];
    }
    else
        return "添加失败<a href='addUser.php'>重新添加</a> ";
    //删除以post方式提交的act
    unset($arr['act']);

    $insertId = insert($link,"go_user",$arr);
    if($insertId>0){
        require("../lib/smtp.php");
         $smtpserver = "smtp.163.com";
        $smtpserverport = 25;
        $smtpusermail = "wlmxjm@163.com";
        $smtpemailto = $arr['email'];
        $smtpuser = "wlmxjm";//SMTP服务器的用户帐号
        $smtppass = "tongji2016"; //SMTP服务器的用户密码
        $mailsubject = "用户帐号激活";
        $mailbody = "亲爱的".$arr['username']."：
        感谢您在我站注册了新帐号。
        请点击链接激活您的帐号。
        http://localhost/GoGoGo/GoShoppingWebsite/admin/doAdminAction.php?act=verify&verify=".$insertId."
        如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。";//邮件内容;
        $mailtype = "HTTP";
        $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
        $smtp->debug = false;
        $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);

        $mes = "添加成功!请登录到邮箱及时激活帐号！<br/><a href='addUser.php'>继续添加</a>|<a href='listUser.php'>查看用户列表</a>";
    }else{
        $filename="../uploads/".$uploadFile[0]['name'];
        if(file_exists($filename)){
            unlink($filename);
        }
        $mes = "添加失败!<br/><a href='addUser.php'>重新添加</a>";
    }
    return $mes;
}

function verify($verify){
    global $link;
    $arr['activeFlag']=1;

    if(update($link,"go_user",$arr,"id={$verify}")>0){
        $msg = '激活成功！';
    }else{
        $msg = '已激活！';
    }
    echo $msg;
}

function getAllUser($link){

    $sql="select id,username,email,activeFlag from go_user order by id";
    $rows=fetchAll($link,$sql);
    return $rows;
}

function delUser($id){
    global $link;
    $sql="select face from go_user where id = ".$id;
    $row=fetchOne($link,$sql);
    $face=$row['face'];
    if(file_exists("../uploads/".$face)){
        unlink("../uploads/".$face);
    }
    if(delete($link,"go_user","id={$id}")){
        $mes="删除成功!<br/><a href='listUser.php'>查看用户列表</a>";
    }else{
        $mes="删除失败!<br/><a href='listUser.php'>请重新删除</a>";
    }
    return $mes;
}

function editUser($id){
    $arr=$_POST;
    //$arr['password']=md5($arr['password']);
    global $link;
    if(update($link,"go_user",$arr,"id={$id}")>0){
        $mes="修改成功!<br/><a href='listUser.php'>查看用户列表</a>";
    }else{
        $mes="修改失败!<br/><a href='listUser.php'>请重新修改</a>";
    }
    return $mes;
}

function checkUser($link,$sql){
    return fetchOne($link,$sql);
}

function emitCart($id){
    global $link;
    $sql = "update go_cart set isCommit=4 where id ={$id}";
    $url = "../admin/listCart.php";
    if(mysqli_query($link,$sql))
        echo '<script>location.href="'.$url.'"</script>';
    else
        echo '<script>alert("接受失败！");location.href="'.$url.'"</script>';
}