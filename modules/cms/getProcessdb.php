<?php
session_start();
require_once "../.././commonlib.php";

	$qry="select id,db_name from tbl_process_db_access where pname='CMSKEYWORD'";
	
	$cn = connectDB();
    $res = Sql_exec($cn,$qry);
    while($dt = Sql_fetch_array($res)){
		$id = $dt['id'];
		$v_arr[$id] = $dt['db_name'];
	}
	ClosedDBConnection($cn);
	
	echo json_encode($v_arr);

?>