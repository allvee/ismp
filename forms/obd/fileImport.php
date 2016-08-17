<?php
require_once "../.././commonlib.php";
	if(isset($_POST["fileName"]))
	{
		$file = fopen($_POST["fileName"],"r");
	}
	else
		$file = fopen("C:/Users/Tonima/Desktop/file.csv","r");
	if(isset($_POST["serverId"]))
	{
		$serverId = $_POST["serverId"];
	}
	else
	{
		$serverId = "test";	
	}
		
		
		$is_error = 0;
		$err_field = array();
		$cn = connectDB();
	while(!feof($file))
	{
		$data = array();
		
		$data = fgetcsv($file);
		//$data[0], $serverId;
		//print_r($data);
		if($data[0]!=null && $data[0]!="" )
		{
			$qry = "insert into tbl_obd_dnd_list SET server_id = '".$serverId."',msisdn ='".$data[0]."'";
			//echo $qry."<br/>";
			try {
				Sql_exec($cn,$qry);
				//log_generator("Success QRY :: ".$qry,__FILE__,__FUNCTION__,__LINE__,NULL);
			} catch (Exception $e){
				$is_error = 1;
				array_push($err_field,$pname);
				//log_generator("Failed QRY :: ".$qry,__FILE__,__FUNCTION__,__LINE__,NULL);
			}
		}
	}
	fclose($file);
	ClosedDBConnection($cn);
	
	
?>