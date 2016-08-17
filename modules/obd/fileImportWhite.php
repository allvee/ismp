<?php
set_time_limit( 0 );
session_start();
require_once "../.././commonlib.php";

$user_id = $_SESSION['USER_ID'];

	if(isset($_FILES["file"]))
	{
		//echo "filefound ".$_FILES["file"]["tmp_name"] ;
		$file = fopen($_FILES["file"]["tmp_name"],"r");
	}
	else
	{
		echo "file not found"; 	
	}
	
	if(isset($_POST["obdServerInstance"]))
	{
		$serverId = $_POST["obdServerInstance"];
	}
	else
	{
		$serverId = "0";	
	}
		
		
	$is_error = 0;
	$err_field = array();
	$cn = connectDB();

	//$user_Id = $_POST["userId"];
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
			//$data[0], $serverId;
			//print_r($data);
			if($data[0]!=null && $data[0]!="" )
			{
				$qry = "INSERT INTO `tbl_obd_white_list` (`server_id`, `msisdn`, `time_stamp`, `user_id`) VALUES ('".$serverId."','".$data[0]."','".$time_stamp."','".$user_id."')";
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
	//header("Location: /ismp/index.php?FORM=forms/obd/frmWhiteList.php");
	
?>