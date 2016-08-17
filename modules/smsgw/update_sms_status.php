
<?php
session_start();
require_once "../.././commonlib.php";
$cn = connectDB();
$remoteCnQry="select * from tbl_process_db_access where pname='SMSBLAST'";
$res = Sql_exec($cn,$remoteCnQry);
$dt = Sql_fetch_array($res);

$dbtype=$dt['db_type'];
$MYSERVER=$dt['db_server'];
$MYUID=$dt['db_uid'];
$MYPASSWORD=$dt['db_password'];
$MYDB=$dt['db_name'];
ClosedDBConnection($cn);
$remoteCn=connectDB();
//Receive passing data	
$action_id = intval(mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id'])));
$action	   = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$is_error=1;
if(isset($action) && $action == "extra" && isset($action_id) && $action_id !=='')
{
	$qry="UPDATE smsoutbox set msgStatus=\"QUE\" where msgID='$action_id' AND msgStatus=\"FAILED\"";
	
	try{
		Sql_exec($remoteCn,$qry);
		$is_error=0;
	}catch(Exception $e){
	      $is_error=2;	
	}
	
	
       	
}else{
    $is_error=3;	
}
	
echo $is_error;		

?>