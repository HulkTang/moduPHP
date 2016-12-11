<?php 
require_once '../../include.php';
checkLogined();
$rows=getAllCate();
if(!$rows){
	alertMes("没有相应分类，请先添加分类!!", "addCate.php");
}
$id=$_REQUEST['id'];
$proInfo=getProById($id);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>-.-</title>
<link href="../styles/global.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../scripts/jquery-1.6.4.js"></script>
<script>
        $(document).ready(function(){
        	$("#selectFileBtn").click(function(){
        		$fileField = $('<input type="file" name="thumbs[]"/>');
        		$fileField.hide();
        		$("#attachList").append($fileField);
        		$fileField.trigger("click");
        		$fileField.change(function(){
        		$path = $(this).val();
        		$filename = $path.substring($path.lastIndexOf("\\")+1);
                    $attachItem = $('<div class="attachItem"><div class="left"></div></div>');
                    $attachItem.find(".left").html($filename);
        		$("#attachList").append($attachItem);		
        		});
        	});
        	$("#attachList>.attachItem").find('a').live('click',function(obj,i){
        		$(this).parents('.attachItem').prev('input').remove();
        		$(this).parents('.attachItem').remove();
        	});
        });
</script>
</head>
<body>
<h3>编辑商品</h3>
<form action="../doAdminAction.php?" method="post" enctype="multipart/form-data">
	<!--        表单无法同时以post get传递参数，采用该方法传递。-->
	<input type="hidden" name="act" value="editPro" >
	<input type="hidden" name="id" value="<?php echo $id;?>" >
	
<table width="70%"  border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">商品名称</td>
		<td><input type="text" name="gd_name"  value="<?php echo $proInfo['gd_name'];?>"/></td>
	</tr>
	<tr>
		<td align="right">商品分类</td>
		<td>
		<select name="gd_catalogue_name">
			<?php foreach($rows as $row):?>
				<option value="<?php echo $row['ctlg_name'];?>" <?php echo $row['ctlg_name']==$proInfo['gd_catalogue_name']?"selected='selected'":null;?>><?php echo $row['ctlg_name'];?></option>
			<?php endforeach;?>
		</select>
		</td>
	</tr>
	<tr>
		<td align="right">商品库存</td>
		<td><input type="text" name="gd_inventory"  value="<?php echo $proInfo['gd_inventory'];?>"/></td>
	</tr>
	<tr>
		<td align="right">商品价格</td>
		<td><input type="text" name="gd_price"  value="<?php echo $proInfo['gd_price'];?>"/></td>
	</tr>
	<tr>
		<td align="right">商品销量</td>
		<td><input type="text" name="gd_sales"  placeholder="请输入商品销量"/></td>
	</tr>
	<tr>
		<td align="right">商品描述</td>
		<td><textarea name="gd_description" style="width:100%;height:150px;"><?php echo $proInfo['gd_description']?></textarea></td>
	</tr>
	<tr>
		<td align="right">商品图像</td>
		<td>
			<a href="javascript:void(0)" id="selectFileBtn">添加图片</a>
			<div id="attachList" class="clear"></div>
		</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit"  value="编辑商品"/></td>
	</tr>
</table>
</form>
</body>
</html>