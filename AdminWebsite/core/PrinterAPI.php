<?php
//header("Content-type: text/html; charset=utf-8");
//include 'HttpClient.class.php';


define('PRINTER_SN', '916502961');
define('KEY', ' xUajsjUm');
define('IP','api163.feieyun.com');
define('PORT',80);
define('HOSTNAME','/FeieServer');
$link = connect();
//根据主订单id打印
function printOrder($id){
	global $link;
	$sql1="select od_id,od_desk_id,od_date,od_string,od_total_price,od_state from od_hdr where od_id = {$id};";
	$row=fetchOne($link,$sql1);

	$sql2="select n.gd_name,n.gd_quantity,n.od_price from od_hdr as m, od_ln as n where m.od_id = {$id} and m.od_id = n.od_id;";
	$rows=fetchAll($link,$sql2);
	//在这里加打印的相关函数
	wp_print(PRINTER_SN,KEY,1,$row,$rows);

	//打印成功如何判断？
	//判断打印成功后，修改打印状态为'Y'
	//现在把每一次查出的未打印订单，状态先全部修改为'Y'，再加入打印队列。能否成功需要测试。
	
}

function updateOrderIsPrint($id){
	global $link;
	$arr = [];
	$arr['od_isprint'] = 'Y';
	$where = "od_id='{$id}'";
	update($link,"od_hdr",$arr,$where);
	
}

function printNewTodayOrder(){
	global $link;
	$currentDate = getCurrentDate();
	$sql="select od_id from od_hdr where date(od_date) = '{$currentDate}' and od_isprint = 'N';";
	$rows=fetchAll($link,$sql);

	for($i=0;$i<count($rows);$i++){
		updateOrderIsPrint($rows[$i]);
	}
	for($i=0;$i<count($rows);$i++){
		printOrder($rows[$i]);
	}
}
/*
 *  方法1
	拼凑订单内容时可参考如下格式
	根据打印纸张的宽度，自行调整内容的格式，可参考下面的样例格式
*/
function wp_print($printer_sn,$key,$times,$row,$rows){

		$od_id = $row['od_id'];//订单编号
		$od_desk_id = $row['od_desk_id'];//桌号
		$od_date = $row['od_date'];//下单时间
		$od_string = $row['od_string'];//菜品和数量，格式类似于“苦瓜*1;蛋糕*1;肥牛*1;”
		$od_total_price = $row['od_total_price'];//订单总价
		echo '</br>'."打印数据:".$od_id.'/'.$od_desk_id.'/'.$od_date.'/'.$od_string.'/'.$od_total_price.'</br>';

		var_dump($rows);

		for($i=0;$i<count($rows);$i++){                //循环读取订单中的每一件商品
			$gd_name = $rows[$i]['gd_name'];			//商品名
			$gd_quantity = $rows[$i]['gd_quantity'];	//商品数量
			$gd_price = $rows[$i]['od_price'];			//商品价格
			echo "打印每一条具体的菜品信息：".$gd_name.' \ '.$gd_quantity.' \ '.$gd_price.'<br>';
		}


		$orderInfo = '<CB>测试打印</CB><BR>';
		$orderInfo .= '名称　　　单价   数量  金额<BR>';
		$orderInfo .= '--------------------------<BR>';
		$orderInfo .= '红烧牛肉面 15.0   1   15.0<BR>';
		$orderInfo .= '备注：微辣<BR>';
		$orderInfo .= '--------------------------<BR>';
		$orderInfo .= '合计：15.0元<BR>';
		$orderInfo .= '桌号：3<BR>';
		$orderInfo .= '联系电话：17751719646<BR>';
		$orderInfo .= '订餐时间：2016-10-17 12:39:08<BR>';

		$content = array(
			'sn'=>$printer_sn,
			'printContent'=>$orderInfo,
			//'apitype'=>'php',//如果打印出来的订单中文乱码，请把注释打开
			'key'=>$key,
		    'times'=>$times//打印次数
		);

	$client = new HttpClient(IP,PORT);
	if(!$client->post(HOSTNAME.'/printOrderAction',$content)){
		echo 'error';
	}
	else{
		echo $client->getContent();
	}

}





/*
 *  方法2
	根据订单索引,去查询订单是否打印成功,订单索引由方法1返回
*/
function queryOrderState($printer_sn,$key,$index){
		$msgInfo = array(
			'sn'=>$printer_sn,  
			'key'=>$key,
			'index'=>$index
		);
	
	$client = new HttpClient(IP,PORT);
	if(!$client->post(HOSTNAME.'/queryOrderStateAction',$msgInfo)){
		echo 'error';
	}
	else{
		$result = $client->getContent();
		echo $result;
	}
	
}




/*
 *  方法3
	查询指定打印机某天的订单详情
*/
function queryOrderInfoByDate($printer_sn,$key,$date){
		$msgInfo = array(
	        'sn'=>$printer_sn,  
			'key'=>$key,
			'date'=>$date
		);
	
	$client = new HttpClient(IP,PORT);
	if(!$client->post(HOSTNAME.'/queryOrderInfoAction',$msgInfo)){ 
		echo 'error';
	}
	else{
		$result = $client->getContent();
		echo $result;
	}
	
}



/*
 *  方法4
	查询打印机的状态
*/
function queryPrinterStatus($printer_sn,$key){
		
	    $msgInfo = array(
	        'sn'=>$printer_sn,  
			'key'=>$key,
		);
	
	$client = new HttpClient(IP,PORT);
	if(!$client->post(HOSTNAME.'/queryPrinterStatusAction',$msgInfo)){
		echo 'error';
	}
	else{
		$result = $client->getContent();
		echo $result;
	}
}


?>
