<?php
require_once "commonlib.php";
	$cn = connectDB();

	$user_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['user_name']));
	$n_pass = encrypt(mysql_real_escape_string(htmlspecialchars($_REQUEST['n_pass'])));
	$is_error = 0;
	$qry = "update tbl_user set Password='$n_pass' where UserID='$user_name'";
	
	try {
		$rs=Sql_exec($cn,$qry);
	} catch(Exception $e){
		$is_error = 1;
	}
	
	ClosedDBConnection($cn);
	
	echo $is_error;
?>