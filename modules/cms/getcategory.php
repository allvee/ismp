<?php
session_start();
include_once "../../commonlib.php";
$value_arr = array();
$ROLE_ID = $_SESSION['ROLE_ID'];
$CP_ID = $_SESSION['CP_ID'];

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
	$qry="SELECT `CategoryID` FROM `category` ";
	
	if($ROLE_ID != "1") $qry .= " where `CategoryID` in (select `CategoryID` from categorypermission where `CPID`='".$CP_ID."' and `HasPermission`='Yes')";
	
	$qry.=" ORDER BY CategoryID ASC";

	$rs = Sql_exec($cn, $qry);
	
	while($dt = Sql_fetch_array($rs))
	{
		//$pos = strpos($dt['CategoryID'], '-');
		//if ($pos === false) 
		 $value_arr[$dt['CategoryID']] = $dt['CategoryID'];
		// else echo $dt['CategoryID'];
	}
	
	ClosedDBConnection($cn);

echo json_encode($value_arr);
?>