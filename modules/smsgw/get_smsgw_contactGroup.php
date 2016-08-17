<?php
require_once "../.././commonlib.php";
session_start();
$v_arr = array();
$count = 0;
$user_id = $_SESSION['USER_ID'];

$cn = connectDB();
$qry = "select `group_name` from `tbl_smsgw_contact_group` where `created_by`='".$user_id."' AND is_active='active'";
if(isset($_POST['action_id'])){
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$qry .= " and id='$action_id'"; 
}

	
    $res = Sql_exec($cn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr[$count]['group_name'] = $dt['group_name'];
		
		$count++;
	}
	
	ClosedDBConnection($cn);
	
	echo json_encode($v_arr);
?>