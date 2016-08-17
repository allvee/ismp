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
// open remote connection
$cn = connectDB();

$qry = "select `pName`,`pValue` from `applicationsettings`";
if(isset($_POST['action_id'])){
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$qry .= " where `pName`='$action_id'"; 
}
	
    $res = Sql_exec($cn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr[$count]['pName'] = $dt['pName'];
		$v_arr[$count]['pValue'] = $dt['pValue'];
		
		$count++;
	}
	
	ClosedDBConnection($cn);
	
	echo json_encode($v_arr);
?>