<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" manifest="cache.appcache">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UNIFIED GATEWAY</title>
<link rel="stylesheet" href=".././css/progressbar.css" type="text/css" />
<script type="text/javascript" src=".././js/jquery-1.11.0.min.js"></script>
<style type="text/css">
body {
	background: #161616 url(pattern_40.gif) top left repeat;
	margin: 0;
	padding: 0;
	font: 12px normal Verdana, Arial, Helvetica, sans-serif;
	height: 100%;
}

* {margin: 0; padding: 0; outline: none;}

img {border: none;}

a { 
	text-decoration:none; 
	color:#00c6ff;
}

h1 {
	font: 4em normal Arial, Helvetica, sans-serif;
	padding: 20px;	margin: 0;
	text-align:center;
	color:#bbb;
}

h1 small{
	font: 0.2em normal  Arial, Helvetica, sans-serif;
	text-transform:uppercase; letter-spacing: 0.2em; line-height: 5em;
	display: block;
}

.container {width: 600px; margin: 0 auto; overflow: hidden;}
/* Trigger button for javascript */

.trigger, .triggerFull, .triggerBar {
	background: #000000;
	background: -moz-linear-gradient(top, #161616 0%, #000000 100%);
	background: -webkit-linear-gradient(top, #161616 0%,#000000 100%);
	border-left:1px solid #111; border-top:1px solid #111; border-right:1px solid #333; border-bottom:1px solid #333; 
	font-family: Verdana, Geneva, sans-serif;
	font-size: 0.8em;
	text-decoration: none;
	text-transform: lowercase;
	text-align: center;
	color: #fff;
	padding: 10px;
	border-radius: 3px;
	display: block;
	margin: 0 auto;
	width: 140px;
}
		
.trigger:hover, .triggerFull:hover, .triggerBar:hover {
	background: -moz-linear-gradient(top, #202020 0%, #161616 100%);
	background: -webkit-linear-gradient(top, #202020 0%, #161616 100%);
}
</style>
<script>
//$(document).ready(function() {
//$(function(){
	var timer1_intervalid = 0;
	var timer2_intervalid = 0;
	function SYSTEM_UPGRADE(){
		$('#progress').removeClass('running').delay(10).queue(function(next){
			$(this).addClass('running');
			next();
		});
	}
	
	function progress_calculate(){
		$.post("progress_percentage.php",null,function(res){
			$("#progress_percentage").html(res+"%");
		});
	}
	//$(document).ready(function() {
		SYSTEM_UPGRADE();
		
		<?php 
		 if(isset($_REQUEST['action']) && $_REQUEST['action'] == "rollback"){
			 $version = mysql_real_escape_string(htmlspecialchars($_REQUEST['version']));
			 $version_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['version_name']));
		?>
		var data_val = "available_version=<?php echo $version; ?>&available_version_name=<?php echo $version_name; ?>";
		$.ajax({
			type: "POST",
			url: "rollback_system.php",
			data: data_val,
			cache: false,
			beforeSend: function(){
				timer1_intervalid = setInterval("SYSTEM_UPGRADE()", 4*1000);
				timer2_intervalid = setInterval("progress_calculate()", 10*1000);
			},
			success: function(res){
				$("#confirmation_msg").html("System Rollback Successfully Completed.\nCurrent Version <?php echo $version_name; ?>");
				//$("#progress,#progress_percentage").hide();
				clearInterval(timer1_intervalid);
				clearInterval(timer2_intervalid);
				$("#progress_percentage").html("100%");
				//$('#progress').addClass('running');
			}
		});
		<?php
		 } elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == "reset"){
			 $version = mysql_real_escape_string(htmlspecialchars($_REQUEST['version']));
			 $version_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['version_name']));
		?>
		var data_val = "available_version=<?php echo $version; ?>&available_version_name=<?php echo $version_name; ?>";
		$.ajax({
			type: "POST",
			url: "reset.php",
			data: data_val,
			cache: false,
			beforeSend: function(){
				timer1_intervalid = setInterval("SYSTEM_UPGRADE()", 4*1000);
				timer2_intervalid = setInterval("progress_calculate()", 10*1000);
			},
			success: function(res){
				$("#confirmation_msg").html("System Reset Successfully Completed.\nCurrent Version <?php echo $version_name; ?>");
				//$("#progress,#progress_percentage").hide();
				clearInterval(timer1_intervalid);
				clearInterval(timer2_intervalid);
				$("#progress_percentage").html("100%");
			//	$('#progress').addClass('running');
			}
		});
		<?php
		 } else {
			 $available_version = mysql_real_escape_string(htmlspecialchars($_REQUEST['available_version']));
			 $available_version_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['available_version_name']));
			 $curr_version = mysql_real_escape_string(htmlspecialchars($_REQUEST['curr_version']));
		?>
		var data_val = "available_version=<?php echo $available_version; ?>&available_version_name=<?php echo $available_version_name; ?>&curr_version=<?php echo $curr_version; ?>";
		$.ajax({
			type: "POST",
			url: "upgrade.php",
			data: data_val,
			cache: false,
			beforeSend: function(){
				timer1_intervalid = setInterval("SYSTEM_UPGRADE()", 4*1000);
				timer2_intervalid = setInterval("progress_calculate()", 10*1000);
			},
			success: function(res){
				$("#confirmation_msg").html("Version Upgraded. \nCurrent Version <?php echo $available_version_name; ?>");
				//$("#progress,#progress_percentage").hide();
				clearInterval(timer1_intervalid);
				clearInterval(timer2_intervalid);
				$("#progress_percentage").html("100%");
				//$('#progress').addClass('running');
			}
		});
		<?php
		 }
		?>
	//});
//});
</script>
</head>
<body>
	<div>
    	<h2 id="confirmation_msg" style="color:white;">Please wait...</h2>
    </div>
	<div class="container">
        <ul id="progress">
            <li><div id="layer1" class="ball"></div><div id="layer7" class="pulse"></div></li>
            <li><div id="layer2" class="ball"></div><div id="layer8" class="pulse"></div></li>
            <li><div id="layer3" class="ball"></div><div id="layer9" class="pulse"></div></li>
            <li><div id="layer4" class="ball"></div><div id="layer10" class="pulse"></div></li>
            <li><div id="layer5" class="ball"></div><div id="layer11" class="pulse"></div></li>
        </ul>
        <!--<span id="progress_percentage">
            0%
        </span>-->
        <a class="trigger" href="#" id="progress_percentage">0%</a>
    </div>
    
</body>