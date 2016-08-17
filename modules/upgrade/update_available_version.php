<?php
require_once(".././commonlib.php");

$available_version_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['available_version_name']));
$available_version = mysql_real_escape_string(htmlspecialchars($_REQUEST['available_version']));

$cn = connectDB();
	$qry = "update ugw_version.version set available_version_name='$available_version_name',available_version='$available_version'  where is_active='active'";
	$rs = Sql_exec($cn,$qry);
ClosedDBConnection($cn);

echo '0';
?>