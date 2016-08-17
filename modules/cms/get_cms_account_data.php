<?php
session_start();
require_once "../.././commonlib.php";

if (!empty($_POST) && isset($_POST['action_id']) && $_POST['action_id']!="")
{
	$cn = connectDB();
	
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	
	//$filename = mysql_real_escape_string(htmlspecialchars($_POST['filename']));

	$query="select name,user_name,email,password,cpid from tbl_cms_account where id='$action_id'";
	
	$res=Sql_exec($cn,$query);
	$dt = Sql_fetch_array($res);
	
	echo json_encode(array('name'=>$dt['name'],'user_name'=>$dt['user_name'],'email'=>$dt['email'],'password'=>$dt['password'],
	'cpid'=>$dt['cpid']));
	
	
	ClosedDBConnection($cn);
}

?>