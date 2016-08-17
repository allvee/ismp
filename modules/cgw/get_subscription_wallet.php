<?php
session_start();
require_once "../.././commonlib.php";

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
// open remote connection
$cn = connectDB();

$qry = "select `id`,`subscriptiongroupid`,`serviceid`,`bno`,`balance`,`walletid`,`startdate`,`enddate`,`freewallet`,`freewallet_enddate` from `subscriptionwallet`";
if(isset($_POST['action_id'])){
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$qry .= " where `id`='$action_id'"; 
}
	
    $res = Sql_exec($cn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr['action_id'] = $dt['id'];
		$v_arr['subscriptiongroupid'] = $dt['subscriptiongroupid'];
		$v_arr['serviceid'] = $dt['serviceid'];
		$v_arr['bno'] = $dt['bno'];
		
		$v_arr['balance'] = $dt['balance'];
		$v_arr['walletid'] = $dt['walletid'];
		$v_arr['startdate'] = $dt['startdate'];
		$v_arr['enddate'] = $dt['enddate'];
		$v_arr['freewallet'] = $dt['freewallet'];
		$v_arr['freewallet_enddate'] = $dt['freewallet_enddate'];
		
		$count++;
	}
	
	ClosedDBConnection($cn);
	
	echo json_encode($v_arr);
?>