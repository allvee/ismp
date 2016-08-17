<?php
session_start();
require_once "../.././commonlib.php";
$user_id = $_SESSION['USER_ID'];

$v_arr = array();
$count = 0;

$qry = 	" SELECT `b`.`id`, `b`.`name` " .
		" FROM " .
			"(SELECT `server_id` FROM `tbl_obd_white_list` WHERE `user_id`='".$user_id."' GROUP BY `server_id` ORDER BY `server_id` ) " .
		" AS `a` " .
	   	" LEFT JOIN `tbl_obd_server_config` AS `b` ON `a`.`server_id`=`b`.`id` ";

	$cn = connectDB();
    $res = Sql_exec($cn,$qry);
	while($dt = Sql_fetch_array($res)){
		$id = $dt['id'];
		$name = $dt['name'];
	
		$v_arr[$id] = $name;
	}
	
	ClosedDBConnection($cn);



	echo json_encode($v_arr);
?>