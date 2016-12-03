<?php
    require_once '../../include.php';



    $pageSize=6;
    $page=isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
    $rows=getTodayOrderByPage($page,$pageSize);
//    printNewTodayOrder();

//    echo "
//            <div class=\"details_operation clearfix\">
//                <div class=\"bui_select\">
//                    <input type=\"button\" value=\"添&nbsp;&nbsp;加\" class=\"add\"  onclick=\"addCate()\" >
//                </div>
//            </div>";
        
    echo " <table class=\"table\" cellspacing=\"0\" cellpadding=\"0\">
                <thead>
                <tr>
                    <th width=\"8%\">编号</th>
                    <th width=\"5%\">桌号</th>
                    <th width=\"15%\">下单时间</th>
                    <th width=\"22%\">商品</th>
                    <th width=\"7%\">原价</th>
                    <th width=\"7%\">总价</th>
                    <th width=\"5%\">状态</th>
                    <th width=\"5%\">打印</th>

                    <th>操作</th>
                </tr>
                </thead>
                <tbody>";


    foreach($rows as $row):
        echo    "<tr>";
//        echo    "<td>".($row['od_id']-getOtherDaysOrderNum())."</label></td>";
        echo    "<td>".$row['od_id']."</label></td>";
        echo    "<td>".$row['od_desk_id']."</td>";
        echo    "<td>".$row['od_date']."</td>";
        echo    "<td>".showFormatedProList($row['od_string'])."</td>";
        echo    "<td>".$row['od_fixed_total_price']."元"."</td>";
        echo    "<td>".$row['od_total_price']."元"."</td>";
        echo    "<td>";
                        switch($row['od_state']) {
                            case 0:
                                echo ORDER_STATE_0;
                                break;
                            case 1:
                                echo ORDER_STATE_1;
                                break;
                            case 2:
                                echo ORDER_STATE_2;
                                break;
                        }
        echo    "</td>";
        echo    "<td>".$row['od_isprint']."</td>";
        echo    "<td align=\"center\"><input type=\"button\" value=\"打印\" class=\"btn\" onclick=\"printOrder(".$row['od_id'].")\">";
        echo    "<input type=\"button\" value=\"出单\" class=\"btn\" onclick=\"changeStates(".$row['od_id'].','.$row['od_state'].','.$page.")\">";
        echo    "<input type=\"button\" value=\"详情\" class=\"btn\" onclick=\"showDetail(".$row['od_id'].")\">";
        echo    "<div id=\"showDetail".$row['od_id']."\" style=\"display:none;\">";
        echo        "<table class=\"table\" cellspacing=\"0\" cellpadding=\"0\">".
                        "<tr>
                            <td width=\"20%\"  align=\"right\">优惠券</td>
                            <td>".$row['od_coupon_description']."</td>
                        </tr>";
                        $od_pros = getProByOrderId($row['od_id']);
                        foreach($od_pros as $od_pro):
        echo                "<tr>
                                <td width=\"20%\"  align=\"right\">".$od_pro['gd_name'].'*'.$od_pro['gd_quantity']."</td>
                                <td>".$od_pro['gd_detail']."</td>
                            </tr>";
                        endforeach;

        echo        "</table>";
        echo    "</div>";
        echo    "</td>";


            
    endforeach;

    if($totalRows>$pageSize):
        echo "<tr><td colspan=\"9\">".showPage($page, $totalPage, null, "&nbsp;", 'listTodayOrder.php')."</td></tr>";
    endif;

    echo "   </tbody>
        </table>";
?>  