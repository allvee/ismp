<?php
set_time_limit( 0 );
session_start();
require_once "../.././commonlib.php";

	if(isset($_FILES["file"]))
	{
		//echo "filefound ".$_FILES["file"]["tmp_name"] ;
		$file = fopen($_FILES["file"]["tmp_name"],"r");
	}
	else
	{
		echo "file not found"; 	
	}
	if(isset($_POST["group_id"]))
	{
		$group_id = $_POST["group_id"];
	}
	else
	{
		$group_id = "0";	
	}
	
		
	$is_error = 0;
	$err_field = array();
	$cn = connectDB();
	
	$user_id = $_SESSION['USER_ID'];
	date_default_timezone_set('Asia/Dhaka');
	$time_stamp = date("Y-m-d H:i:s");
	
	if($file == null)
	{
		echo "file null"; 	
	}
	else
	{
		while(!feof($file))
		{
			$data = array();
			
			$data = fgetcsv($file);
			if($data[0]!=null && $data[0]!="" )
			{
				$qry = "INSERT INTO `tbl_smsgw_group_recipient` (`group_id`, `recipient_no`, `created_by`, `last_updated`) VALUES ('".$group_id."','".$data[0]."','".$user_id."','".$time_stamp."')";
				//echo $qry."<br/>";
				try {
					Sql_exec($cn,$qry);
					log_generator("Success QRY :: ".$qry,__FILE__,__FUNCTION__,__LINE__,NULL);
				} catch (Exception $e){
					$is_error = 1;
					array_push($err_field,$pname);
					log_generator("Failed QRY :: ".$qry,__FILE__,__FUNCTION__,__LINE__,NULL);
				}
			}
		}
		fclose($file);
		ClosedDBConnection($cn);
	}
	
	//header("Location: /ismp/index.php?FORM=forms/obd/frmDndList.php");
	
?>