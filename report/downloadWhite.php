<?php 
session_start();
include("../commonlib.php");

	
	$filename = "White_LIST_" . date('Ymd') . ".csv"; 
	header("Content-Disposition: attachment; filename=\"$filename\""); 
	header("Content-Type: application/vnd.ms-excel"); 
	
	$user_id = $_SESSION['USER_ID'];
//	$server_id = $_GET['action_id'];

	$action_id = $_GET['action_id'];
	$arr = explode("S", $action_id);
	$server_id = $arr[1];
	$arr[0] = str_replace('D', '-', $arr[0]);
	$arr[0] = str_replace('T', ' ', $arr[0]);
	$time_stamp = str_replace('C', ':', $arr[0]);

//	$qry = "SELECT `msisdn` FROM `tbl_obd_white_list` WHERE `user_id`='".$user_id."' AND `server_id` ='".$server_id."'";	
	$qry = "SELECT `msisdn` FROM `tbl_obd_white_list` WHERE `user_id`='".$user_id."' AND `server_id` ='".$server_id."' AND `time_stamp`='".$time_stamp."'";	
	
	$cn = connectDB();
	$count =0 ;

	try {
		$data = Sql_exec($cn,$qry);
		while($dt = Sql_fetch_array($data))
		{
			$arr = array();
			$arr[0] =$dt[0];
			$v_arr[$count] =$arr;
			$count++;
		}
	} catch (Exception $e){
		$is_error = 1;
		array_push($err_field,$qry);
	}
	ClosedDBConnection($cn);
	
	if($v_arr != null && $v_arr !="")
	{
		foreach($v_arr as $row) 
		{ 
			echo implode("\t", $row) . "\r\n";
		}
	}
	exit; 

?>