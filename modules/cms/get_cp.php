<?php
session_start();
require_once "../.././commonlib.php";

if (!empty($_POST))
{
	$cn = connectDB();
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
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	
	
	$quary="select CPName,CPAddress from contentprovider where CPID='$action_id'";
	$res = Sql_exec($cn,$quary);
	$dt = Sql_fetch_array($res);
	$val_arr=array(
			"CPName"=>$dt['CPName'],
	    	"CPAddress"=>$dt['CPAddress']
		);
	
	echo json_encode($val_arr);	
	
	
	ClosedDBConnection($cn);
}

?>