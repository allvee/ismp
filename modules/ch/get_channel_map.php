<?php
require_once "../.././commonlib.php";

$v_arr = array();
$cn = connectDB();
$qry = "Select id, st_channel,e_channel,sip_server_ip,sip_server_port, ipbcp_enabled, iufp_enabled from `tbl_ch_channel_map` where is_active='active'"; 
if(isset($_POST['action_id'])){
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$qry .= " and id='$action_id'"; 
}

 $res = Sql_exec($cn,$qry);
	while($dt = Sql_fetch_array($res)){
		
	$v_arr['st_channel'] = $dt['st_channel'];
	$v_arr['e_channel'] = $dt['e_channel'];
	$v_arr['sip_server_ip'] = $dt['sip_server_ip'];
	$v_arr['sip_server_port'] = $dt['sip_server_port'];
	$v_arr['ipbcp_enabled'] = $dt['ipbcp_enabled'];
	$v_arr['iufp_enabled'] = $dt['iufp_enabled'];
	}
	
ClosedDBConnection($cn);
	
echo json_encode($v_arr);
?>