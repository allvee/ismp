<?php
session_start();
require_once "../.././commonlib.php";

$cn = connectDB();
$remoteCnQry="select * from tbl_process_db_access where pname='CMS'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	//remote connection parameter set up
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);// close current connection
	
	$cn=connectDB();
$quary="SELECT DISTINCT CPID,CPName FROM contentprovider";
$res = Sql_exec($cn,$quary);
$val_arr = array();
while($dt = Sql_fetch_array($res)){
	
	$val_arr[$dt['CPID']] = $dt['CPName'];
}

echo json_encode($val_arr);	


ClosedDBConnection($cn);


?>