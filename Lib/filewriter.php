<?php
/**
 * File Writer Library
 * Version 1.0 (16.07.2014)
 * Author : Atanu Saha
 * Copyright (c) 2014 SSD-Tech Ltd., http://www.ssd-tech.com
 */

/**
 * Common Filewriter Script
 */
function replaceFieldVal($file, $name, $replaceWith, $delimiters="="){
	$lines = file($file);
	
	foreach (array_values($lines) AS $line){
		list($key, $val) =  preg_split("/(".$delimiters.")/",trim($line)); //explode($delimiters, trim($line) );	
		
		if (trim($key) == $name){
			$current = file_get_contents($file);				
			$data = str_replace($key.$delimiters.$val, $key.$delimiters.$replaceWith, $current); 
			//log_generator("Previous # ".$key.$delimiters.$val." # New #".$key.$delimiters.$replaceWith,__FILE__,__FUNCTION__,__LINE__,NULL);				
			file_put_contents($file, $data);
			return true;
		}
		//log_generator("Key # ".$key." # Name #".$name." # Value #".$replaceWith,__FILE__,__FUNCTION__,__LINE__,NULL);
	}
	return false;
}
	
function insertNewLine($file, $data, $afterLine="*nat", $beforeLine="COMMIT"){
	$start_status = 0;
	$lines = file($file);
		
	foreach (array_values($lines) AS $index => $line){
		if(trim($line) == $afterLine && $start_status == 0){
			$start_status = 1;
			$position_start = $index;
		}
			
		if($start_status == 1){
			if(trim($line) == $beforeLine){
				$start_status = 0;
				$position = $index;
			}
		}
	}
		
	array_splice($lines,$position,0,array($data."\n"));
	// reindex array
	$lines = array_values($lines);
		
	file_put_contents($file,$lines);
	return true;
}

function cleanLines($file,$afterLine="*nat",$beforeLine="COMMIT",$passIndex=0){
	$start_status = 0;
	$before_position = 0;
	$lines = file($file);
		
	foreach (array_values($lines) AS $index => $line){
		if(trim($line) == $afterLine){
			$start_status = 1;
			$after_position = intval($index)+$passIndex;
		}
			
		if($start_status == 1){
			if(trim($line) == $beforeLine){
				$start_status = 0;
				$before_position = $index;
			}
		}
	}
		
	foreach (array_values($lines) AS $index => $line){
		if($index > $after_position && $index<$before_position){
			unset($lines[$index]);
		}
	}
		
	// reindex array
	$lines = array_values($lines);
		
	file_put_contents($file,$lines);
	return true;
}

/**
 * SGW Configuration
 */
function file_writer_sgw_configuration($cn){
	global $path_of_sgw_configuration;
	
	$data_string = "";
	$select_qry = "select id, sctp_local_ip, sctp_local_port, sctp_remote_ip, sctp_remote_port,"; 
	$select_qry .= "sctp_mode, opc, dpc, no_of_channel, route_context, m3ua_register, local_sip_ip, local_sip_port,";
	$select_qry .= " media_server_ip, media_server_sip_port, log_level, log_destination"; 
	$select_qry .= " from tbl_sgw_configuration where is_active='active' limit 0,1";
	
	$rs = Sql_exec($cn,$select_qry);
	$dt = Sql_fetch_array($rs);
	
	if($dt["sctp_mode"] == "client"){
		$sctp_mode = "0";
	} else {
		$sctp_mode = "1";
	}
	
	$delimiters = "->";
	try {
		log_generator("SGW Configuration File Writing START",__FILE__,__FUNCTION__,__LINE__,NULL);
		replaceFieldVal($path_of_sgw_configuration, "SCTP_LOCAL_IP", $dt["sctp_local_ip"], $delimiters);
		replaceFieldVal($path_of_sgw_configuration, "SCTP_LOCAL_PORT", $dt["sctp_local_port"], $delimiters);
		replaceFieldVal($path_of_sgw_configuration, "PEER_SN_IP", $dt["sctp_remote_ip"], $delimiters);
		replaceFieldVal($path_of_sgw_configuration, "PEER_SN_PORT", $dt["sctp_remote_port"], $delimiters);
		replaceFieldVal($path_of_sgw_configuration, "SCTP_LISTEN", $sctp_mode, $delimiters);
		replaceFieldVal($path_of_sgw_configuration, "OPC", $dt["opc"], $delimiters);
		replaceFieldVal($path_of_sgw_configuration, "DPC", $dt["dpc"], $delimiters);
		replaceFieldVal($path_of_sgw_configuration, "TOTAL_NO_OF_CIC", $dt["no_of_channel"], $delimiters);
		replaceFieldVal($path_of_sgw_configuration, "RC", $dt["route_context"], $delimiters);
		replaceFieldVal($path_of_sgw_configuration, "M3UA_REGISTER", $dt["m3ua_register"], $delimiters);
		replaceFieldVal($path_of_sgw_configuration, "SIP_LOCAL_IP", $dt["local_sip_ip"], $delimiters);
		replaceFieldVal($path_of_sgw_configuration, "SIP_LOCAL_PORT", $dt["local_sip_port"], $delimiters);
		replaceFieldVal($path_of_sgw_configuration, "MEDIA_SERVER_IP", $dt["media_server_ip"], $delimiters);
		replaceFieldVal($path_of_sgw_configuration, "MEDIA_SERVER_PORT", $dt["media_server_sip_port"], $delimiters);
		replaceFieldVal($path_of_sgw_configuration, "LOG_LEVEL", $dt["log_level"], $delimiters);
		replaceFieldVal($path_of_sgw_configuration, "LOG_DESTINATION", $dt["log_destination"], $delimiters);
		log_generator("SGW Configuration File Writing END",__FILE__,__FUNCTION__,__LINE__,NULL);
	} catch (Exception $e){
		log_generator("SGW Configuration File Writing FAILED ".$e,__FILE__,__FUNCTION__,__LINE__,NULL);
	}
}

/**
 * SGW Channel Map
 */
 function file_writer_sgw_channel_map($cn){
	global $path_of_sgw_channel_map;
	
	$data_string = "";
	$select_qry = "select channel_map_enable,no_of_channel_map,sgw_protocol from tbl_sgw_channel_map where is_active='active'";
	
	$rs = Sql_exec($cn,$select_qry);
	$dt = Sql_fetch_array($rs);
	if($dt['channel_map_enable'] == "yes"){
		$data_string .= "1 ".$dt["sgw_protocol"]."\n";
		$data_string .= $dt['no_of_channel_map'] . "\n";
		
		if(intval($dt['no_of_channel_map']) > 0){
			$select_qry_2 = "select dpc,cic,channel_no,no_of_channel from tbl_sgw_channel_map_data where is_active='active'";
			
			$rs_2 = Sql_exec($cn,$select_qry_2);
			while($dt_2 = Sql_fetch_array($rs_2)){
				$data_string .= $dt_2['dpc'] . " " . $dt_2['cic'] . " " . $dt_2['channel_no'] . " " . $dt_2['no_of_channel'] . "\n";
			}
		}
	} else {
		$data_string .= "0 ".$dt["sgw_protocol"]."\n0";
	}
	
	try {
		log_generator("SGW Channel Map File Writing START",__FILE__,__FUNCTION__,__LINE__,NULL);
		file_put_contents($path_of_sgw_channel_map,$data_string);
		log_generator("SGW Channel Map File Writing END",__FILE__,__FUNCTION__,__LINE__,NULL);
	} catch (Exception $e){
		$is_error = 1;
		log_generator("SGW Channel Map File Writing Failed",__FILE__,__FUNCTION__,__LINE__,NULL);
	}
}

/*function file_writer_sgw_channel_map($cn){
	global $path_of_sgw_channel_map;
	
	$data_string = "";
	$select_qry = "select channel_map_enable,no_of_channel_map from tbl_sgw_channel_map where is_active='active'";
	
	$rs = Sql_exec($cn,$select_qry);
	$dt = Sql_fetch_array($rs);
	if($dt['channel_map_enable'] == "yes"){
		$data_string .= "1\n";
		$data_string .= $dt['no_of_channel_map'] . "\n";
		
		if(intval($dt['no_of_channel_map']) > 0){
			$select_qry_2 = "select dpc,cic,channel_no,no_of_channel from tbl_sgw_channel_map_data where is_active='active'";
			
			$rs_2 = Sql_exec($cn,$select_qry_2);
			while($dt_2 = Sql_fetch_array($rs_2)){
				$data_string .= $dt_2['dpc'] . " " . $dt_2['cic'] . " " . $dt_2['channel_no'] . " " . $dt_2['no_of_channel'] . "\n";
			}
		}
	} else {
		$data_string .= "0\n0";
	}
	
	try {
		log_generator("SGW Channel Map File Writing START",__FILE__,__FUNCTION__,__LINE__,NULL);
		file_put_contents($path_of_sgw_channel_map,$data_string);
		log_generator("SGW Channel Map File Writing END",__FILE__,__FUNCTION__,__LINE__,NULL);
	} catch (Exception $e){
		$is_error = 1;
		log_generator("SGW Channel Map File Writing Failed",__FILE__,__FUNCTION__,__LINE__,NULL);
	}
}*/

/**
 * CH Configuration
 */
function file_writer_ch_configuration($cn){
	global $path_of_ch_configuration;
	
	$data_string = "";
	$select_qry = "select pvalue from tbl_ch_configuration where is_active='active' order by serial_by asc";
	
	$rs = Sql_exec($cn,$select_qry);
	while($dt = Sql_fetch_array($rs)){
		$data_string .= $dt['pvalue']."\n";
	}
	
	try {
		log_generator("CH Configuration File Writing START",__FILE__,__FUNCTION__,__LINE__,NULL);
		file_put_contents($path_of_ch_configuration,$data_string);
		log_generator("CH Configuration File Writing END",__FILE__,__FUNCTION__,__LINE__,NULL);
	} catch (Exception $e){
		$is_error = 1;
		log_generator("SGW Configuration File Writing Failed",__FILE__,__FUNCTION__,__LINE__,NULL);
	}
}

/**
 * CH Channel Map
 */
function file_writer_ch_channel_map($cn){
	global $path_of_ch_channel_map;
	
	$data_string = "";
	$select_qry = "select st_channel,e_channel,sip_server_ip,sip_server_port,ipbcp_enabled,iufp_enabled from tbl_ch_channel_map where is_active='active' limit 0,1";
	
	$rs = Sql_exec($cn,$select_qry);
	while($dt = Sql_fetch_array($rs)){
		if($data_string != "") $data_string .= "\n";
		$st_channel = $dt['st_channel'];
		$e_channel = $dt['e_channel'];
		$sip_server_ip = $dt['sip_server_ip'];
		$sip_server_port = $dt['sip_server_port'];
		$ipbcp_enabled = $dt['ipbcp_enabled'];
		$iufp_enabled = $dt['iufp_enabled'];
		
		$data_string .= $st_channel." ".$e_channel." ".$sip_server_ip." ".$sip_server_port." ".$ipbcp_enabled." ".$iufp_enabled;
	}
	/*$existing_data = file_get_contents($path_of_ch_channel_map);
	$ex_data_arr = explode(" ",$existing_data);
	
	foreach($ex_data_arr as $key => $value){
		if($key == 0) $data_string .= $st_channel;
		elseif($key == 1) $data_string .= $e_channel;
		else if($key == 2) $data_string .=$sip_server_ip;
		else if($key == 3) $data_string .=$sip_server_port;
		else $data_string .= $value;
		
		$data_string .= " ";
	}*/
	
	try {
		log_generator("CH Channel Map File Writing START",__FILE__,__FUNCTION__,__LINE__,NULL);
		file_put_contents($path_of_ch_channel_map,$data_string);
		log_generator("CH Channel Map File Writing END",__FILE__,__FUNCTION__,__LINE__,NULL);
	} catch (Exception $e){
		$is_error = 1;
		log_generator("CH Channel Map File Writing Failed",__FILE__,__FUNCTION__,__LINE__,NULL);
	}
}
/**
 * CGW Configuration
 */
function file_writer_cgw_configuration($cn){
	global $path_of_cgw_configuration;
	
	$select_qry = "select pname,pvalue from tbl_cgw_configuration where is_active='active'";
	$rs = Sql_exec($cn,$select_qry);
	
	$delimiters = "->";
	log_generator("CGW Configuration File Writing START",__FILE__,__FUNCTION__,__LINE__,NULL);
	while($dt = Sql_fetch_array($rs)){
		try {
			replaceFieldVal($path_of_cgw_configuration, trim($dt["pname"]), $dt["pvalue"], $delimiters);
		} catch (Exception $e){
			log_generator("CGW Configuration File Writing FAILED ".$e,__FILE__,__FUNCTION__,__LINE__,NULL);
		}
	}
	log_generator("CGW Configuration File Writing END",__FILE__,__FUNCTION__,__LINE__,NULL);
}

/**
 * SMSGW Configuration
 */
function file_writer_smsgw_configuration($cn){
	global $path_of_smsgw_configuration;
	
	$smsc_ip = "";
	$SMSC_Port = "";
	$user = "";
	$password = "";
	$mode = "";
	
	$TON = "";
	$NPI = "";
	$source_TON = "";
	$source_NPI = "";
	$destination_TON = "";
	$destination_NPI = "";
	
	$Line_6 = "";
	$Line_7_Val1 = "";
	$host = "";
	$http_port = "";
			
	$server_for_cde_php = "";
	$db_server = "";
	$db_username = "";
	$db_password = "";
	$db_name = "";

	$SECOND_RECV = "";
	$LINESKIP = "";
	$WAPPUSHSC = "";
	$Line_17 = "";

	$BIANRYSMS = "";
	$SUBMIT_SM_DELAY = "";
	$retry_count = "";
	$LONGSMS = "";
	$Line_23_Val1 = "";
	$Line_23_Val2 = "";
	
	$LOG_DIRNAME = "";
	$SMSLOG_ENABLED = "";
	$ACTIVITYLOG_ENABLED = "";
	$Line_27 = "";
	$HEART_BEAT_DELAY = "";
		
	$Retry_Delay = "";
	$SNMP_Enable = "";
	$SNMP_Manager_IP = "";
	$SNMP_Port = "";
	$SNMP_LOCAL_IP = "";
	
	$SNMP_LOCAL_PORT = "";
	$SNMP_AGENT_IP = "";
	$log_level = "";
	$log_destination = "";
	$LOG_HOST = "";
	
	$LOG_PORT = "";
	$LOG_COMPONENT = "";
	$LOG_INSTANCE = "";
	$DELIVERED_TIME_DELAY = "";
	$DELIVERY_RECEIVED_ENNABLE = "";
	
	$UPDATE_STATUS = "";
	$DATA_SELECTION_SLEEP_TIME = "";
	$CONTENT_THREAD_COUNT = "";
	$OUTBOX_THREAD_COUNT = "";
	$ENABLE_SUBMISSION_RETRY = "";
	
	$SUBMISSION_RETRY_GAP = "";
	$SUBMISSION_DELAY = "";
	$Retry_Delay_UOM = "";
	$SUBMISSION_DELAY_UOM = "";
	
	$data_string = "";
	$select_qry = "select pname, pvalue from tbl_smsgw_configuration where is_active='active'";
	
	$rs = Sql_exec($cn,$select_qry);
	while($dt = Sql_fetch_array($rs)){
		//$data_string .= $dt['pvalue']."\n";
		$$dt['pname'] = $dt['pvalue'];
	}
	//populating $data_string to write in file;
	
	$data_string .= $smsc_ip . " " . $SMSC_Port . "\n";																				//SMSC_IP, SMSC_PORT
	$data_string .= $smsc_ip . " " . $SMSC_Port . "\n";
	$data_string .= $user . " " . $password ." ". "9" . "\n";																		//username, password, mode
	$data_string .= $user . " " . $password ." ". "0" . "\n";
	$data_string .= $TON . " " . $NPI ." ". $source_TON . " " . $source_NPI ." ". $destination_TON ." ". $destination_NPI . "\n";	//ton, npi, srcton, srcnpi, destton, destnpi
	$data_string .= $Line_6 . "\n";																									//
	$data_string .= $Line_7_Val1 .": ". $host . "\n";																				//host name
	$data_string .= $http_port . "\n";																								//http_port
	
	$data_string .= $server_for_cde_php . "\n";																						//server_for_cde_php
	$data_string .= $db_server . "\n";																								//db_server
	$data_string .= $db_username . "\n";																							//db_username
	$data_string .= $db_password . "\n";																							//db_password
	$data_string .= $db_name . "\n";																								//db_name
	
	$data_string .= $SECOND_RECV . "\n";																							//SECOND_RECV
	$data_string .= $LINESKIP . "\n";																								//LINESKIP
	$data_string .= $WAPPUSHSC . "\n";																								//WAPPUSHSC
	$data_string .= $Line_17 . "\n";																									//Line_17
	$data_string .= $Line_7_Val1 .": ". $host . "\n";																				//host name
	$data_string .= $BIANRYSMS . "\n";																								//BIANRYSMS
	$data_string .= $SUBMIT_SM_DELAY . "\n";																					//SUBMIT_SM_DELAY
	$data_string .= $retry_count . "\n";																							//retry_count
	$data_string .= $LONGSMS . "\n";																								//LONGSMS
	$data_string .= $Line_23_Val1 ." ". $Line_23_Val2 . "\n";																		//
	$data_string .= $LOG_DIRNAME . "\n";																							//LOG_DIRNAME
	$data_string .= $SMSLOG_ENABLED . "\n";																						//SMSLOG_ENABLED
	$data_string .= $ACTIVITYLOG_ENABLED . "\n";																			//ACTIVITYLOG_ENABLED
	$data_string .= $Line_27 . "\n";																								//Line_27
	$data_string .= $HEART_BEAT_DELAY . "\n";																					//HEART_BEAT_DELAY
	$data_string .= $Retry_Delay . "\n";																							//Retry_Delay
	$data_string .= $SNMP_Enable . "\n";																							//SNMP_Enable
	$data_string .= $SNMP_Manager_IP . "\n";																					//SNMP_Manager_IP
	$data_string .= $SNMP_Port . "\n";																								//SNMP_Port
	$data_string .= $SNMP_LOCAL_IP . "\n";																							//SNMP_LOCAL_IP
	$data_string .= $SNMP_LOCAL_PORT . "\n";																					//SNMP_LOCAL_PORT
	$data_string .= $SNMP_AGENT_IP . "\n";																							//SNMP_AGENT_IP
	$data_string .= $log_level . "\n";																								//log_level
	$data_string .= $log_destination . "\n";																					//log_destination
	$data_string .= $LOG_HOST . "\n";																								//LOG_HOST
	$data_string .= $LOG_PORT . "\n";																								//LOG_PORT
	$data_string .= $LOG_COMPONENT . "\n";																							//LOG_COMPONENT
	$data_string .= $LOG_INSTANCE . "\n";	//LOG_INSTANCE
	$data_string .= $DELIVERED_TIME_DELAY . "\n";	//DELIVERED_TIME_DELAY
	$data_string .= $DELIVERY_RECEIVED_ENNABLE . "\n";	//DELIVERY_RECEIVED_ENNABLE
	$data_string .= $UPDATE_STATUS . "\n";	//UPDATE_STATUS
	$data_string .= $DATA_SELECTION_SLEEP_TIME . "\n";	//DATA_SELECTION_SLEEP_TIME
	$data_string .= $CONTENT_THREAD_COUNT . "\n";	//CONTENT_THREAD_COUNT
	$data_string .= $OUTBOX_THREAD_COUNT . "\n";  //OUTBOX_THREAD_COUNT
	$data_string .= $ENABLE_SUBMISSION_RETRY . "\n"; //ENABLE_SUBMISSION_RETRY
	$data_string .= $SUBMISSION_RETRY_GAP . "\n";	//SUBMISSION_RETRY_GAP
	$data_string .= $SUBMISSION_DELAY . "\n";		//SUBMISSION_DELAY
	$data_string .= $Retry_Delay_UOM . "\n";		//Retry_Delay_UOM
	$data_string .= $SUBMISSION_DELAY_UOM . "";		//SUBMISSION_DELAY_UOM

	try {
		log_generator("SMSGW Configuration File Writing START",__FILE__,__FUNCTION__,__LINE__,NULL);
		file_put_contents($path_of_smsgw_configuration, $data_string);
		log_generator("SMSGW Configuration File Writing END",__FILE__,__FUNCTION__,__LINE__,NULL);
	} catch (Exception $e){
		$is_error = 1;
		log_generator("SMSGW Configuration File Writing Failed",__FILE__,__FUNCTION__,__LINE__,NULL);
	}
}
?>