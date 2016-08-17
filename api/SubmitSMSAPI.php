<?php
set_time_limit(0); 
include_once("config_api.php");
require_once ".././commonlib.php";

function update_outbox_status($cn,$msg_id,$msg_status,$ref_id=NULL){
	$update_qry = "update smsoutbox set msgStatus='$msg_status'";
	if($ref_id != NULL) $update_qry .= ", refID='$ref_id', sentTime=NOW()";
	$update_qry .= " where msgID='$msg_id'";
	$res = Sql_exec($cn,$update_qry);
}

$api_url = $url.'?username='.$username.'&password='.$password.'&dlr=1&mask='.$mask;

$cn = connectDB();
$qry = "SELECT `db_type`,`db_server`,`db_uid`,`db_password`,`db_name` FROM tbl_process_db_access WHERE pname='SMSBLAST'";
$res = Sql_exec($cn,$qry);
$dt = Sql_fetch_array($res);

$dbtype=$dt['db_type'];
$MYSERVER=$dt['db_server'];
$MYUID=$dt['db_uid'];
$MYPASSWORD=$dt['db_password'];
$MYDB=$dt['db_name'];
ClosedDBConnection($cn);

$qry_remote = "SELECT `msgID`,`srcMN`,`dstMN`,`msg` FROM `smsoutbox` WHERE msgStatus='QUE'";
	
$cn_remote = connectDB();
$res = Sql_exec($cn_remote,$qry_remote);
while($dt = Sql_fetch_array($res)){
	$msg_id = $dt['msgID'];
	$mask = $dt['srcMN'];
	$destination = $dt['dstMN'];
	$msg = $dt['msg'];
	update_outbox_status($cn_remote,$msg_id,"PROCESSING");
	
	$encodedMsg =rawurlencode($msg);
	$encodedMsg = str_replace('.','%2E',$encodedMsg);
	$text = $encodedMsg; 
	
	$url = $api_url; 
	//"http://sms.doze.my/send.php?username=@UGW974EG&password=N0p@s$79&mask=UWG&destination=88017287888611&body=testsmstestsms&dlr=1";
	$url .= $mask;
	$url .= "&destination=".$destination;
	$url .= "&body=".$text;
	
	$response = file_get_contents($url);
	
	$res_arr = explode("|",$response);
	$res_msg = trim($res_arr[0]);
	$ref_id = trim($res_arr[1]);
	
	
	if(trim($res_msg) == "SUCCESS"){
		$msg_status = "SENT";
		update_outbox_status($cn_remote,$msg_id,$msg_status,$ref_id);
	} else {
		$msg_status = "FAILED";
		update_outbox_status($cn_remote,$msg_id,$msg_status);
	}
	// log_generator("SMSGW API RESPONSE :: ".$response,__FILE__,__FUNCTION__,__LINE__,NULL);
}
	
	ClosedDBConnection($cn_remote);
    
?>