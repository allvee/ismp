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
	
	$qry = "select id,discounttype,amount from accumulator where id='$id'";

    $res = Sql_exec($remoteCn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr['accumulator_id'] = $dt['id'];
		$v_arr['discount_type_id'] = $dt['discounttype'];
		$v_arr['amount_id'] = $dt['amount'];
	}
	
	ClosedDBConnection($remoteCn);
	
	echo json_encode($v_arr);
?>