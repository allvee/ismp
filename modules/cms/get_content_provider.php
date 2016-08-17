<?php
include_once "../../commonlib.php";
$value_arr = array();
$qry="SELECT CPID,CPName FROM contentprovider ORDER BY CPID ASC";
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
	$rs = Sql_exec($cn, $qry);
	
	while($dt = Sql_fetch_array($rs))
	{
		 $value_arr[$dt['CPID']] = $dt['CPName'];
	}

ClosedDBConnection($cn);

echo json_encode($value_arr);
?>