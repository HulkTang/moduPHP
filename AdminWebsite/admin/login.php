<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>登陆</title>
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
<link href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link type="text/css" rel="stylesheet" href="styles/main.css">
</head>
<body>
<div class="jumbotron row">
	<div class="col-md-2"></div>
	<div class="col-md-10">
	    <h1>魔都的面</h1>
	    <p>后台管理系统</p>
	</div>
</div>

<div class="container">
<div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
             	<form action="doLogin.php" method="post" role="form" >
                    <div class="form-group">
    	      	
    	                <label>帐号</label>
    	                <input type="text"  name="username" placeholder="请输入管理员帐号" class="form-control">
                    </div>
                    <div class="form-group ">
                         <label>密码</label>
                        <input type="password"  name="password" placeholder="请输入管理员密码" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>验证码</label>
                        <div class="row">
                            <div class="col-xs-8">
                            	<input type="text"  name="verify" class="form-control ">
                            </div>
                            <div class="col-xs-4">
                            	<img src="../operation/getVerify.php" alt="验证码" class="verify_img "/>
                            </div>
                        </div>
                    </div>
    	      		<div class="form-group">
    	      			
    	      			<input type="checkbox" id="a1" class="checked" name="autoFlag" value="1">
    	      			<label for="a1">一周内自动登陆</label>
    	      		</div>
    	      			<button type="submit" class="btn btn-default" style="width:100%">登录</button>
    	        </form>
            </div>
              
        </div>
    </div>
<div class="col-md-4"></div>
</div>
<div class="hr_25"></div>
<div class="footer">
	<p><a href="#">简介</a><i>|</i><a href="#">公告</a><i>|</i> <a href="#">招纳贤士</a><i>|</i><a href="#">联系我们</a><i>|</i>客服热线：021-8888-8888</p>
</div>
</body>
</html>
