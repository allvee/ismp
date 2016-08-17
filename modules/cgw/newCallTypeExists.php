<?php
require_once "../.././commonlib.php";
session_start();
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

$remoteCn=connectDB();

$callTypeIdVal = mysql_real_escape_string(htmlspecialchars($_POST['callTypeId']));

$qry = "SELECT `CallTypeID` FROM `calltype` WHERE ";
	$qry .= " `CallTypeID`='$callTypeIdVal'"; 

	
    $res = Sql_exec($remoteCn,$qry);
	$v_arr = array();
                            
    while($dt = Sql_fetch_array($res)){
		$CallTypeID = $dt['CallTypeID'];
		$v_arr['CallTypeID'] = $CallTypeID;
	}
	
if($cn)ClosedDBConnection($cn);
if($remoteCn)ClosedDBConnection($remoteCn);

	echo json_encode($v_arr);
?>