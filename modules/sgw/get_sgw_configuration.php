<?php
require_once "../.././commonlib.php";

$qry = "select id, sctp_local_ip, sctp_local_port, sctp_remote_ip, sctp_remote_port,"; 
$qry .= "sctp_mode, opc, dpc, no_of_channel, route_context, m3ua_register, local_sip_ip, local_sip_port,";
$qry .= " media_server_ip, media_server_sip_port, log_level, log_destination"; 
$qry .= " from tbl_sgw_configuration where is_active='active'";

	$cn = connectDB();
    $res = Sql_exec($cn,$qry);
                            
    while($dt = Sql_fetch_array($res)){
    	echo $dt['id']."+".$dt['sctp_local_ip']."+".$dt['sctp_local_port']."+".$dt['sctp_remote_ip']."+";
		echo $dt['sctp_remote_port']."+".$dt['sctp_mode']."+".$dt['opc']."+".$dt['dpc']."+";
		echo $dt['no_of_channel']."+".$dt['route_context']."+".$dt['m3ua_register']."+".$dt['local_sip_ip']."+";
		echo $dt['local_sip_port']."+".$dt['media_server_ip']."+".$dt['media_server_sip_port']."+".$dt['log_level']."+";
		echo $dt['log_destination']; 
	}
	
	ClosedDBConnection($cn);
?>