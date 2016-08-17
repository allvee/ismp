<?php
session_start();
require_once "../.././commonlib.php";

if (!empty($_POST))
{
	$cn = connectDB();
	$action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	
	if($action=="extra"){
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
		
		$qry = "Select `CategoryID` from `content` where `ContentID`='$action_id'";
		
		try {
			$rs=Sql_exec($cn, $qry);
			$dt = Sql_fetch_array($rs);
			$CategoryID = $dt['CategoryID'];
			$response = file_get_contents($PATH_OF_CONTENT_UPLOAD.$CategoryID);
			echo $response;
		}  catch( Exception $e) {
			$is_error = 1;
		}
		
		
	}
	ClosedDBConnection($cn);
	
}

?>