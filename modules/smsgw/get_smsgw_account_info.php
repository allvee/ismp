<?php
require_once "../.././commonlib.php";

$id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
$v_arr = array();
$qry = "select acc_name,balance,masks,is_active from tbl_smsgw_account where id='$id'";

	$cn = connectDB();
    $res = Sql_exec($cn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr['acc_name'] = $dt['acc_name'];
		$v_arr['balance'] = $dt['balance'];
		$v_arr['masks'] = $dt['masks'];
		$v_arr['is_active'] = $dt['is_active'];
	}
	
	ClosedDBConnection($cn);
	
	echo json_encode($v_arr);
?>