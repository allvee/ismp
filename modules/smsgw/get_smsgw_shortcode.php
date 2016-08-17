<?php
require_once "../.././commonlib.php";
session_start();
$v_arr = array();
$count = 0;
$user_id = $_SESSION['USER_ID'];
$cn = connectDB();
$remoteCnQry="select * from tbl_process_db_access where pname='SMSGW'";
$res = Sql_exec($cn,$remoteCnQry);
$dt = Sql_fetch_array($res);

$dbtype=$dt['db_type'];
$MYSERVER=$dt['db_server'];
$MYUID=$dt['db_uid'];
$MYPASSWORD=$dt['db_password'];
$MYDB=$dt['db_name'];
ClosedDBConnection($cn);

$remoteCn=connectDB();

$qry = "SELECT `shortcode`,`ErrorSMS`,`DefaultKeyword` FROM `shortcode` WHERE ";
if(isset($_POST['action_id'])){
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$qry .= " `shortcode`='$action_id'"; 
}
	
    $res = Sql_exec($remoteCn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr['shortcodeHidden']	=	$dt['shortcode'];
		$v_arr['shortcode']			=	$dt['shortcode'];
		$v_arr['ErrorSMS']			=	$dt['ErrorSMS'];
		$v_arr['DefaultKeyword']	=	$dt['DefaultKeyword'];
				
		$count++;
	}
	
ClosedDBConnection($remoteCn);
	
	echo json_encode($v_arr);
?>