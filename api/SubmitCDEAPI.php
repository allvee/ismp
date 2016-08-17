<?php
require_once ".././commonlib.php";

function update_inbox_status($cn,$msg_id,$msg_status){
	$update_qry = "update smsinbox set msgStatus='$msg_status'";
	$update_qry .= " where msgID='$msg_id'";
	$res = Sql_exec($cn,$update_qry);
}

$cn = connectDB();
$qry = "SELECT `id`,`pname`,`db_type`,`db_server`,`db_uid`,`db_password`,`db_name` FROM tbl_process_db_access WHERE pname='SMSGW'";
$res = Sql_exec($cn,$qry);
$dt = Sql_fetch_array($res);

$dbtype=$dt['db_type'];
$MYSERVER=$dt['db_server'];
$MYUID=$dt['db_uid'];
$MYPASSWORD=$dt['db_password'];
$MYDB=$dt['db_name'];
ClosedDBConnection($cn);

$cn_remote = connectDB();
$qry_remote = "SELECT srcMN, dstMN, msg, msgID FROM smsinbox where msgStatus='QUE'";
$res = Sql_exec($cn_remote,$qry_remote);

while($dt = Sql_fetch_array($res)){
	$mn = $dt['srcMN'];
	$sc = $dt['dstMN'];
	$msg = $dt['msg'];
	$msg_id = $dt['msgID'];
	update_inbox_status($cn_remote,$msg_id,"PROCESSING");
	
	$url = $cde_url;
	$url .= "mn=" . $mn;
	$url .= "&msg=" . urlencode($msg);
	$url .= "&nl=Y&AddType=true";
	$url .= "&tranID=" . $msgID;
	$url .= "&sc=" . $sc;
	
	echo $response = file_get_contents($url);
	
	if(trim($response) == "Successfully inserted to smsoutbox"){
		$msg_status = "SENT";
		
	} else {
		$msg_status = "FAILED";
	}
	update_inbox_status($cn_remote,$msg_id,$msg_status);
}

ClosedDBConnection($cn_remote);
	
?>