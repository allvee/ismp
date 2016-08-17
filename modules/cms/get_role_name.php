<?php
require_once "../.././commonlib.php";

$v_arr = array();
$cn = connectDB();
$qry = "select id,rolename from tbl_roles where is_active='active'";
$res = Sql_exec($cn,$qry);
while($dt = Sql_fetch_array($res)){
		 $v_arr[$dt['id']] = $dt['rolename'];
}
	
ClosedDBConnection($cn);
	
echo json_encode($v_arr);
?>