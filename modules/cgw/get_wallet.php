<?php
require_once "../.././commonlib.php";
$cn = connectDB();
$qry="SELECT * FROM tbl_process_db_access WHERE pname='CGW'";
$res = Sql_exec($cn,$qry);
$dt=Sql_fetch_array($res);
$dbtype=$dt["db_type"];
$MYSERVER=$dt["db_server"];
$MYUID=$dt["db_uid"];
$MYPASSWORD=$dt["db_password"];
$MYDB=$dt["db_name"];
ClosedDBConnection($cn);

$remote_cn = $cn = connectDB();
$qry = "SELECT `walletid`,`walletname` FROM `walletinfo` ORDER BY `walletname` ASC"; 

	$cn = connectDB();
    $res = Sql_exec($cn,$qry);
	$v_arr = array();
                            
    while($dt = Sql_fetch_array($res)){
		$walletid = $dt['walletid'];
		$v_arr[$walletid] = $dt['walletname'];
	}
	
	ClosedDBConnection($cn);
	echo json_encode($v_arr);
?>