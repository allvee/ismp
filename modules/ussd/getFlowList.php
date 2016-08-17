<?php
	session_start();
	require_once "../.././commonlib.php";
	
	$role_id = $_SESSION['ROLE_ID'];
	$user_id = $_SESSION['USER_ID'];

	$cn = connectDB();
	$qry = "SELECT `db_type`,`db_server`,`db_uid`,`db_password`,`db_name` FROM tbl_process_db_access WHERE pname='CH'";
	$res = Sql_exec($cn,$qry);
	$dt = Sql_fetch_array($res);
	
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);
	
	$qry_remote = "SELECT DISTINCT Service FROM ivrmenu_copy ORDER BY Service ASC";
		
	$cn_remote = connectDB();
	$res = Sql_exec($cn_remote,$qry_remote);
	$v_arr = array();
	while($dt = Sql_fetch_array($res)){
		$service_name = $dt['Service'];
		$v_arr[$service_name] = $service_name;
	}  
	
	ClosedDBConnection($cn);
	echo json_encode($v_arr);
?>