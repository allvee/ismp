<?php
require_once "../.././commonlib.php";

$v_arr = array();
$cn = connectDB();
$qry = "select id,ServiceName,RegURL,DeregURL,BlockURL,UnblockURL from `tbl_cs_service_config` where "; 


if(isset($_POST['action_id'])){
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$qry .= " id='$action_id'"; 
}

 $res = Sql_exec($cn,$qry);
	while($dt = Sql_fetch_array($res)){
		
		// left array index for html ids and right array index for DB column	
		
		$v_arr['ServiceName'] = $dt['ServiceName']; 
		$v_arr['RegURL'] = $dt['RegURL'];
		$v_arr['DeregURL'] = $dt['DeregURL'];
		$v_arr['BlockURL'] = $dt['BlockURL'];
		$v_arr['UnblockURL'] = $dt['UnblockURL'];
	
	}
	
ClosedDBConnection($cn);

echo json_encode($v_arr);
?>