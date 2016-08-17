<?php
session_start();
include_once "../../commonlib.php";
$value_arr = array();

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
	$qry="SELECT `ContentTypeID` FROM `contenttype` ";
	
	$rs = Sql_exec($cn, $qry);
	
	while($dt = Sql_fetch_array($rs))
	{
		//$pos = strpos($dt['CategoryID'], '-');
		//if ($pos === false) 
		 $value_arr[$dt['ContentTypeID']] = strtoupper($dt['ContentTypeID']);
		// else echo $dt['CategoryID'];
	}
	
	ClosedDBConnection($cn);

echo json_encode($value_arr);
?>