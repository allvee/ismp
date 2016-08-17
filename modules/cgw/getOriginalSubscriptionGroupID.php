<?php
require_once "../.././commonlib.php";
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
$qry = "Select SubscriptionGroupID from subscriptiongroup order by SubscriptionGroupID asc"; 

	$cn = connectDB();
    $res = Sql_exec($remoteCn,$qry);
	$v_arr = array();
                            
    while($dt = Sql_fetch_array($res)){
		$SubscriptionGroupID = $dt['SubscriptionGroupID'];
		$v_arr[$SubscriptionGroupID] = $SubscriptionGroupID;
	}
	
	if($cn)ClosedDBConnection($cn);
	if($remoteCn)ClosedDBConnection($remoteCn);
	echo json_encode($v_arr);
?>