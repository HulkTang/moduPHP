<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/2
 * Time: 14:17
 */
//连接数据库

function connect(){


    $link = mysqli_connect("115.159.94.41:3306","remote","remote","modu") or die("数据库连接失败");

    mysqli_query($link,"set names 'utf8'");

    return $link;

}


function insert($link,$table,$array){

    $keys = join(",",array_keys($array));
    $vals = "'".join("','",array_values($array))."'";
    $sql = "insert {$table}($keys) values({$vals})";
//    echo $sql;
    mysqli_query($link,$sql);
    return mysqli_insert_id($link);
}

function update($link,$table,$array,$where=null){

    $str = null;
    foreach($array as $key=>$val){
        if($str == null)
            $sep = "";
        else
            $sep = ",";
        $str.=$sep.$key."='".$val."'";
    }
    $sql = "update {$table} set {$str} ".($where==null?null:"where ".$where);
//    echo $sql;
    mysqli_query($link,$sql);
    return mysqli_affected_rows($link);
}

function delete($link,$table,$where=null){

    $where=($where==null?null:"where ".$where);
    $sql = "delete from {$table} {$where}";
    mysqli_query($link,$sql);
    return mysqli_affected_rows($link);
}

function fetchOne($link,$sql,$result_type=MYSQLI_ASSOC){
  
    $result = mysqli_query($link,$sql);
    //如果查询出错，直接返回0，防止向用户展示错误信息而暴露数据库细节
    if($result == null){
        $rows = 0;
        return $rows;
    }
    $rows = mysqli_fetch_array($result,$result_type);
    return $rows;
}

function fetchAll($link,$sql,$result_type=MYSQLI_ASSOC){

//    echo $sql;
    $rows = array();
    $result = mysqli_query($link,$sql);
    if($result == null){
        $rows = array();
        return $rows;
    }
    while($row=mysqli_fetch_array($result,$result_type)){
        $rows[]=$row;
    }
    return $rows;
}

function getResultNum($link,$sql){

    $result = mysqli_query($link,$sql);
    if($result == null){
        return 0;
    }
//    echo $sql.'</br>';
    return mysqli_num_rows($result);
}

function getInsertId($link){
    return mysqli_insert_id($link);
}