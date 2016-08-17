<?php
session_start();
require_once "../.././commonlib.php";

if (!empty($_POST))
{
	$cn = connectDB();
	$action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$user_name = mysql_real_escape_string(htmlspecialchars($_POST['user_name']));
	$email = mysql_real_escape_string(htmlspecialchars($_POST['email']));
	$password = mysql_real_escape_string(htmlspecialchars($_POST['password']));
	$file = mysql_real_escape_string(htmlspecialchars($_POST['file']));
	//$filename = mysql_real_escape_string(htmlspecialchars($_POST['filename']));
	
	if($action=="update"){
		    
			
			
		    $quary="update tbl_user set UserName='$user_name', Email='$email', PASSWORD='$password' where user_id='$action_id'";
			$res = Sql_exec($cn,$quary);
		    if($res)echo 0;
			else {
				echo 1;
			}
     
	 
	 }else if($action=="insert"){
		 
		      $path="images/user/".$file;
		      $quary="insert into tbl_user(UserID,UserName,Email,Password,LastUpdate,image) 
			  values('$user_name','$user_name','$email','$password', NOW(), '$path')";
			  $res = Sql_exec($cn,$quary);
		      if($res) echo 0;
			  else {
				     echo 1;
			  }
		 
    	}else if($action=="delete"){
		 
		      
		      $quary="delete from tbl_user where user_id='$action_id'";
			  $res = Sql_exec($cn,$quary);
		      if($res) echo 0;
			  else {
				     echo 1;
			  }
		 
    	}
	
	
	
	
	
	ClosedDBConnection($cn);
}

?>