<?php
require_once '../../include.php';
checkLogined();
$link = connect();
$order=isset($_REQUEST['order'])?$_REQUEST['order']:null;
$orderBy=$order?" order by ".$order:null;
$keywords=isset($_REQUEST['keywords'])?$_REQUEST['keywords']:null;
$where=$keywords?" where gd_name like '%{$keywords}%'":null;
//得到数据库中所有商品
$sql="select gd_name,gd_price,gd_inventory,gd_description,gd_sales,gd_picture,gd_catalogue_name from gd_mst {$where} {$orderBy};";
$totalRows=getResultNum($link,$sql);
$pageSize=6;
$totalPage=ceil($totalRows/$pageSize);
$page=isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql="select gd_id,gd_name,gd_price,gd_inventory,gd_description,gd_sales,gd_picture,gd_catalogue_name from gd_mst {$where} {$orderBy} limit {$offset},{$pageSize}";
$rows=array();
if($totalPage!=0)
	$rows=fetchAll($link,$sql);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>-.-</title>
<link rel="stylesheet" href="../styles/backstage.css">
<link rel="stylesheet" href="../scripts/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
<script src="../scripts/jquery-ui/js/jquery-1.10.2.js"></script>
<script src="../scripts/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="../scripts/jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
</head>

<body>
<div id="showDetail"  style="display:none;">

</div>
<div class="details">
                    <div class="details_operation clearfix">
                        <div class="bui_select">
                            <input type="button" value="添&nbsp;&nbsp;加" class="add" onclick="addPro()">
                        </div>
                        <div class="fr">
                            <div class="text">
                                <span>商品价格：</span>
                                <div class="bui_select">
                                    <select id="selectByPrice" class="select" onchange="change(this.value)">
                                    	<option>-请选择-</option>
										<option value="gd_price desc" <?php echo $order=="gd_price desc"?"selected='selected'":null;?>>由高到底</option>
                                        <option value="gd_price asc" <?php echo $order=="gd_price asc"?"selected='selected'":null;?>>由低到高</option>
                                    </select>
                                </div>
                            </div>
                            <div class="text">
                                <span>库存：</span>
                                <div class="bui_select">
                                 <select id="selectByInventory" class="select" onchange="change(this.value)">
                                 	<option>-请选择-</option>
                                        <option value="gd_inventory desc" <?php echo $order=="gd_inventory desc"?"selected='selected'":null;?>>由高到底</option>
                                        <option value="gd_inventory asc"<?php echo $order=="gd_inventory asc"?"selected='selected'":null;?>>由低到高</option>
                                    </select>
                                </div>
                            </div>
							<div class="text">
								<span>销量：</span>
								<div class="bui_select">
									<select id="selectByOrder" class="select" onchange="change(this.value)">
										<option>-请选择-</option>
										<option value="gd_sales desc" <?php echo $order=="gd_sales desc"?"selected='selected'":null;?>>由高到底</option>
										<option value="gd_sales asc" <?php echo $order=="gd_sales asc"?"selected='selected'":null;?>>由低到高</option>
									</select>
								</div>
							</div>
                            <div class="text">

								<input type="text" value="<?php echo isset($_REQUEST['keywords'])?$_REQUEST['keywords']:null;?>" class="search"  id="search" onkeypress="search()" >
								<input type="button" value="搜索" class="btn" onclick="searchbtn('<?php echo $order;?>')">
                            </div>
                        </div>
                    </div>
                    <!--表格-->
                    <table class="table" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="12%">商品名称</th>
                                <th width="8%">商品分类</th>
                                <th width="8%">商品库存</th>
                                <th width="8%">商品销量</th>
                                <th width="8%">商品价格</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($rows as $row):?>
                            <tr>
                                <td><?php echo $row['gd_name']; ?></td>
                                <td><?php echo $row['gd_catalogue_name'];?></td>
								<td><?php echo $row['gd_inventory'];?></td>
								<td><?php echo $row['gd_sales'];?></td>
								<td><?php echo $row['gd_price'];?>元</td>
                                <td align="center">
                                				<input type="button" value="详情" class="btn" onclick="showDetail(<?php echo $row['gd_id'];?>,'<?php echo $row['gd_name'];?>')">
											 	<input type="button" value="二维码" class="btn"onclick="getQRForPro(<?php echo $row['gd_id'];?>)">
												<input type="button" value="配置" class="btn"onclick="configPro(<?php echo $row['gd_id'];?>)">
												<input type="button" value="修改" class="btn" onclick="editPro(<?php echo $row['gd_id'];?>)">
												<input type="button" value="删除" class="btn"onclick="delPro(<?php echo $row['gd_id'];?>)">
					                            <div id="showDetail<?php echo $row['gd_id'];?>" style="display:none;">
					                        	<table class="table" cellspacing="0" cellpadding="0">
					                        		<tr>
					                        			<td width="20%" align="right">商品名称</td>
					                        			<td><?php echo $row['gd_name'];?></td>
					                        		</tr>
					                        		<tr>
					                        			<td width="20%"  align="right">商品分类</td>
					                        			<td><?php echo $row['gd_catalogue_name'];?></td>
					                        		</tr>
					                        		<tr>
					                        			<td width="20%"  align="right">商品库存</td>
					                        			<td><?php echo $row['gd_inventory'];?></td>
					                        		</tr>
													<tr>
														<td width="20%"  align="right">商品销量</td>
														<td><?php echo $row['gd_sales'];?></td>
													</tr>
					                        		<tr>
					                        			<td  width="20%"  align="right">商品价格</td>
					                        			<td><?php echo $row['gd_price'];?></td>
					                        		</tr>

					                        		<tr>
					                        			<td width="20%"  align="right">商品图片</td>
					                        			<td><img width="100" height="100" src="<?php echo $row['gd_picture'];?>" alt=""/> </td>
					                        		</tr>

					                        	</table>
					                        	<span style="display:block;width:80%; ">
					                        	商品描述<br/>
					                        	<?php echo $row['gd_description'];?>
					                        	</span>
					                        </div>
                                
                                </td>
                            </tr>
                           <?php  endforeach;?>
                           <?php if($totalRows>$pageSize):?>
                            <tr>
                            	<td colspan="7"><?php echo showPage($page, $totalPage,"&keywords={$keywords}&order={$order}");?></td>
                            </tr>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
<script type="text/javascript">

	window.onload=function(){
	
	}
	function showDetail(id,t){
		$("#showDetail"+id).dialog({
			  height:"auto",
			  width: "auto",
			  position: {my: "center", at: "center",  collision:"fit"},
			  modal:false,
			  draggable:true,
			  resizable:true,
			  title:"商品名称："+t,
			  show:"slide",
			  hide:"explode"
		});
	}
	
	function configPro(id){
		window.location='listProConfig.php?id='+id;
	}
	
	function addPro(){
		window.location='addPro.php';
	}
	function editPro(id){
		window.location='editPro.php?id='+id;
	}
	function delPro(id){
		if(window.confirm("您确认要删除吗？")){
			window.location="../doAdminAction.php?act=delPro&id="+id;
		}
	}
	function search(){
		if(event.keyCode==13){
			var keyword=document.getElementById("search").value;
			window.location="listPro.php?keywords="+keyword;
		}
	}
	function searchbtn(order){
		var keyword=document.getElementById("search").value;
		window.location="listPro.php?keywords="+keyword+"&order="+order;
	}
	function change(order){
		var keyword=document.getElementById("search").value;
		window.location="listPro.php?keywords="+keyword+"&order="+order;
	}
	function getQRForPro(id){
			window.location="../doAdminAction.php?act=getQRForPro&id="+id;
	}
</script>
</body>
</html>