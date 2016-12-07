<?php
$link = connect();
function addPro(){
	global $link;
	$arr=$_POST;
	//删除以post方式提交的act
	unset($arr['act']);



	$path = IMAGE_ORIGIN_UPLOAD_PATH;
	$uploadFiles=uploadFile($path);
	if(is_array($uploadFiles)&&$uploadFiles){
		foreach($uploadFiles as $key=>$uploadFile){
			thumb($path."/".$uploadFile['name'],IMAGE_UPLOAD_PATH.$uploadFile['name']);
//			$arr['gd_picture'] = "../image_100/".$uploadFile['name'];
			$arr['gd_picture'] = IMAGE_STORE_PATH.$uploadFile['name'];
		}
	}
	$res=insert($link,"gd_mst",$arr);
	$pid=getInsertId($link);
	if($res&&$pid){
		$mes="<p>添加成功!</p><a href='pro/addPro.php' target='mainFrame'>继续添加</a>|<a href='pro/listPro.php' target='mainFrame'>查看商品列表</a>";
	}else{
		foreach($uploadFiles as $uploadFile){
			if(file_exists(IMAGE_ORIGIN_UPLOAD_PATH.$uploadFile['name'])){
				unlink(IMAGE_ORIGIN_UPLOAD_PATH.$uploadFile['name']);
			}
			if(file_exists(IMAGE_UPLOAD_PATH.$uploadFile['name'])){
				unlink(IMAGE_UPLOAD_PATH.$uploadFile['name']);
			}
		}
		$mes="<p>添加失败!</p><a href='pro/addPro.php' target='mainFrame'>重新添加</a>";
		
	}
	return $mes;
}

function editPro($id){
	global $link;
	$arr=$_POST;
	unset($arr['act']);
	unset($arr['id']);

	$uploadFiles = Array();
	if($_FILES) {

		//添加新图片
		$path = IMAGE_ORIGIN_UPLOAD_PATH;
		$uploadFiles = uploadFile($path);
		if (is_array($uploadFiles) && $uploadFiles) {
			//删除旧图片
			$row = getProById($id);
			$proImgPath = $row['gd_picture'];
			$proImgName = getFileNameThroughPath($proImgPath);

//			if (file_exists("../uploadImages/" . $proImgName)) {
//				unlink("../uploadImages/" . $proImgName);
//			}
//			if (file_exists("../image_100/" . $proImgName)) {
//				unlink("../image_100/" . $proImgName);
//			}

			if (file_exists(IMAGE_UPLOAD_PATH . $proImgName)) {
				unlink(IMAGE_UPLOAD_PATH . $proImgName);
			}
			if (file_exists(IMAGE_ORIGIN_UPLOAD_PATH . $proImgName)) {
				unlink(IMAGE_ORIGIN_UPLOAD_PATH . $proImgName);
			}

			foreach ($uploadFiles as $key => $uploadFile) {
				thumb($path . "/" . $uploadFile['name'], IMAGE_UPLOAD_PATH . $uploadFile['name']);
//				$arr['gd_picture'] = "../image_100/" . $uploadFile['name'];
				$arr['gd_picture'] = IMAGE_STORE_PATH.$uploadFile['name'];
			}
		}
	}

	$where="gd_id={$id}";
	$res=update($link,"gd_mst",$arr,$where);
	if($res){
		$mes="<p>编辑成功!</p><a href='pro/listPro.php' target='mainFrame'>查看商品列表</a>";
	}else{
		if($_FILES&&is_array($uploadFiles)&&$uploadFiles){
			foreach($uploadFiles as $uploadFile){
				if(file_exists(IMAGE_ORIGIN_UPLOAD_PATH.$uploadFile['name'])){
					unlink(IMAGE_ORIGIN_UPLOAD_PATH.$uploadFile['name']);
				}
				if(file_exists(IMAGE_UPLOAD_PATH.$uploadFile['name'])){
					unlink(IMAGE_UPLOAD_PATH.$uploadFile['name']);
				}
			}
		}
		$mes="<p>编辑失败!</p><a href='pro/listPro.php' target='mainFrame'>重新编辑</a>";
		
	}
	return $mes;
}

function delPro($id)
{
	global $link;
	$where = "gd_id=$id";
	$row = getProById($id);
	$proImgPath = $row['gd_picture'];
	$proImgName = getFileNameThroughPath($proImgPath);

//	if (file_exists("../uploadImages/" . $proImgName)) {
//		unlink("../uploadImages/" . $proImgName);
//	}
	if (file_exists(IMAGE_ORIGIN_UPLOAD_PATH . $proImgName)) {
		unlink(IMAGE_ORIGIN_UPLOAD_PATH . $proImgName);
	}
	if (file_exists(IMAGE_UPLOAD_PATH . $proImgName)) {
		unlink(IMAGE_UPLOAD_PATH . $proImgName);
	}
	$res1 = delete($link, "gd_mst", $where);
	$res2 = delete($link, "gd_mst_config", $where);

	if ($res1&&$res2) {
		$mes = "删除成功!<br/><a href='pro/listPro.php' target='mainFrame'>查看商品列表</a>";
	} else {
		$mes = "删除失败!<br/><a href='pro/listPro.php' target='mainFrame'>重新删除</a>";
	}
	return $mes;
}



function getProById($id){
	global $link;
	$sql="select gd_id,gd_name,gd_price,gd_inventory,gd_description,gd_sales,gd_picture,gd_catalogue_name from gd_mst where gd_id = {$id}";
	$row=fetchOne($link,$sql);
	return $row;
}

function getProByName($name){
	global $link;
	$sql="select gd_id,gd_name,gd_price,gd_inventory,gd_description,gd_sales,gd_picture,gd_catalogue_name from gd_mst where gd_name = {$name}";
	$row=fetchOne($link,$sql);
	return $row;
}


function checkProExist($cid){
	global $link;
	$sql="select gd_mst.* from gd_mst ,gd_ctlg where gd_mst.gd_catalogue_name = gd_ctlg.ctlg_name and gd_ctlg.ctlg_id = {$cid}";
	$rows=fetchAll($link,$sql);
	return $rows;
}

function getProConfigByPage($page,$pageSize,$id){
	global $link;
	$sql="select * from gd_mst_config where gd_id = {$id};";
	global $totalRows;
	$totalRows=getResultNum($link,$sql);
	global $totalPage;
	$totalPage=ceil($totalRows/$pageSize);
	if($page<1||$page==null||!is_numeric($page)){
		$page=1;
	}
	if($page>=$totalPage)$page=$totalPage;
	$offset=($page-1)*$pageSize;
	$sql="select id,gd_name,gd_config_type,gd_config from gd_mst_config where gd_id = {$id} order by gd_config_type limit {$offset},{$pageSize};";
	$rows=fetchAll($link,$sql);
	return $rows;
}

function addProConfig(){
	global $link;
	$arr=$_POST;
	unset($arr['act']);


	$href1 = 'pro/addProConfig.php?id='.$arr['gd_id'];
	$href2 = 'pro/listProConfig.php?id='.$arr['gd_id'];

	if($arr['gd_config_type']=='推荐配菜') {
		$row = getProByName($arr['gd_name']);
		if (!$row) {
			$mes = "您输入的配菜名称不存在，请核对商品列表。<a href=".$href1.">重新添加</a>|<a href=".$href2.">查看配置</a>";
			return $mes;
		}
	}

	if(insert($link,"gd_mst_config",$arr)){
		$mes="配置添加成功!<br/><a href=".$href1.">继续添加</a>|<a href=".$href2.">查看配置</a>";
	}else{
		$mes="配置添加失败！<br/><a href=".$href1.">重新添加</a>|<a href=".$href2.">查看配置</a>";
	}
	return $mes;
}

function editProConfig(){
	global $link;
	$arr=$_POST;
	unset($arr['act']);
	$id = $arr['id'];
	unset($arr['id']);
	$href1 = 'pro/editProConfig.php?id='.$arr['gd_id'];
	$href2 = 'pro/listProConfig.php?id='.$arr['gd_id'];
	if(update($link,"gd_mst_config",$arr,"id='{$id}'")>0){
		$mes="配置编辑成功!<br/><a href=".$href2.">查看配置</a>";
	}else{
		$mes="配置编辑失败！<br/><a href=".$href1.">重新编辑</a>|<a href=".$href2.">查看配置</a>";
	}
	return $mes;
}

function delProConfig($id){
	global  $link;
	$where="id=".$id;
	$row = getProConfigById($id);

	$href = 'pro/listProConfig.php?id='.$row['gd_id'];
	if(delete($link,"gd_mst_config",$where)){
		$mes="配置删除成功!<br/><a href=".$href.">查看配置</a>";
	}else{
		$mes="配置删除失败！<br/><a href=".$href.">请重新操作</a>";
	}
	return $mes;
}

function getProConfigById($id){
	global $link;
	$sql = "select id,gd_id,gd_name,gd_config_type,gd_config from gd_mst_config where id = {$id}";
	$row = fetchOne($link, $sql);
	return $row;
}

function getQRForPro($id){
	$url = 'https://cli.im/api/qrcode/code?text=http://wechat.qiancs.cn/addByQRCode?item_id='.$id.'&mhid=sELPDFnok80gPHovKdI';
	$html = file_get_contents($url);
	return $html;
}



