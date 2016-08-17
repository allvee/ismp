<?php
	require_once ".././commonlib.php";
	$is_error = 0;
	
	$postData = file_get_contents("php://input");
	$dom = new DOMDocument( "1.0", "ISO-8859-15" ); 
	$dom->loadXML($postData); 
	$xPath = new domxpath($dom); 
	$reports = $xPath->query("/DeliveryReport/message");
		
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
	
	$cn_remote = connectDB();
	 
	foreach ($reports as $node) { 
		$messageID =$node->getAttribute('dlrTranctionID'); 
		$sendDate = $node->getAttribute('sentdate'); 
		$txtTimestamp =$node->getAttribute('donedate'); 
		$txtStatus =$node->getAttribute('status'); 
		$txtReason =$node->getAttribute('gsmerror'); 
		$mobileNumber =$node->getAttribute('msdn');
		
		$update_qry = "UPDATE smsoutbox
					   SET msgStatus = '$txtStatus', sentTime = '$txtTimestamp', Remarks = '$txtReason'
					   WHERE refID = '$messageID'";
		try{
			$result = Sql_exec($cn_remote,$update_qry);
		} catch(Exception $e)  {
			$is_error = 1;
			break;
		}
	}
	
	ClosedDBConnection($cn_remote);
	return $is_error;
	
?>