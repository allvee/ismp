<?php
session_start();
require_once "../.././commonlib.php";

	
if(isset($_POST['server_id']) && $_POST['server_id']){
	
	
	$cn = connectDB();
	
	$server_id = mysql_real_escape_string(htmlspecialchars($_POST['server_id']));
	$user_id=$_SESSION['USER_ID'];

	$instances=array();
	$qry="SELECT id FROM tbl_obd_instance_list WHERE user_id='$user_id'";
	$instance_res = Sql_exec($cn,$qry);
	while($dt = Sql_fetch_array($instance_res))
	{
		array_push($instances,$dt["id"]);
	}

	$qry = "SELECT * FROM tbl_obd_server_config WHERE id='$server_id'";
	$res = Sql_exec($cn,$qry);
	$dt=Sql_fetch_array($res);
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_user'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);
	
	
	$remoteConnection = connectDB();
	$val_arr=array();
	
	foreach($instances as $instance)
	{
		 $query="SELECT DISTINCT UserId, ServiceId  FROM outdialque WHERE UserId='$instance'";
		 $res = Sql_exec($remoteConnection,$query);
		 while($dt=Sql_fetch_array($res))
		 {
			 $val_arr[$dt["UserId"]]=$dt["ServiceId"];
		 }
	}
		
		
	if($remoteConnection)ClosedDBConnection($remoteConnection);	 
	
	echo json_encode($val_arr);
}
?>