<?php
require_once(".././commonlib.php");

$version_arr = array();

$cn = connectDB();
	$qry = "Select version_name,curr_version from ugw_version.version where is_active='active' limit 0,1";
	$rs = Sql_fetch_array(Sql_exec($cn,$qry));
	$version_arr['version'] = $rs['version_name'];
	$version_arr['curr_version'] = $rs['curr_version'];
	$json = json_encode($version_arr);
$callback = $_GET['callback'];
echo $callback.'('. $json . ')';
ClosedDBConnection($cn);
?>