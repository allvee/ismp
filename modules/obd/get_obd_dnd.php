<?php
require_once "../.././commonlib.php";

$v_arr = array();
$count = 0;
$qry = "select server_id ,msisdn,DATE(time_stamp), TIME(time_stamp) from tbl_obd_dnd_list";
if(isset($_POST['action_id'])){
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$qry .= " and id='$action_id'"; 
}

	$cn = connectDB();
    $res = Sql_exec($cn,$qry);
	while($dt = Sql_fetch_array($res)){
		/*
		$v_arr[$count]['server_id'] = $dt['server_id'];
		$v_arr[$count]['bno'] = $dt['bno'];
		$v_arr[$count]['status'] = $dt['status'];
		$v_arr[$count]['provision_end_date'] = $dt['provision_end_date'];
		$v_arr[$count]['url'] = $dt['url'];
		
		$count++;
		*/
	}
	
	ClosedDBConnection($cn);
	
	echo json_encode($v_arr);
?>