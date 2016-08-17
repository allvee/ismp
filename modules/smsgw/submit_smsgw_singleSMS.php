<?php
session_start();
require_once "../.././commonlib.php";

if (!empty($_POST))
{
	$dstMN = htmlspecialchars($_POST['dstMN']);
	$msg = $_POST['msg'];
	$srcMN = htmlspecialchars($_POST['srcMN']);

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

	$text='';
    $encodedMsg =rawurlencode($msg);
	$encodedMsg = str_replace('.','%2E',$encodedMsg);
	$text.= $dstMN.'|'.$encodedMsg; 
	
	$count_qry = "select count(UserID) as c_user from user where UserName= '".$_SESSION["LoggedInUserID"]."'";
	$insert_qry = "insert into user (UserName,Password) values ('".$_SESSION["LoggedInUserID"]."','ssdt')";
	
	$remoteCn = connectDB();
	$rs = Sql_exec($remoteCn, $count_qry);
    $dt = Sql_fetch_array($rs);
	$c_user = intval($dt['c_user']);
	if($c_user == 0) Sql_exec($remoteCn, $insert_qry);
	
	ClosedDBConnection($remoteCn);
	
	$url = $single_sms_url . "UserName=".$_SESSION["LoggedInUserID"]."&Password=ssdt&Sender="; //"http://localhost/SendSMS/sendSingleSMS.php?UserName=admin&Password=admin&Sender=1234&text=";
	$url .= $srcMN;
	$url .= "&text=".$text;
	//$url .="&NO=".$count;
	//echo $url;
	$response = file_get_contents($url);
	if(trim($response) == "Successfully inserted to smsoutbox"){
		echo 0;
	} else {
		echo 1;
	}
    
}
?>