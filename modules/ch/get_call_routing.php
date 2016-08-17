<?php
require_once "../.././commonlib.php";
$cn = connectDB();
$remoteCnQry="select * from ismp.tbl_process_db_access where pname='CH'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);
	
	$remoteCn=connectDB();
$v_arr = array();
$count = 0;
$qry = "select ano,bno,Status,ProvisionEndDate,url from geturl where ";
if(isset($_POST['action_id'])){
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$qry .= "id='$action_id'"; 
}

	
    $res = Sql_exec($remoteCn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr[$count]['ano'] = $dt['ano'];
		$v_arr[$count]['bno'] = $dt['bno'];
		$v_arr[$count]['status'] = $dt['Status'];
		$v_arr[$count]['provision_end_date'] = $dt['ProvisionEndDate'];
		$v_arr[$count]['url'] = $dt['url'];
		
		$count++;
	}
	
	ClosedDBConnection($remoteCn);
	
	echo json_encode($v_arr);
?>