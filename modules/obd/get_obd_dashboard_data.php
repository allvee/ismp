<?php
require_once "../.././commonlib.php";

	$v_arr = array();
	$qry = "select id,name from tbl_obd_server_config where is_active='active'";
	
	$cn = connectDB();
	$server_id = mysql_real_escape_string(htmlspecialchars($_POST['server_id']));
	$service_id = mysql_real_escape_string(htmlspecialchars($_POST['service_id']));
	
		
	$res = Sql_exec($cn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr[$dt["id"]] = $dt["name"];
	}
		
	ClosedDBConnection($cn);
		
	echo json_encode($v_arr);

?>