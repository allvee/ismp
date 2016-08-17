<?php
require_once "../.././commonlib.php";

$v_arr = array();
$cn = connectDB();
$qry = "select rolename from tbl_roles where is_active='active'";
if(isset($_POST['action_id'])){
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$qry .= " and id='$action_id'"; 
}

    $res = Sql_exec($cn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr['rolename'] = $dt['rolename'];
	}
	
ClosedDBConnection($cn);
	
echo json_encode($v_arr);
?>