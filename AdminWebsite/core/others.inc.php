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