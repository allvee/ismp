<?php
session_start();
require_once "../.././commonlib.php";

if (!empty($_POST))
{
	$cn = connectDB();
	$action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$name = mysql_real_escape_string(htmlspecialchars($_POST['name']));
	$user_name = mysql_real_escape_string(htmlspecialchars($_POST['user_name']));
	$email = mysql_real_escape_string(htmlspecialchars($_POST['email']));
	$password = mysql_real_escape_string(htmlspecialchars($_POST['password']));
	$cpid = mysql_real_escape_string(htmlspecialchars($_POST['cpid']));
	//$filename = mysql_real_escape_string(htmlspecialchars($_POST['filename']));
	
	if($action=="update"){
		    
			$quary="select password from tbl_cms_account where id='$action_id'";
			$res=Sql_exec($cn,$quary);
			$dt=Sql_fetch_array($res);
			if($dt["password"]!=$password)
			{
			    $password=encrypt($password);
			}
			$quary="update tbl_cms_account set name='$name', user_name='$user_name', PASSWORD='$password',email='$email',cpid='$cpid' where id='$action_id'";
			$res = Sql_exec($cn,$quary);
		    if($res)echo 0;
			else{
				echo 1;
			}
     }else if($action=="insert"){
		 	  
			  $hashPass=encrypt($password);
			  $quary="insert into tbl_cms_account(name,user_name,PASSWORD,email,cpid) 
			  values('$name','$user_name','$hashPass','$email','$cpid')";
			  $res = Sql_exec($cn,$quary);
		      if($res) echo 0;
			  else{
				    echo 1;
			  }
		 
     }else if($action=="delete"){
		 
		      
		      $quary="delete from tbl_cms_account where id='$action_id'";
			  $res = Sql_exec($cn,$quary);
		      if($res) echo 0;
			  else {
				     echo 1;
			  }
		 
    	}
	
	
	
	
	
	ClosedDBConnection($cn);
}

?>