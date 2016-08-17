<?php
	require_once "../.././commonlib.php";

	$v_arr = array();
	$result_arr = array();

	$serverID = $_REQUEST['serverID'];
	if($serverID == '')
	{
		echo json_encode($result_arr);
	}
	else
	{
		$serverID = mysql_real_escape_string(htmlspecialchars($serverID));
		$qry = "SELECT db_type,db_server,db_user,db_password,db_name FROM `tbl_obd_server_config` WHERE id='".$serverID."'"; 
		
		$cn = connectDB();
			if (!$cn)
			{
				echo json_encode($result_arr);
				exit;
			}
			
			$res = Sql_exec($cn,$qry);
			if(!$res)
			{
				echo json_encode($result_arr);
				exit;
			}
				
			while($dt = Sql_fetch_array($res))
			{
				$v_arr["db_type"] = $dt['db_type'];
				$v_arr["server"] = $dt['db_server'];
				$v_arr["user_id"] = $dt['db_user'];
				$v_arr["password"] = $dt['db_password'];
				$v_arr["database"] = $dt['db_name'];
			}
				
		ClosedDBConnection($cn);

		if($v_arr == NULL || count($v_arr) == 0){
			echo "DB Remotely Access Failed";
			exit;
		}
		
		$dbtype=$v_arr["db_type"];
		$MYSERVER=$v_arr["server"];
		$MYUID=$v_arr["user_id"];
		$MYPASSWORD=$v_arr["password"];
		$MYDB=$v_arr["database"];

		$newcn = connectDB();
			if(!$newcn)
			{
				
				echo '';
				echo json_encode($result_arr);
				exit;
			}
			
			$qry = "SELECT ServiceName FROM ".$v_arr["database"].".servicedef "; 
			$res = Sql_exec($newcn,$qry);
							
			if(!$res)
			{
				echo json_encode($result_arr);
				exit;
			}
			
			while($dt = Sql_fetch_array($res)){
				//$ServiceId = $dt['ServiceId'];
				$ServiceName = $dt['ServiceName'];
				$result_arr[$ServiceName] = $ServiceName;
			}						
		
		ClosedDBConnection($newcn);
		
		echo json_encode($result_arr);	
	
	}	//else of serverid==empty
?>