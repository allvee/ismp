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
	
	$qry = "select FromState,ToState,Msg,URL,NotificationStatus,SubscriptionGroupID from statewisemsg where UniqueID='$id'";

    $res = Sql_exec($remoteCn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr['FromState'] = $dt['FromState'];
		$v_arr['ToState'] = $dt['ToState'];
		$v_arr['Msg'] = $dt['Msg'];
		$v_arr['URL'] = $dt['URL'];
		$v_arr['NotificationStatus'] = $dt['NotificationStatus'];
		$v_arr['SubscriptionGroupID'] = $dt['SubscriptionGroupID'];
		
	}
	
	ClosedDBConnection($remoteCn);
	
	echo json_encode($v_arr);
?>