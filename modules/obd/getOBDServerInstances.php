<?php
require_once "../.././commonlib.php";

$qry = "select id, name from tbl_obd_server_config where is_active='active' order by id asc"; 

	$cn = connectDB();
    $res = Sql_exec($cn,$qry);
	$v_arr = array();
                            
    while($dt = Sql_fetch_array($res)){
		$name = $dt['name'];
		$id = $dt['id'];
		$v_arr[$id] = $name;
	}
	
	ClosedDBConnection($cn);
	echo json_encode($v_arr);
?>