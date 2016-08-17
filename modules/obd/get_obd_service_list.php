<?php
require_once "../.././commonlib.php";

if(isset($_POST['server_id']) && $_POST['server_id']){
	$v_arr = array();
	$count = 0;
	
	$cn = connectDB();
	$server_id = mysql_real_escape_string(htmlspecialchars($_POST['server_id']));
	$qry = "SELECT * FROM tbl_obd_server_config WHERE id='$server_id'";
	
		
	$res = Sql_exec($cn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr[$count][$dt["id"]] = $dt["name"];
		
		$count++;
	}
		
	ClosedDBConnection($cn);
		
	echo json_encode($v_arr);
}
?>