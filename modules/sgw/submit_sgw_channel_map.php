<?php
session_start();
require_once "../.././commonlib.php";
require_once "../.././".$FILE_WRITER_LIB;


	$cn = connectDB();
	$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
	//$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
	$channel_map_status = mysql_real_escape_string(htmlspecialchars($_REQUEST['channel_map_status']));
	$no_of_channel_map = mysql_real_escape_string(htmlspecialchars($_REQUEST['no_of_channel_map']));
	$sgw_protocol = mysql_real_escape_string(htmlspecialchars($_REQUEST['sgw_protocol']));

	
	
	$is_error = 0;
	
	$update_qry = "update tbl_sgw_channel_map set channel_map_enable='$channel_map_status',no_of_channel_map='$no_of_channel_map',sgw_protocol='$sgw_protocol'";
	$update_qry .= " where is_active='active'";
	$update_qry_2 = "update tbl_sgw_channel_map_data set is_active='inactive'";
	$update_qry_2 .= " where is_active='active'";
	
	
	
	
	
    
	try {
		$res = Sql_exec($cn,$update_qry);
	} catch (Exception $e){
		$is_error = 1;
	}
	
	try {
		$res = Sql_exec($cn,$update_qry_2);
	} catch (Exception $e){
		$is_error = 2;
	}
	
	if(intval($no_of_channel_map) > 0){
		$qry_data = "";
		for($count=1;$count<=intval($no_of_channel_map);$count++){
			$dpc = mysql_real_escape_string(htmlspecialchars($_REQUEST['dpc_'.$count]));
			$cic = mysql_real_escape_string(htmlspecialchars($_REQUEST['cic_'.$count]));
			$channel_no = mysql_real_escape_string(htmlspecialchars($_REQUEST['channel_no_'.$count]));
			$no_of_channel = mysql_real_escape_string(htmlspecialchars($_REQUEST['no_of_channel_'.$count]));
			
			if($count>1) $qry_data  .= ",";
			
			$qry_data  .= "('$dpc','$cic','$channel_no','$no_of_channel')";
		}
		$qry = "insert into tbl_sgw_channel_map_data (dpc,cic,channel_no,no_of_channel)";
		$qry .= " values ".$qry_data;
		
		try {
			$res = Sql_exec($cn,$qry);
		} catch (Exception $e){
			$is_error = 3;
		}
	}
	
	file_writer_sgw_channel_map($cn);
	
	ClosedDBConnection($cn);
	
	echo $is_error;
?>