<?php
session_start();
require_once "../.././commonlib.php";

$v_arr = array();
$count = 0;
$is_error = 0;
$user_id = $_SESSION['USER_ID'];

	if(isset($_REQUEST['action_id'])){
		$cn = connectDB();
		$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
		
		$dbtype_bak=$dbtype;
		$MYSERVER_bak=$MYSERVER;
		$MYUID_bak=$MYUID;
		$MYPASSWORD_bak=$MYPASSWORD;
		$MYDB_bak=$MYDB;
		
		$qry = "SELECT `msg`,`mask`,`group_id` FROM `tbl_smsgw_msg_permission` WHERE ";
		$qry .= " `id`='".$action_id."' AND `status`='pending'"; 
	
		$res = Sql_fetch_array(Sql_exec($cn,$qry));
		$group_id = $res['group_id'];
		$msg = $res['msg'];
		$mask = $res['mask'];
	
	
		$qry = "SELECT `recipient_no` FROM `tbl_smsgw_group_recipient` WHERE ";
		$qry .= " `group_id`='".$group_id."' AND `is_active`='active'"; 
	
		$res = Sql_exec($cn,$qry);
		$v_arr = array();
		$text='';
		$encodedMsg =rawurlencode(htmlspecialchars($msg));
		$encodedMsg = str_replace('.','%2E',$encodedMsg);
	
		while($dt = Sql_fetch_array($res)){
			$mobile_number = $dt['recipient_no'];
			if($count == 0)
			{
				$text.= $mobile_number.'|'.$encodedMsg; 	
			}
			else
			{
				$text.="|".$mobile_number.'|'.$encodedMsg; 	
			}
			$count++;
		}
	
		$remoteCnQry="select * from tbl_process_db_access where pname='SMSBLAST'";
		$res = Sql_exec($cn,$remoteCnQry);
		$dt = Sql_fetch_array($res);
	
		$dbtype=$dt['db_type'];
		$MYSERVER=$dt['db_server'];
		$MYUID=$dt['db_uid'];
		$MYPASSWORD=$dt['db_password'];
		$MYDB=$dt['db_name'];
		ClosedDBConnection($cn);
	
		$remoteCn = connectDB();
	
		
		$count_qry = "select count(UserID) as c_user from user where UserName= '".$_SESSION["LoggedInUserID"]."' and Password='ssdt'";
		$insert_qry = "insert into user (UserName,Password) values ('".$_SESSION["LoggedInUserID"]."','ssdt')";
		
		$rs = Sql_exec($remoteCn, $count_qry);
		$dt = Sql_fetch_array($rs);
		$c_user = intval($dt['c_user']);
		if($c_user == 0) Sql_exec($remoteCn, $insert_qry);
		
		ClosedDBConnection($remoteCn);
	 
		$url = $bulk_sms_url . "UserName=".$_SESSION["LoggedInUserID"]."&Password=ssdt&Sender=" . $mask . "&text="; //"http://localhost/sendsms/SendMultipleSMS.php?UserName=admin&Password=admin&Sender=1234&text=";
		$url .=$text;
		$url .="&NO=".$count;
		// echo $url;
		$response = file_get_contents($url);
		
		if($response == "Successfully inserted to smsoutbox"){
			$dbtype=$dbtype_bak;
			$MYSERVER=$MYSERVER_bak;
			$MYUID=$MYUID_bak;
			$MYPASSWORD=$MYPASSWORD_bak;
			$MYDB=$MYDB_bak;
			
			$cn = connectDB();
			$qry = "update `tbl_smsgw_msg_permission` set ";
			$qry .= " `status`='proceed' where `id`='$action_id'"; 
		
			$res = Sql_exec($cn,$qry);
			ClosedDBConnection($cn);
		}
		
		echo $response;
    
	}
?>