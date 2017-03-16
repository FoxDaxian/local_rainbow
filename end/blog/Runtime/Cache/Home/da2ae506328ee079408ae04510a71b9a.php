<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<!-- <style>
		*{
			margin: 0;
			padding: 0;
		}
		body{
			background-color: #222222;
		}
		.wrap{
			position: absolute;
			width: 400px;
			height: 400px;
			left: 0;
			top: 0;
			right: 0;
			bottom: 0;
			margin:auto;
			box-shadow: 
			0px 0px 1px #FF0000,
			0px 0px 2px #FF7F00,
			0px 0px 4px #FFFF00,
			0px 0px 8px #00FF00,
			0px 0px 16px #00FFFF,
			0px 0px 32px #0000FF,
			0px 0px 64px #8B00FF;
			background-color: #fff;
			border-right: 4px;
		}
		.bg{
			position: absolute;
			border-right: 4px;
			left: 0;
			right: 0;
			top: 0;
			bottom: 0;
			margin: auto;
			width: 100%;
			height: 100%;
			background-color: rgba(254, 225, 191, 0.7);
			filter: blur(8px);
			-webkit-filter: blur(8px);
			z-index: 0;
		}
		p{
			font-size: 40px;
			color:#13CE66;
			font-weight: bold;
			text-align: center;
			margin-top: 140px;
			position: relative;
		}
		.si{
			font-size: 20px;
			color:#13CE66;
			font-weight: bold;
			text-align: center;
			margin-top: 50px;
			position: relative;
		}
	</style> -->
</head>
<body>
<?php var_dump($_SERVER) ?>
	<div class="wrap">
		<div class="bg"></div>
		<p>恭喜您，激活成功</p>
		<p class="si"><span class="time">3</span> s后跳转到首页,<a href="#">点击跳转</a></p>
	</div>
	<script>
		var time = document.querySelector('.time'),
		second = 3;
		var timer = setInterval(function() {
			time.innerHTML = --second;
			if( second === 0 ){
				location.href = "http://localhost:8080/";
				clearInterval(timer);
			}
		}, 1000);
	</script>
</body>
</html>