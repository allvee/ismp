<?php
session_start();
include_once "../../commonlib.php";
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
	if(isset($_POST))
	{
		$action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
		$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
		
		$value_arr = array();
		
		$qry="SELECT RequestSourceID FROM categoryrequestsource where CategoryID='$action_id'";
		
		$rs = Sql_exec($cn, $qry);
		
		while($dt = Sql_fetch_array($rs))
		{
			array_push($value_arr,$dt['RequestSourceID']);
		}
		echo json_encode($value_arr);
		
	}


ClosedDBConnection($cn);


?>