<?php
session_start();
require_once "../.././commonlib.php";

if (!empty($_POST) && isset($_POST['action_id']))
{
	$cn = connectDB();
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	
	$quary="select user_id, UserID, UserName,Email,PASSWORD,image,role_id from tbl_user where user_id='$action_id'";
	$res = Sql_exec($cn,$quary);
	$dt = Sql_fetch_array($res);
	$val_arr=array(
	       "action_id"=>$dt['user_id'],
		   "user_id"=>$dt['UserID'],
	      "user_name"=>$dt['UserName'],
		  "email"=>$dt['Email'],
		  "password"=>$dt['PASSWORD'],
		  "role_id"=>$dt['role_id'],
		  "cp"=>$dt['cp_id']
	);
	
	echo json_encode($val_arr);	
	
	
	ClosedDBConnection($cn);
}

?>