<?php
session_start();
require_once "../.././commonlib.php";

$v_arr = array();
$count = 0;
$user_id = $_SESSION['USER_ID'];

	$cn = connectDB();
	$remoteCnQry="select * from ismp.tbl_process_db_access where pname='CGW'";
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
	$cn=$remoteCn=connectDB();
$qry = "select `id`,`SubscriptionGroupID`,`ToSubscriptionGroupID`,`ToStatus`,`ActivationStart`,`ActivationEnd`,`Status`,`Ano`,`UserID` from `servicepromo` where `UserID`='".$user_id."'";
if(isset($_POST['action_id'])){
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$qry .= " and id='$action_id'"; 
}
	
	
    $res = Sql_exec($cn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr[$count]['SubscriptionGroupID'] = $dt['SubscriptionGroupID'];
		$v_arr[$count]['ToSubscriptionGroupID'] = $dt['ToSubscriptionGroupID'];
		$v_arr[$count]['ToStatus'] = $dt['ToStatus'];
		$v_arr[$count]['ActivationStart'] = $dt['ActivationStart'];
		$v_arr[$count]['ActivationEnd'] = $dt['ActivationEnd'];
		$v_arr[$count]['Status'] = $dt['Status'];
		$v_arr[$count]['Ano'] = $dt['Ano'];
		
		$count++;
	}
	
	ClosedDBConnection($cn);
	
	echo json_encode($v_arr);
?>