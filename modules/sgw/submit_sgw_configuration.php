<?php
session_start();
require_once "../.././commonlib.php";
require_once "../.././".$FILE_WRITER_LIB;

	$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
	$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
	$sctp_local_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['sctp_local_ip']));
	$sctp_local_port = mysql_real_escape_string(htmlspecialchars($_REQUEST['sctp_local_port']));
	$sctp_remote_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['sctp_remote_ip']));
	$sctp_remote_port = mysql_real_escape_string(htmlspecialchars($_REQUEST['sctp_remote_port']));
	$sctp_mode = mysql_real_escape_string(htmlspecialchars($_REQUEST['sctp_mode']));
	$opc = mysql_real_escape_string(htmlspecialchars($_REQUEST['opc']));
	$dpc = mysql_real_escape_string(htmlspecialchars($_REQUEST['dpc']));
	$no_of_channel = mysql_real_escape_string(htmlspecialchars($_REQUEST['no_of_channel']));
	$route_context = mysql_real_escape_string(htmlspecialchars($_REQUEST['route_context']));
	$m3ua_register = mysql_real_escape_string(htmlspecialchars($_REQUEST['m3ua_register']));
	$local_sip_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['local_sip_ip']));
	$local_sip_port = mysql_real_escape_string(htmlspecialchars($_REQUEST['local_sip_port']));
	$media_server_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['media_server_ip']));
	$media_server_sip_port = mysql_real_escape_string(htmlspecialchars($_REQUEST['media_server_sip_port']));
	$log_level = mysql_real_escape_string(htmlspecialchars($_REQUEST['log_level']));
	$log_destination = mysql_real_escape_string(htmlspecialchars($_REQUEST['log_destination']));
	
	$is_error = 0;
	
	if($action == "update"){
		$qry = "update tbl_sgw_configuration set sctp_local_ip='$sctp_local_ip',sctp_local_port='$sctp_local_port',";
		$qry .= " sctp_remote_ip='$sctp_remote_ip', sctp_remote_port='$sctp_remote_port', sctp_mode='$sctp_mode',";
		$qry .= " opc='$opc', dpc='$dpc', no_of_channel='$no_of_channel', route_context='$route_context',";
		$qry .= " m3ua_register='$m3ua_register', local_sip_ip='$local_sip_ip', local_sip_port='$local_sip_port',";
		$qry .= " media_server_ip='$media_server_ip', media_server_sip_port='$media_server_sip_port', log_level='$log_level',";
		$qry .= " log_destination='$log_destination'";
		$qry .= " where id='$action_id'";
	} elseif($action == "delete"){
		$qry = "update tbl_sgw_configuration set is_active='inactive'";
		$qry .= " where id='$action_id'";
	}

	$cn = connectDB();
    
	try {
		$res = Sql_exec($cn,$qry);
	} catch (Exception $e){
		$is_error = 1;
	}
	
	file_writer_sgw_configuration($cn);
	
	ClosedDBConnection($cn);
	echo $is_error;
?>