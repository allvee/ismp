<?php
require_once "../.././commonlib.php";
session_start();
$v_arr = array();
$count = 0;
$user_id = $_SESSION['USER_ID'];

$qry = "SELECT `msg` FROM `tbl_smsgw_template` WHERE `is_active` ='active' ";
if(isset($_POST['action_id'])){
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$qry .= " AND id='$action_id'"; 
}

	$cn = connectDB();
    $res = Sql_exec($cn,$qry);
    /*
	while($dt = Sql_fetch_array($res)){
		
		$v_arr[$count]['msg'] = $dt['msg'];
		
		$count++;
	}
	*/
	while($dt = Sql_fetch_array($res)){
		$msg = $dt['msg'];
		$v_arr[$msg] = $msg;
	}
	ClosedDBConnection($cn);
	
	echo json_encode($v_arr);
?>