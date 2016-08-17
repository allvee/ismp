<?php
	require_once "../.././commonlib.php";
	session_start();
	$v_arr = array();
	$count = 0;
	$user_id = $_SESSION['USER_ID'];
	
	$cn = connectDB();
	$remoteCnQry="select * from tbl_process_db_access where pname='CGW'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	//remote connection parameter set up
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);// close current connection
	
	$remoteCn = connectDB();
	
	$id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	
	$qry = "select id,countertype,aggtype,period,clause,value from counter where id='$id'";

    $res = Sql_exec($remoteCn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr['counter_id'] = $dt['id'];
		$v_arr['countertype'] = $dt['countertype'];
		$v_arr['agg_type_id'] = $dt['aggtype'];
		$v_arr['clause_id'] = $dt['clause'];
		$v_arr['value_id'] = $dt['value'];
		$v_arr['period_id'] = $dt['period'];
	}
	
	ClosedDBConnection($remoteCn);
	
	echo json_encode($v_arr);
?>