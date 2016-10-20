<?php

function showPage($page,$totalPage,$where=null,$sep="&nbsp;",$showPageUrl=null){
    $where=($where==null)?null:"&".$where;
    $url = ($showPageUrl==null)?$_SERVER ['PHP_SELF']:$showPageUrl;
    $index = ($page == 1) ? "首页" : "<a href='{$url}?page=1{$where}'>首页</a>";
    $last = ($page == $totalPage) ? "尾页" : "<a href='{$url}?page={$totalPage}{$where}'>尾页</a>";
    $prevPage=($page>=1)?$page-1:1;
    $nextPage=($page>=$totalPage)?$totalPage:$page+1;
    $prev = ($page == 1) ? "上一页" : "<a href='{$url}?page={$prevPage}{$where}'>上一页</a>";
    $next = ($page == $totalPage) ? "下一页" : "<a href='{$url}?page={$nextPage}{$where}'>下一页</a>";
    $str = "第{$page}页/总共{$totalPage}页";
    $p = null;
    if($totalPage<=10) {
        for ($i = 1; $i <= $totalPage; $i++) {
            if ($page == $i) {
                $p .= "[{$i}]";
            } else {
                $p .= "<a href='{$url}?page={$i}{$where}'>[{$i}]</a>";
            }
        }
    }
    else{
        $left = getLeftLimit($page);
        $right = getRightLimit($page, $totalPage);
        for ($i = $left; $i <= $right; $i++) {
            if ($page == $i) {
                $p .= "<p style='color:red;display:inline'>[{$i}]</p>";
            } else {
                $p .= "<a href='{$url}?page={$i}{$where}'> [{$i}] </a>";
            }
        }
        if($page>10) {
            $location = $left - 10;
            $p = "<a href='{$url}?page={$location}{$where}'>&nbsp;<<&nbsp;</a>" . $p;
        }
        if(($right+1)<=$totalPage){
            $location = $right + 1;
            $p .= "<a href='{$url}?page={$location}{$where}'>&nbsp;>>&nbsp;</a>";
        }
    }
    $pageStr=$str.$sep.$sep. $index .$sep. $prev.$sep . $p.$sep . $next.$sep . $last;
    return $pageStr;
}


function getLeftLimit($page){
    if($page%10==0)
        return $page - 9;
    else {
        $page = $page - $page % 10;
        return $page + 1;
    }
}

function getRightLimit($page, $totalPage){
    if($page%10==0)
        return $page;
    else{
        $page = $page - $page % 10 + 10;
        $page = $totalPage < $page?$totalPage:$page;
        return $page;
    }
}