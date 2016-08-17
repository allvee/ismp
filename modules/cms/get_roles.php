<?php
session_start();
require_once "../.././commonlib.php";
$cn = connectDB();
$value_arr=array();
$query="SELECT id,rolename FROM tbl_roles WHERE is_active='active'";
$rs=Sql_exec($cn,$query);	
while($dt = Sql_fetch_array($rs))
{
	 $value_arr[$dt['id']] = $dt['rolename'];
}

echo json_encode($value_arr);
ClosedDBConnection($cn);
?>