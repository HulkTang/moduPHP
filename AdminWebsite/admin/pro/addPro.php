<?php 
require_once '../../include.php';
checkLogined();
$rows=getAllCate();
if(!$rows){
	alertMes("没有相应分类，请先添加分类!!", "addCate.php");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
	<title>-.-</title>
	<link href="../styles/global.css" rel="stylesheet" type="text/css" media="all" />
	<script type="text/javascript" src="../scripts/jquery-1.6.4.js"></script>
	<script type="text/javascript" src="../scripts/addFile.js"></script>
</head>
<body>
<h3>添加商品</h3>
<form action="../doAdminAction.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="act" value="addPro" >
<table width="70%"  border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">商品名称</td>
		<td><input type="text" name="gd_name"  placeholder="请输入商品名称"/></td>
	</tr>
	<tr>
		<td align="right">商品分类</td>
		<td>
		<select name="gd_catalogue_name">
			<?php foreach($rows as $row):?>
				<option value="<?php echo $row['ctlg_name'];?>"><?php echo $row['ctlg_name'];?></option>
			<?php endforeach;?>
		</select>
		</td>
	</tr>
	<tr>
		<td align="right">商品库存</td>
		<td><input type="text" name="gd_inventory"  placeholder="请输入商品库存"/></td>
	</tr>
	<tr>
		<td align="right">商品价格</td>
		<td><input type="text" name="gd_price"  placeholder="请输入商品价格"/></td>
	</tr>
	<tr>
		<td align="right">商品销量</td>
		<td><input type="text" name="gd_sales"  placeholder="请输入商品销量"/></td>
	</tr>
	<tr>
		<td align="right">商品描述</td>
		<td>
			<textarea name="gd_description" id="editor_id" placeholder="50字以内" style="width:100%;height:150px;"></textarea>
		</td>
	</tr>
	<tr>
		<td align="right">商品图片</td>
		<td>
			<a href="javascript:void(0)" id="selectFileBtn">添加附件</a>
			<div id="attachList" class="clear"></div>
		</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit"  value="发布商品"/></td>
	</tr>
</table>
</form>
</body>
</html>