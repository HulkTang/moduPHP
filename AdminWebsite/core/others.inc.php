<?php
$link = connect();
/**
 recruit
 */
function getRecruitByPage($page,$pageSize){

    global $link;
    $sql="select * from recruit_master;";
    global $totalRows;
    $totalRows=getResultNum($link,$sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pageSize);
//    echo $totalRows;
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>=$totalPage)$page=$totalPage;
    $offset=($page-1)*$pageSize;
    $sql="select recruit_id,recruit_title,recruit_content,release_date from recruit_master order by recruit_id limit {$offset},{$pageSize};";
//    echo $sql;
    $rows=fetchAll($link,$sql);
//    var_dump($rows);
    return $rows;
}

function addRecruit(){
    global $link;

    //delete old one
    $sql = "select recruit_id from recruit_master;";
    $row = fetchOne($link, $sql);
    if($row){
        $where="recruit_id=".$row['recruit_id'];
        delete($link,"recruit_master",$where);
    }
    

    //add new 
    $arr=$_POST;
    unset($arr['act']);
    $currentTime = date("Y-m-d H:i:s");
    $arr['release_date'] = $currentTime;
    if(insert($link,"recruit_master",$arr)){
        $mes="招聘信息添加成功!<br/><a href='others/addRecruit.php'>继续添加</a>|<a href='others/listRecruit.php'>查看招聘信息</a>";
    }else{
        $mes="招聘信息添加失败！<br/><a href='others/addRecruit.php'>重新添加</a>|<a href='others/listRecruit.php'>查看招聘信息</a>";
    }
    return $mes;
}

function delRecruit($id){

    global $link;
    $where="recruit_id=".$id;
    if(delete($link,"recruit_master",$where)){
        $mes="招聘信息删除成功!<br/><a href='others/listRecruit.php'>查看招聘信息</a>|<a href='others/addRecruit.php'>添加招聘信息</a>";
    }else{
        $mes="招聘信息删除失败！<br/><a href='others/listRecruit.php'>请重新操作</a>";
    }
    return $mes;

}

function getRecruitById($id){
    global $link;
    $sql = "select recruit_title,recruit_content from recruit_master where recruit_id = {$id};";
    $row = fetchOne($link, $sql);
    return $row;
}

function editRecruit($id){
    global $link;
    $arr=$_POST;
    unset($arr['act']);
    if(update($link,"recruit_master",$arr,"recruit_id='{$id}'")>0){
        $msg = "招聘信息修改成功!<br/><a href='others/listRecruit.php'>查看招聘信息</a>";
    }else{
        $msg = "招聘信息修改失败!<br/><a href='others/editRecruit.php?id={$id}'>请重新修改</a>";
    }
    return $msg;
}

/*
 * system config
 */
//function changeShowDisplayTips($token){
//    var_dump($GLOBALS['show_display_tips']);
//    if($token==1) {
//        $GLOBALS['show_display_tips'] = true;
//        return;
//    }
//    if($token==0) {
//        $GLOBALS['show_display_tips'] = false;
//        var_dump($GLOBALS['show_display_tips']);
//        return;
//    }
//}
/*
 * wechat index picture
 */
function addWeChatIndexPicture(){
    global $link;
    $arr = $_POST;

    unset($arr['act']);
    $arr['release_date'] = date("Y-m-d H:i:s");

    $path = IMAGE_WECHAT_INDEX_ORIGIN_UPLOAD_PATH;
    $uploadFiles=uploadFile($path);
    if(is_array($uploadFiles)&&$uploadFiles){
        foreach($uploadFiles as $key=>$uploadFile){
            thumb($path."/".$uploadFile['name'],IMAGE_WECHAT_INDEX_UPLOAD_PATH.$uploadFile['name'],250,200);
            $arr['picture_path'] = IMAGE_WECHAT_INDEX_STORE_PATH.$uploadFile['name'];
        }
    }

    $res = insert($link,"wechat_index_picture",$arr);
    if ($res) {
        $mes = "<p>图片添加成功!</p><a href='others/listWeChatIndexPicture.php' target='mainFrame'>查看图片</a>";
    } else {
        foreach($uploadFiles as $uploadFile){
            if(file_exists(IMAGE_WECHAT_INDEX_ORIGIN_UPLOAD_PATH.$uploadFile['name'])){
                unlink(IMAGE_WECHAT_INDEX_ORIGIN_UPLOAD_PATH.$uploadFile['name']);
            }
            if(file_exists(IMAGE_WECHAT_INDEX_UPLOAD_PATH.$uploadFile['name'])){
                unlink(IMAGE_WECHAT_INDEX_UPLOAD_PATH.$uploadFile['name']);
            }
        }
        $mes = "<p>图片添加失败!</p><a href='others/addWeChatIndexPicture.php' target='mainFrame'>重新添加</a>";

    }
    return $mes;
}

function getWeChatIndexPictureByPage($page,$pageSize){
    global $link;
    $sql = "select * from wechat_index_picture;";
    global $totalRows;
    $totalRows = getResultNum($link, $sql);
    global $totalPage;
    $totalPage = ceil($totalRows / $pageSize);
    if ($page < 1 || $page == null || !is_numeric($page)) {
        $page = 1;
    }
    if ($page >= $totalPage) $page = $totalPage;
    $offset = ($page - 1) * $pageSize;
    $sql = "select picture_id,release_date,picture_path from wechat_index_picture
            order by picture_id limit {$offset},{$pageSize};";
    $rows = fetchAll($link, $sql);
    return $rows;
}

function delWeChatIndexPicture($id){
    global $link;
    $where="picture_id=".$id;
    if(delete($link,"wechat_index_picture",$where)){
        $mes="图片删除成功!<br/><a href='others/listWeChatIndexPicture.php'>查看图片</a>|<a href='others/addWeChatIndexPicture.php'>添加图片</a>";
    }else{
        $mes="删除失败！<br/><a href='others/listWeChatIndexPicture.php'>请重新操作</a>";
    }
    return $mes;
}