<script type="application/javascript">
	$(document).ready(function() {
		var radio_arr = [ "signaling_protocol", "log_enabled", "cgw_enabled", "SNMP_ENABLED","SDP_IPBCP_ENABLED","NODELOG_ENABLED" ];
		get_ch_configuration(radio_arr);
		
		$("#submit").click(function() { 
			save_ch_conf();		
        });
		
		$("#HOST").blur(function() {
			reassign_value("#HOST","#HTTP_HOST_IP","."," ");
			var host=get_value("#HOST").trim();
			var host_and_port_arr=host.split(":");
			var host_address=host_and_port_arr[0];// 192.168.122.201
			var machine_id=host_address.split(".")[3];
			//set_value("HTTP_HOST_IP",host_address.replaceAll("."," "),selector_type_id);
			set_value("machine_id",machine_id,selector_type_id);
			//alert(get_value("#HTTP_HOST_IP")+":"+machine_id);

			
        });
		
		$("#cgw_host_ip").blur(function() {
            reassign_value("#cgw_host_ip","#cgw_host","."," ");
        });
		
	});
</script>
	<h1>Call Handler : Configuration Panel </h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">Call Handler</a></li>
		</ul>
	</div>
	<div class="content">
    	<input type="hidden" name="machine_id" value="" id="machine_id" />
		<input type="hidden" name="operator_code" value="" id="operator_code" />
		<input type="hidden" name="timeslot" value="" id="timeslot" />
		<input type="hidden" name="vm_enabled" value="" id="vm_enabled" />
		<input type="hidden" name="patch_enabled" value="" id="patch_enabled" />
		<input type="hidden" name="FILETRACK_ENABLED" value="" id="FILETRACK_ENABLED" />
		<input type="hidden" name="ENABLE_REL_CALL" value="" id="ENABLE_REL_CALL" />
		<input type="hidden" name="COT_ENABLED" value="" id="COT_ENABLED" />
		<input type="hidden" name="ADDR_COMP_PATCH" value="" id="ADDR_COMP_PATCH" />
		<input type="hidden" name="PATCH_SELF" value="" id="PATCH_SELF" />
		<input type="hidden" name="CRBT_SERVICE_NO" value="" id="CRBT_SERVICE_NO" />
		<input type="hidden" name="VM_SERVICE_NO" value="" id="VM_SERVICE_NO" />
		<input type="hidden" name="skip_enable" value="" id="skip_enable" />
		<input type="hidden" name="skip_key" value="" id="skip_key" />
		<input type="hidden" name="back_key" value="" id="back_key" />
		<input type="hidden" name="NO_VOICE_TIME" value="" id="NO_VOICE_TIME" />
		<input type="hidden" name="PLACECALL_EXTEN_ENABLED" value="" id="PLACECALL_EXTEN_ENABLED" />
		<input type="hidden" name="HTTP_HOST_IP" value="" id="HTTP_HOST_IP" />
		<input type="hidden" name="HEADERNOTAVAILABLE" value="" id="HEADERNOTAVAILABLE" />
		<input type="hidden" name="SECOND_RECV" value="" id="SECOND_RECV" />
		<input type="hidden" name="DebugGetContent" value="" id="DebugGetContent" />
		<input type="hidden" name="LinesToSkip" value="" id="LinesToSkip" />
		
        <input type="hidden" name="cgw_host" value="" id="cgw_host" />
		<input type="hidden" name="cgw_port" value="" id="cgw_port" />
		<input type="hidden" name="channel_utilize" value="" id="channel_utilize" />
		<input type="hidden" name="rate_code_enabled" value="" id="rate_code_enabled" />
		<input type="hidden" name="parallel_cg_status" value="" id="parallel_cg_status" />
		<input type="hidden" name="max_session_enabled" value="" id="max_session_enabled" />
		<input type="hidden" name="MEDIA_SERVER" value="" id="MEDIA_SERVER" />
		
		<input type="hidden" name="bChRx_thread_stack" value="" id="bChRx_thread_stack" />
		<input type="hidden" name="bChHandler_thread_stack" value="" id="bChHandler_thread_stack" />
		<!--<input type="hidden" name="SDP_IPBCP_ENABLED" value="1" id="SDP_IPBCP_ENABLED" />-->
		<input type="hidden" name="DEFAULT_PAYLOAD_TYPE_VOICE" value="" id="DEFAULT_PAYLOAD_TYPE_VOICE" />
		<input type="hidden" name="DEFAULT_PAYLOAD_TYPE_DTMF" value="" id="DEFAULT_PAYLOAD_TYPE_DTMF" />
		<input type="hidden" name="iufp_enabled" value="" id="iufp_enabled" />
		<input type="hidden" name="SNMP_LOCAL_PORT" value="" id="SNMP_LOCAL_PORT" />
        <input type="hidden" name="SNMP_AGENT_IP" value="" id="SNMP_AGENT_IP" />
        <input type="hidden" name="webserver_socket_time" value="" id="webserver_socket_time" />
        <input type="hidden" name="RTP_MAX_GAP" value="" id="RTP_MAX_GAP" />
        <input type="hidden" name="RELEASE_ON_RTP_MAX_GAP" value="" id="RELEASE_ON_RTP_MAX_GAP" />
        <input type="hidden" name="RTP_GAP_FILLUP_ENABLE" value="" id="RTP_GAP_FILLUP_ENABLE" />
        
		<div class="halfpan fl">
			<label>Protocol </label>
			<div class="inputreplace">
				 SIP<input name="signaling_protocol" type="radio" value="SIP" /> SS7 <input name="signaling_protocol" type="radio" value="SS7" />
			</div><br clear="all" />
			<label>End Channel </label>
			<input name="end_channel" type="text" value="" id="end_channel" />
			<label>End OBD Channel </label>
			<input name="e_obd_channel" type="text" value="" id="e_obd_channel" />
			<label>Enable Log </label>
			<div class="inputreplace">
				 Yes<input name="log_enabled" type="radio" value="1" /> No <input name="log_enabled" type="radio" value="0" />
			</div><br clear="all" />
			<label>Max Record Time </label>
			<input name="max_record_time" type="text" value="" id="max_record_time" />
			<label>Log Directory </label>
			<input name="LOG_DIRNAME" type="text" value="" id="LOG_DIRNAME" />
			<label>HTTP Host </label>
			<input name="HOST" type="text" value="" id="HOST" />
			<label> CGW Enable</label>
			<div class="inputreplace">
				 Yes<input name="cgw_enabled" type="radio" value="1" /> No <input name="cgw_enabled" type="radio" value="0" />
			</div><br clear="all" />
			<label>Media Interface IP</label>
			<input name="media_server_ip" type="text" value="" id="media_server_ip" />
			<label>Local SIP Port </label>
			<input name="local_sip_port" type="text" value="" id="local_sip_port" />
			<label> Log Destination</label>
			<input name="log_dest" type="text" value="" id="log_dest" />
			<label> IPBCP Enable</label>
            <div class="inputreplace">
				 Yes<input name="SDP_IPBCP_ENABLED" type="radio" value="1" /> No <input name="SDP_IPBCP_ENABLED" type="radio" value="0" />
			</div><br clear="all" />
			<label>SNMP Enable</label>
			<div class="inputreplace">
				 Yes<input name="SNMP_ENABLED" type="radio" value="1" /> No <input name="SNMP_ENABLED" type="radio" value="0" />
			</div><br clear="all" />
			<label> SNMP Port</label>
			<input name="snmp_port" type="text" value="" id="snmp_port" />
            <label>LOG NO 1</label>
            <input name="LOGNO1" type="text" value="" id="LOGNO1"/>
            <label>LOG NO 2</label>
            <input name="LOGNO2" type="text" value="" id="LOGNO2"/>
             <label>LOG NO 3</label>
            <input name="LOGNO3" type="text" value="" id="LOGNO3"/>
			<label>Nodelog Enable </label>
            <div class="inputreplace">
				 Yes<input name="NODELOG_ENABLED" type="radio" value="1" /> No <input name="NODELOG_ENABLED" type="radio" value="0" />
			</div><br />
		</div>
		<div class="halfpan fr">
			<label>Start Channel </label>
			<input name="start_channel" type="text" value="" id="start_channel" />
			<label>Start OBD Channel </label>
			<input name="st_obd_channel" type="text" value="" id="st_obd_channel" />
			<label>No of Signaling Channel </label>
			<input name="no_signal_channel" type="text" value="" id="no_signal_channel" />
			<label>Recording Bit Rate </label>
			<input name="RECORD_BIT_RATE" type="text" value="" id="RECORD_BIT_RATE" />
			<label>CDR Directory </label>
			<input name="CDRPATH" type="text" value="" id="CDRPATH" />
			<label>Nodelogs Directory </label>
			<input name="NODELOGS_DIRNAME" type="text" value="" id="NODELOGS_DIRNAME" />
			<label>HTTP Port </label>
			<input name="HTTP_PORT" type="text" value="" id="HTTP_PORT" />
			<label>CGW Host </label>
			<input name="cgw_host_ip" type="text" value="" id="cgw_host_ip" />
			<label> Local SIP Interface IP</label>
			<input name="sip_intr_ip" type="text" value="" id="sip_intr_ip" />
			<label>Remote SIP Server</label>
			<input name="remote_sip_server_ip" type="text" value="" id="remote_sip_server_ip" />
            <label>Remote SIP Server Port</label>
			<input name="remote_sip_server_port" type="text" value="" id="remote_sip_server_port" />
			<label> Log Level</label>
			<input name="log_level" type="text" value="" id="log_level" />
			<label>Sleep Time </label>
			<input name="sleep_time" type="text" value="" id="sleep_time" />
			<label>Codec</label>
            <select name="codec" id="codec">
            	<option value="6">a-law</option>
                <option value="7">u-law</option>
            </select>
			<label>SNMP Manager </label>
			<input name="SNMP_MANAGER_HOST_IP" type="text" value="" id="SNMP_MANAGER_HOST_IP" />
			<label>SNMP Local IP</label>
            <input name="SNMP_LOCAL_IP" type="text" value="" id="SNMP_LOCAL_IP" />
		</div>
		<div class="btnarea">
			<input name="submit" type="button" id="submit" value="Submit" />
		</div>
	</div>