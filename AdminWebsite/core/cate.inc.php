<?php
$link = connect();
function addCate(){
    global $link;
    $arr=$_POST;
    //删除以post方式提交的act
    unset($arr['act']);
    if(insert($link,"gd_ctlg",$arr)){
        $mes="分类添加成功!<br/><a href='addCate.php'>继续添加</a>|<a href='listCate.php'>查看分类</a>";
    }else{
        $mes="分类添加失败！<br/><a href='addCate.php'>重新添加</a>|<a href='listCate.php'>查看分类</a>";
    }
    return $mes;
}

function getCateByPage($page,$pageSize){
    global $link;
    $sql="select * from gd_ctlg;";
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
    $sql="select ctlg_id,ctlg_name,ctlg_description from gd_ctlg order by ctlg_id limit {$offset},{$pageSize};";
//    echo $sql;
    $rows=fetchAll($link,$sql);
//    var_dump($rows);
    return $rows;
}


function delCate($id){
    global $link;
    $res=checkProExist($id);

    if($res){
        alertMes("不能删除分类，请先删除该分类下的商品", "listPro.php");
    }else{
        $where="ctlg_id=".$id;
        if(delete($link,"gd_ctlg",$where)){
            $mes="分类删除成功!<br/><a href='listCate.php'>查看分类</a>|<a href='addCate.php'>添加分类</a>";
        }else{
            $mes="删除失败！<br/><a href='listCate.php'>请重新操作</a>";
        }
        return $mes;
    }
}

function editCate($ctlg_id){
    global $link;
    $arr=$_POST;
    //删除以post方式提交的act
    unset($arr['act']);
    if(update($link,"gd_ctlg",$arr,"ctlg_id='{$ctlg_id}'")>0){
        $msg = "分类修改成功!<br/><a href='listCate.php'>查看分类</a>";
    }else{
        $msg = "分类修改失败!<br/><a href='listCate.php'>请重新修改</a>";
    }
    return $msg;

}


function getAllCate(){
    global $link;
    $sql="select ctlg_id,ctlg_name,ctlg_description from gd_ctlg;";
    $rows=fetchAll($link,$sql);
    return $rows;
}

function getOneCate($ctlg_id){
    global $link;
    $sql="select ctlg_id,ctlg_name,ctlg_description from gd_ctlg where ctlg_id = '{$ctlg_id}';";
    $row=fetchOne($link,$sql);
    return $row;
}