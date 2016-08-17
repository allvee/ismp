<?php
require_once "commonlib.php";

	$user_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['user_name']));
	$c_pass = mysql_real_escape_string(htmlspecialchars($_REQUEST['c_pass']));
	
	$cn = connectDB();
	$qry = "select UserID,Password from user where UserID='$user_name' and Password='$c_pass'";
	$rs=Sql_exec($cn,$qry);
					
	$dt=Sql_fetch_array($rs);
	
	ClosedDBConnection($cn);
	
	if($dt['UserID'] == $user_name && $dt['Password'] == $c_pass){
		$is_error = 0;
	} else {
		$is_error = 1;
	}
	echo $is_error;
?>