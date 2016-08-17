<?php
require_once "../.././commonlib.php";
//session_start();
$v_arr = array();
$count = 0;
//$user_id = $_SESSION['USER_ID'];

if(isset($_POST['operator_db'])){
	$cn = connectDB();
	$operator_db = mysql_real_escape_string(htmlspecialchars($_POST['operator_db']));
	$remoteCnQry="select * from tbl_process_db_access where id='$operator_db'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	//remote connection parameter set up
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);// close current connection
	// open remote connection
	$cn = connectDB();
	
		$qry = "select `id`,`Root`,`ServiceID`, 
	`ServiceName`, 
	`Description`, 
	`IsDeregMsg`, 
	`DeRegURL`, 
	`DeRegMsg`, 
	`DeRegAllMsg`, 
	`DeRegExtraURL`, 
	`RegURL`, 
	`RegMsg`, 
	`RegExtraURL`, 
	`AlreadyRegistedMsg`, 
	`InfoURL`,
	`Status`,
	`SrcType`, 
	`SMSText`, 
	`ShortCode` from `service`";
		if(isset($_POST['action_id'])){
			$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
			$qry .= " where `id`='$action_id'"; 
		}
		
		$res = Sql_exec($cn,$qry);
		while($dt = Sql_fetch_array($res)){
			$v_arr['action_id'] = $dt['id'];
			$v_arr['Root'] = $dt['Root'];
			$v_arr['ServiceID'] = $dt['ServiceID'];
			$v_arr['ServiceName'] = $dt['ServiceName'];
			$v_arr['Description'] = $dt['Description'];
			$v_arr['IsDeregMsg'] = $dt['IsDeregMsg'];
			$v_arr['DeRegURL'] = $dt['DeRegURL'];
			$v_arr['DeRegMsg'] = $dt['DeRegMsg'];
			$v_arr['DeRegAllMsg'] = $dt['DeRegAllMsg'];
			$v_arr['DeRegExtraURL'] = $dt['DeRegExtraURL'];
			$v_arr['RegURL'] = $dt['RegURL'];
			$v_arr['RegMsg'] = $dt['RegMsg'];
			$v_arr['RegExtraURL'] = $dt['RegExtraURL'];
			$v_arr['AlreadyRegistedMsg'] = $dt['AlreadyRegistedMsg'];
			$v_arr['InfoURL'] = $dt['InfoURL'];
			$v_arr['Status'] = $dt['Status'];
			$v_arr['SrcType'] = $dt['SrcType'];
			$v_arr['SMSText'] = $dt['SMSText'];
			$v_arr['ShortCode'] = $dt['ShortCode'];
			
			$count++;
		}
		
	ClosedDBConnection($cn);
		
	echo json_encode($v_arr);
}
?>