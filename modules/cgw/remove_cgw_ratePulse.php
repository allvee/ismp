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
$remoteCn=connectDB();

$rateIdVal = mysql_real_escape_string(htmlspecialchars($_POST['rateIdVal']));

$qry = "DELETE from `ratepulse` where ";
	$qry .= " `rateid`='$rateIdVal'"; 

	
    $res = Sql_exec($remoteCn,$qry);
//	while($dt = Sql_fetch_array($res)){
//		$v_arr[$count]['stepno'] = $dt['stepno'];
//		$v_arr[$count]['stepduration'] = $dt['stepduration'];
//		$v_arr[$count]['steppulse'] = $dt['steppulse'];
//		$v_arr[$count]['steppulserate'] = $dt['steppulserate'];
//		$v_arr[$count]['serviceunit'] = $dt['serviceunit'];
//	
//		$count++;
//	}
	
	if($cn)ClosedDBConnection($cn);
	if($remoteCn)ClosedDBConnection($remoteCn);
	echo $qry;
?>