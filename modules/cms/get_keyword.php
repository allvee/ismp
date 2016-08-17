<?php
require_once "../.././commonlib.php";
// session_start();
$v_arr = array();
$count = 0;
// $user_id = $_SESSION['USER_ID'];
	
	$cn = connectDB();
		$remoteCnQry="select * from tbl_process_db_access where pname='SMSGW'";
		$res = Sql_exec($cn,$remoteCnQry);
		$dt = Sql_fetch_array($res);
		//remote connection parameter set up
		$dbtype=$dt['db_type'];
		$MYSERVER=$dt['db_server'];
		$MYUID=$dt['db_uid'];
		$MYPASSWORD=$dt['db_password'];
		$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);// close current connection

	$qry="select `keyword` from `keyword` where `Status`='active'";
	
	$cn=connectDB();
		$res = Sql_exec($cn,$qry);
		while($dt = Sql_fetch_array($res)){
			$keyword = $dt['keyword'];
			$v_arr[$keyword] = $keyword;
		}
	ClosedDBConnection($cn);

	echo json_encode($v_arr);
?>