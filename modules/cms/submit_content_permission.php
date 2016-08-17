<?php
session_start();
require_once "../.././commonlib.php";

if (!empty($_POST))
{
	$cn = connectDB();
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$remoteCnQry="select * from tbl_process_db_access where pname='CMS'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	//remote connection parameter set up
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);// close current connection
	
	$cn=connectDB();
	
	$action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$user_id = $_SESSION['USER_ID'];
	$status = '';
	$is_error = 0;
	
	if($action=="delete"){
		$status = 'Active';
    } else if($action=="edit"){
		$status = 'Rejected';
    } else {
		$status = 'pending';	
	}
	$query="update content set `Status`='$status', `UserID`='$user_id', `LastUpdate`=NOW() where `ContentID`='$action_id'";
	try {
		$res = Sql_exec($cn,$query);
	} catch (Exception $e){
		$is_error = 1;
	}
	
	ClosedDBConnection($cn);
	
	echo $is_error;
}

?>