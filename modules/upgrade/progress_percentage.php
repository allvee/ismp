<?php
require_once(".././commonlib.php");
$is_available = 0;
$cn = connectDB();
	$qry = "Select upgrade_status,completed_step,total_step from ugw_version.version where is_active='active'";
	$rs = Sql_fetch_array(Sql_exec($cn,$qry));
	$upgrade_status = $rs['upgrade_status'];
	$completed_step = intval($rs['completed_step']);
	$total_step = intval($rs['total_step']);

//if($upgrade_status == "processing"){
	$percentage_val = intval(($completed_step/$total_step) * 100);
/*} else {
	$percentage_val = 0;
}*/	


echo $percentage_val;
ClosedDBConnection($cn);
?>