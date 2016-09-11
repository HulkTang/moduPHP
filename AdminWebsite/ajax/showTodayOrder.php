<?php
    require_once '../include.php';



    $pageSize=2;
    $page=isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
    $rows=getTodayOrderByPage($page,$pageSize);

    echo "
            <div class=\"details_operation clearfix\">
                <div class=\"bui_select\">
                    <input type=\"button\" value=\"添&nbsp;&nbsp;加\" class=\"add\"  onclick=\"addCate()\" >
                </div>
            </div>";
        
    echo " <table class=\"table\" cellspacing=\"0\" cellpadding=\"0\">
                <thead>
                <tr>
                    <th width=\"8%\">编号</th>
                    <th width=\"7%\">桌号</th>
                    <th width=\"18%\">下单时间</th>
                    <th width=\"25%\">商品</th>
                    <th width=\"7%\">总价</th>
                    <th width=\"7%\">状态</th>

                    <th>操作</th>
                </tr>
                </thead>
                <tbody>";


    foreach($rows as $row):
        echo    "<tr>";
        echo    "<td>".($row['od_id']-getOtherDaysOrderNum())."</label></td>";
        echo    "<td>".$row['od_desk_id']."</td>";
        echo    "<td>".$row['od_date']."</td>";
        echo    "<td>".showFormatedProList($row['od_string'])."</td>";
        echo    "<td>".$row['od_total_price']."</td>";
        echo    "<td>".$row['od_state']."</td>";
        echo    "<td align=\"center\"><input type=\"button\" value=\"修改 无效\" class=\"btn\" onclick=\"editCate(".$row['od_id'].")\">";
        echo    "<input type=\"button\" value=\"测试\" class=\"btn\"  onclick=\"test(".$row['od_id'].")\">";
        echo    "<input type=\"button\" value=\"删除 无效\" class=\"btn\"  onclick=\"delCate(".$row['od_id'].")\"></td></tr>";
            
    endforeach;

    if($totalRows>$pageSize):
        echo "<tr><td colspan=\"7\">".showPage($page, $totalPage, null, "&nbsp;", 'listTodayOrder.php')."</td></tr>";
    endif;

    echo "   </tbody>
        </table>";
?>  