<?php
session_start();
require_once "../.././commonlib.php";

$role_id = $_SESSION['ROLE_ID'];
$user_id = $_SESSION['USER_ID'];

$qry = "SELECT `id`,`group_name` FROM `tbl_smsgw_contact_group` where is_active='active'";
if(intval($role_id) > 1) $qry .= " and created_by='".$user_id."'";
$qry .= " ORDER BY `id` ASC"; 

	$cn = connectDB();
    $res = Sql_exec($cn,$qry);
	$v_arr = array();
                            
    while($dt = Sql_fetch_array($res)){
		$group_name = $dt['group_name'];
		$id = $dt['id'];
		$v_arr[$id] = $group_name;
	}
	
	ClosedDBConnection($cn);
	echo json_encode($v_arr);
?>