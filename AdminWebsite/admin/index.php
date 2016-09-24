<?php 
require_once '../include.php';
checkLogined();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>网站管理员</title>
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
<link href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="styles/backstage.css">
</head>

<body>
    <div class="head">
            <h3 class="head_text fl">魔都的面-后台管理系统</h3>
    </div>
    <div class="operation_user clearfix">
       
        <div class="link fr">
            <b>欢迎您
            <?php
                echo getLoginUser();
            ?>
            
            </b>&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php" class="icon icon_i">首页</a>
            <span></span><a href="javascript:void(0);" class="icon icon_j" onclick="back()">后退</a>
            <span></span><a href="javascript:void(0);" class="icon icon_t" onclick="forward()">前进</a>
            <span></span><a href="javascript:void(0);" class="icon icon_n" onclick="reload()">刷新</a>
            <span></span><a href="doAdminAction.php?act=logout" class="icon icon_e">退出</a>

        </div>
    </div>
    <div class="content clearfix">
        <div class="main">
            <!--右侧内容-->
            <div class="cont">
                <div class="title" id="titleOfMainFrame">后台管理</div>
      	 		<!-- 嵌套网页开始 -->         
                <iframe src="main.php"  frameborder="0" name="mainFrame" width="100%" height="522"></iframe>
                <!-- 嵌套网页结束 -->   
            </div>
        </div>
        <!--左侧列表-->
        <div class="menu">
            <div class="cont">
                <div class="title">功能菜单</div>
                <ul class="mList">
                    <li>
                        <h3><div onclick="show('menu1','change1')" style="cursor:pointer"><div id="change1" style="display:inline">+</div>&nbsp;&nbsp;<div style="display:inline">商品管理</div></div></h3>
                        <dl id="menu1" style="display:none;">
                        	<dd><a href="pro/addPro.php" target="mainFrame" onclick="changeTitle('添加商品');">添加商品</a></dd>
                            <dd><a href="pro/listPro.php" target="mainFrame" onclick="changeTitle('商品列表');">商品列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><div onclick="show('menu2','change2')" style="cursor:pointer"><div id="change2" style="display:inline">+</div>&nbsp;&nbsp;<div style="display:inline">分类管理</div></div></h3>
                        <dl id="menu2" style="display:none;">
                        	<dd><a href="cate/addCate.php" target="mainFrame" onclick="changeTitle('添加分类');">添加分类</a></dd>
                            <dd><a href="cate/listCate.php" target="mainFrame" onclick="changeTitle('分类列表');">分类列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><div  onclick="show('menu3','change3')" style="cursor:pointer" ><div id="change3" style="display:inline">+</div>&nbsp;&nbsp;<div style="display:inline">订单管理</div></div></h3>
                        <dl id="menu3" style="display:none;">
                            <dd><a href="order/listTodayOrder.php" target="mainFrame" onclick="changeTitle('今日订单');">今日订单</a></dd>
                            <dd><a href="order/listAllOrder.php" target="mainFrame" onclick="changeTitle('历史订单');">历史订单</a></dd>
                            <dd><a href="order/listAllSales.php" target="mainFrame" onclick="changeTitle('销量统计');">销量统计</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><div onclick="show('menu4','change4')" style="cursor:pointer"><div id="change4" style="display:inline">+</div>&nbsp;&nbsp;<div style="display:inline">顾客管理</div></div></h3>
                        <dl id="menu4" style="display:none;">
                        	<dd><a href="customer/listBalance.php" target="mainFrame" onclick="changeTitle('充值卡余额');">充值卡余额</a></dd>
                            <dd><a href="customer/listBalanceChange.php" target="mainFrame" onclick="changeTitle('充值/消费记录');">充值/消费记录</a></dd>
                        </dl>
                    </li>
                    <?php
                         $loginUser = getLoginUser();
                         if($loginUser != '00000')
                            $display = 'none';
                         else
                            $display = 'block';
                    ?>
                    <li style="display:<?php echo $display;?>">
                        <h3><div onclick="show('menu5','change5')" style="cursor:pointer"><div id="change5" style="display:inline">+</div>&nbsp;&nbsp;<div style="display:inline">管理员管理</div></div></h3>
                        <dl id="menu5" style="display:none;">
                        	<dd><a href="admin/addAdmin.php" target="mainFrame">添加管理员</a></dd>
                            <dd><a href="admin/listAdmin.php" target="mainFrame">管理员列表</a></dd>
                            <dd><a href="admin/changeBossPassword.php" target="mainFrame">更改密码</a></dd>
                        </dl>
                    </li>

                    
                </ul>
            </div>
        </div>

    </div>
    <script type="text/javascript">
    	function show(num,change){
	    		var menu=document.getElementById(num);
	    		var change=document.getElementById(change);
	    		if(change.innerHTML=="+"){
	    				change.innerHTML="- ";
	        	}else{
						change.innerHTML="+";
	            }
    		   if(menu.style.display=='none'){
    	             menu.style.display='';
    		    }else{
    		         menu.style.display='none';
    		    }
        }
        function changeTitle(title){
            document.getElementById('titleOfMainFrame').innerHTML = title;
        }
        function reload(){
            window.frames.mainFrame.location.reload();
        }
        function back(){
            window.frames.mainFrame.history.back();
        }
        function forward(){
            window.frames.mainFrame.history.forward();
        }
    </script>
</body>
</html>
