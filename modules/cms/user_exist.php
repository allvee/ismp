<?php
session_start();
require_once "../.././commonlib.php";

if (!empty($_POST))
{
	$cn = connectDB();
	$user_id = mysql_real_escape_string(htmlspecialchars($_POST['user_id']));
	
	$query="SELECT UserID FROM tbl_user WHERE UserID='$user_id'";
	$rs=Sql_exec($cn,$query);
	if(Sql_Num_Rows($rs)>0) echo 0;
	else echo 1;
	ClosedDBConnection($cn);
}

?>