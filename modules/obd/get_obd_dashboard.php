<?php
/**
 * Input : server_id, service_id
 * Output : Server List
 * Author : Atanu Saha
 */
require_once "../.././commonlib.php";

if(isset($_POST['server_id']) && $_POST['server_id']){
	$v_arr = array();
	$count = 0;
	$qry = "select id,name from tbl_obd_server_config where is_active='active'";
	
	$cn = connectDB();
	$server_id = mysql_real_escape_string(htmlspecialchars($_POST['server_id']));
	$service_id = mysql_real_escape_string(htmlspecialchars($_POST['service_id']));
	
		
	$res = Sql_exec($cn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr[$count][$dt["id"]] = $dt["name"];
		
		$count++;
	}
		
	ClosedDBConnection($cn);
		
	echo json_encode($v_arr);
}
?>