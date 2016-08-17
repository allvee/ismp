<?php
	require_once "../.././commonlib.php";
	session_start();
	$data = "";
	$count = 0;
	$counters = array();
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
	$counter_qry = "select counterid from accumulator where id='$id'";
	$rs = Sql_exec($remoteCn,$counter_qry);
	if($dt = Sql_fetch_array($rs)){
		$counter_array = $dt['counterid'];
		$counters = explode(",",$counter_array);
	}
	$qry = "select id from counter";

    $res = Sql_exec($remoteCn,$qry);
	while($dt = Sql_fetch_array($res)){
		if(in_array($dt['id'],$counters)){
			$data .= '<option value="'.$dt['id'].'" selected>'.$dt['id'].'</option>';
		} else {
			$data .= '<option value="'.$dt['id'].'">'.$dt['id'].'</option>';
		}
		
	}
	
	ClosedDBConnection($remoteCn);
	
	echo $data;
?>