<?php
require_once "../.././commonlib.php";

$qry = "select  channel_map_enable, no_of_channel_map, sgw_protocol"; 
$qry .= " from tbl_sgw_channel_map where is_active='active'";
$response = "";

	$cn = connectDB();
    $res = Sql_exec($cn,$qry);
                            
    while($dt = Sql_fetch_array($res)){
		$response .= $dt['channel_map_enable'].'+'.$dt['no_of_channel_map'].'+'.$dt['sgw_protocol'];
	}
	
	ClosedDBConnection($cn);
	
	if($response == "") $response = "no+0";
	
	echo $response;
?>