<?php
require_once "../.././commonlib.php";

$qry = "select dpc, cic,"; 
$qry .= "channel_no, no_of_channel";
$qry .= " from tbl_sgw_channel_map_data where is_active='active'";
$response = "";
$count = 0;

	$cn = connectDB();
    $res = Sql_exec($cn,$qry);
                            
    while($dt = Sql_fetch_array($res)){
		if($count > 0) $response .= "+";
		$response .= $dt['dpc'] . "#" . $dt['cic'] . "#" . $dt['channel_no'] . "#" . $dt['no_of_channel'];
    	
		$count++;
	}
	
	ClosedDBConnection($cn);
	
	echo $response;
?>