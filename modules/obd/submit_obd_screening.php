<?php
session_start();
set_time_limit(0);
require_once "../.././commonlib.php";

$is_error = 0;
$err_field = array();
$user_id = $_SESSION['USER_ID'];
$qry = "INSERT INTO `tbl_obd_screening` (msisdn,user_id,list_type) values ";
$insert_data = "";

	if(isset($_FILES["white"]) && $_FILES["white"]["tmp_name"])
	{
		$file = fopen($_FILES["white"]["tmp_name"],"r");
		if($file != NULL)
		{
			while(!feof($file))
			{
				$data = array();
				
				$data = fgetcsv($file);
				
				if($data[0]!= NULL && $data[0] != "" )
				{
					if($insert_data != "") $insert_data .= ",";
					$insert_data .= "('".$data[0]."','".$user_id."','white')";
				}
			}
			fclose($file);
			
		}
	}
	
	if(isset($_FILES["dnd"]) && $_FILES["dnd"]["tmp_name"])
	{
		$file = fopen($_FILES["dnd"]["tmp_name"],"r");
		if($file != NULL)
		{
			while(!feof($file))
			{
				$data = array();
				
				$data = fgetcsv($file);
				
				if($data[0]!= NULL && $data[0] != "" )
				{
					if($insert_data != "") $insert_data .= ",";
					$insert_data .= "('".$data[0]."','".$user_id."','dnd')";
				}
			}
			fclose($file);
			
		}
	}
	
	if($insert_data != ""){
		$qry .= $insert_data;
		
		$cn = connectDB();
	
		try {
			Sql_exec($cn,$qry);
			log_generator("Success QRY",__FILE__,__FUNCTION__,__LINE__,NULL);
		} catch (Exception $e){
			$is_error = 1;
			array_push($err_field,$pname);
			log_generator("Failed QRY",__FILE__,__FUNCTION__,__LINE__,NULL);
		}
						
		ClosedDBConnection($cn);
	}
	echo $is_error;
//	header("Location: ../.././index.php?FORM=forms/obd/frmScreening.php");
?>