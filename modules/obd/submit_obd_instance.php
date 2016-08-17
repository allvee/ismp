<?php
session_start();
require_once "../.././commonlib.php";
//	$action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
	
	$is_error = 0;
	$err_field = array();
	$count = 0;
	$seperator = "";
	$uploaddir = $upload_directory_for_obd_prompt_upload;
	
	$cn = connectDB();
	$existingFile = $_REQUEST['promptReplace'];
	foreach($_FILES as $file){
		if(file_exists($uploaddir .basename($file['name']))) 
			unlink($uploaddir .basename($file['name']));
		
		//if(move_uploaded_file($file['tmp_name'], $uploaddir.basename($existingFile)))
		if(move_uploaded_file($file['tmp_name'], $existingFile))
		//if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
		{
			//$files[] = $uploaddir .$file['name'];
			$files[] = $uploaddir .$file['tmp_name'];
		}
		else {
			$is_error = 2;
		}
	}
	
	if($is_error == 0){
		$user_id = $_SESSION['USER_ID'];
		$server_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['server_id']));
		$display_no = mysql_real_escape_string(htmlspecialchars($_REQUEST['display_no']));
		$original_no = mysql_real_escape_string(htmlspecialchars($_REQUEST['original_no']));
		$schedule_date = mysql_real_escape_string(htmlspecialchars($_REQUEST['schedule_date']));
		$service_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['service_id']));
		$prompt_location = mysql_real_escape_string(htmlspecialchars($_REQUEST['prompt_location']));
		$is_active = mysql_real_escape_string(htmlspecialchars($_REQUEST['is_active']));	
		$white_list = mysql_real_escape_string(htmlspecialchars($_REQUEST['white_list']));	
			
		$qry = "INSERT INTO `tbl_obd_instance_list` (`user_id`, `server_id`, `display_no`, `original_no`, `schedule_date`, `service_id`, `prompt_location`,`id_operator_distribution`, `is_active`)";	
		$qry .= " values ('$user_id','$server_id','$display_no','$original_no', '$schedule_date', '$service_id', '$prompt_location', '$white_list','active')";
		
		
		try {
			$res = Sql_exec($cn,$qry);
		} catch (Exception $e){
			$is_error = 1;
			array_push($err_field,$qry);
		}
	}
	ClosedDBConnection($cn);
	
	echo $is_error;
?>
 