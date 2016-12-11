<?php

//    require_once "flagToControlAutoPrint.php";
    require_once '../include.php';
    $GLOBALS['flag'] = true;
    session_write_close();

    $link = connect();
    $currentDate = getCurrentDate();
    $sql="select od_id 
          from od_hdr 
          where date(od_date) = '{$currentDate}' and od_isprint = 'N' 
          order by od_id desc;";


    ignore_user_abort(true);
    set_time_limit(0);

    $interval=15;


    do{
        $rows = null;
        $toBePrintedArray = array();
        $rows=fetchAll($link,$sql);
        if($rows) {
            foreach ($rows as $row)
                array_push($toBePrintedArray, $row['od_id']);
            $toBePrintedArray = array_unique($toBePrintedArray);
            printOrder($toBePrintedArray[0]);
            var_dump($toBePrintedArray);
            ob_flush();
            flush();
        }

        sleep($interval);
    }while($GLOBALS['flag']);

//    echo '12';
//    sleep(1);
//    echo '2';
    
    echo 'ok';



?>