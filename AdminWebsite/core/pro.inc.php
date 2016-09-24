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
			thumb($path."/".$uploadFile['name'],IMAGE_UPLOAD_PATH.$uploadFile['name'],100,100);
//			$arr['gd_picture'] = "../image_100/".$uploadFile['name'];
			$arr['gd_picture'] = IMAGE_STORE_PATH.$uploadFile['name'];
		}
	}
	$res=insert($link,"gd_mst",$arr);
	$pid=getInsertId($link);
	if($res&&$pid){
		$mes="<p>添加成功!</p><a href='addPro.php' target='mainFrame'>继续添加</a>|<a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	}else{
		foreach($uploadFiles as $uploadFile){
			if(file_exists(IMAGE_ORIGIN_UPLOAD_PATH.$uploadFile['name'])){
				unlink(IMAGE_ORIGIN_UPLOAD_PATH.$uploadFile['name']);
			}
			if(file_exists(IMAGE_UPLOAD_PATH.$uploadFile['name'])){
				unlink(IMAGE_UPLOAD_PATH.$uploadFile['name']);
			}
		}
		$mes="<p>添加失败!</p><a href='addPro.php' target='mainFrame'>重新添加</a>";
		
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
				thumb($path . "/" . $uploadFile['name'], "../image_100/" . $uploadFile['name'], 100, 100);
//				$arr['gd_picture'] = "../image_100/" . $uploadFile['name'];
				$arr['gd_picture'] = IMAGE_STORE_PATH.$uploadFile['name'];
			}
		}
	}

	$where="gd_id={$id}";
	$res=update($link,"gd_mst",$arr,$where);
	if($res){
		$mes="<p>编辑成功!</p><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
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
		$mes="<p>编辑失败!</p><a href='listPro.php' target='mainFrame'>重新编辑</a>";
		
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
	

	$res = delete($link, "gd_mst", $where);
	if ($res) {
		$mes = "删除成功!<br/><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	} else {
		$mes = "删除失败!<br/><a href='listPro.php' target='mainFrame'>重新删除</a>";
	}
	return $mes;
}



function getProById($id){
	global $link;
	$sql="select gd_id,gd_name,gd_price,gd_inventory,gd_description,gd_sales,gd_picture,gd_catalogue_name from gd_mst where gd_id = {$id}";
	$row=fetchOne($link,$sql);
	return $row;
}


function checkProExist($cid){
	global $link;
	$sql="select gd_mst.* from gd_mst ,gd_ctlg where gd_mst.gd_catalogue_name = gd_ctlg.ctlg_name and gd_ctlg.ctlg_id = {$cid}";
	$rows=fetchAll($link,$sql);
	return $rows;
}


function getRecommendPro($link,$proID){
	//生成随机数
	$arr=range(0,4);
	shuffle($arr);
	$sql="select p.id,p.pName,p.pIndex,p.pNum,p.mPrice,p.iPrice,p.pDescription,p.pTime,p.isShow,p.isHot,c.name,p.cId from go_product as p join go_cate c on p.cId=c.id where p.pNum>0 and p.isHot>0 and p.id!={$proID} order by p.isHot DESC limit {$arr[0]},1";
	$rows=fetchAll($link,$sql);
	return $rows;
}

