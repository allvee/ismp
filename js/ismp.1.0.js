/**
 * ISMP Javascript Library
 * Version 1.0 (08.07.2014)
 * Author : Atanu Saha
 * Copyright (c) 2014 SSD-Tech Ltd., http://www.ssd-tech.com
 */

/**************************
 ****** Main Methods*******
 **************************
 */
 
/**
 * Maintainance
 */
function get_maintainance(status,fancybox){
	set_value("status",status,selector_type_id);
	var res = restore_fields("modules/get_maintainance",["gateway","status"]);
	if(fancybox == "on") 
	{
		$("#inline1").html(res);
	}
	else { 
		alert(err_msg2);
		//$(".fancybox-close").click();
	}
}

/**
 *******************************
 ******** SGW ******************
 *******************************
 */
 
/**
 * SGW Configuration
 */
function get_sgw_configuration(separator){
	var return_val_arr = restore_fields("modules/sgw/get_sgw_configuration",null).split(separator);
	set_value("id",return_val_arr[0],selector_type_id);
	set_value("sctp_local_ip",return_val_arr[1],selector_type_id);
	set_value("sctp_local_port",return_val_arr[2],selector_type_id);
	set_value("sctp_remote_ip",return_val_arr[3],selector_type_id);
	set_value("sctp_remote_port",return_val_arr[4],selector_type_id);
	set_value("sctp_mode",return_val_arr[5],selector_type_radio);
	set_value("opc",return_val_arr[6],selector_type_id);
	set_value("dpc",return_val_arr[7],selector_type_id);
	set_value("no_of_channel",return_val_arr[8],selector_type_id);
	set_value("route_context",return_val_arr[9],selector_type_id);
	set_value("m3ua_register",return_val_arr[10],selector_type_id);
	set_value("local_sip_ip",return_val_arr[11],selector_type_id);
	set_value("local_sip_port",return_val_arr[12],selector_type_id);
	set_value("media_server_ip",return_val_arr[13],selector_type_id);
	set_value("media_server_sip_port",return_val_arr[14],selector_type_id);
	set_value("log_level",return_val_arr[15],selector_type_id);
	set_value("log_destination",return_val_arr[16],selector_type_id);
}

function save_sgw_conf(){
	var action_id = get_value("#id");
	var value_arr = {};
	value_arr["sctp_local_ip"] = "#sctp_local_ip";
	value_arr["sctp_local_port"] = "#sctp_local_port";
	value_arr["sctp_remote_ip"] = "#sctp_remote_ip";
	value_arr["sctp_remote_port"] = "#sctp_remote_port";
	value_arr["sctp_mode"] = "input[name='sctp_mode']:checked";
	value_arr["opc"] = "#opc";
	value_arr["dpc"] = "#dpc";
	value_arr["no_of_channel"] = "#no_of_channel";
	value_arr["route_context"] = "#route_context";
	value_arr["m3ua_register"] = "#m3ua_register";
	value_arr["local_sip_ip"] = "#local_sip_ip";
	value_arr["local_sip_port"] = "#local_sip_port";
	value_arr["media_server_ip"] = "#media_server_ip";
	value_arr["media_server_sip_port"] = "#media_server_sip_port";
	value_arr["log_level"] = "#log_level";
	value_arr["log_destination"] = "#log_destination";
	var required_arr = ["sctp_local_ip"];
	
	save_files("update",action_id,"modules/sgw/submit_sgw_configuration",value_arr,required_arr,null,null,null,null);
}

/**
 * SGW Channel Map
 */
function StepIncrease(){
	var expand_txt = "";
	var channel_map_count = parseInt(get_value("#no_of_channel_map"));
	if(channel_map_count == ""){ 
		channel_map_count = 0;
	}
		
	for(var i=1; i<=channel_map_count; i++){
		expand_txt += '<label>DPC ('+i+')</label>';
		expand_txt += '<input type="text" name="dpc" value="'+get_value("#dpc_"+i)+'" id="dpc_'+i+'" />';
		expand_txt += '<label>CIC ('+i+')</label>';
		expand_txt += '<input type="text" name="cic" value="'+get_value("#cic_"+i)+'" id="cic_'+i+'" />';
		expand_txt += '<label>Channel No ('+i+')</label>';
		expand_txt += '<input type="text" name="channel_no" value="'+get_value("#channel_no_"+i)+'" id="channel_no_'+i+'" />';
		expand_txt += '<label>No of Channels ('+i+')</label>';
		expand_txt += '<input type="text" name="no_of_channel" value="'+get_value("#no_of_channel_"+i)+'" id="no_of_channel_'+i+'" />';
	}
	$("#channel_map_package").html(expand_txt);
}
	
function get_sgw_channel_map(separator){
	var return_val_arr = restore_fields("modules/sgw/get_sgw_channel_map",null).split(separator);
	var channel_map_status = return_val_arr[0];
       var sgw_protocol = return_val_arr[2];
	set_value("channel_map_status",channel_map_status,selector_type_id);
	set_value("sgw_protocol",sgw_protocol,selector_type_id);
	if(channel_map_status == "yes"){
		set_value("no_of_channel_map",return_val_arr[1],selector_type_id);
		if(parseInt(return_val_arr[1]) > 0){
			StepIncrease();
			var data_arr = restore_fields("modules/sgw/get_sgw_channel_map_data",null).split(separator);
			var c_k = 0;
			$.each(data_arr, function(k,v){
				c_k = k+1;
				set_value("dpc_"+c_k,v.split("#")[0],selector_type_id);
				set_value("cic_"+c_k,v.split("#")[1],selector_type_id);
				set_value("channel_no_"+c_k,v.split("#")[2],selector_type_id);
				set_value("no_of_channel_"+c_k,v.split("#")[3],selector_type_id);
			});
		}
	}
	view_channel_map_status();
}
	
function view_channel_map_status(){
	var channel_map_status = get_value("#channel_map_status :selected");
	if(channel_map_status == "yes"){
		show_hide("#channel_map_no,#channel_map_package",null);
	} else {
		show_hide(null,"#channel_map_no,#channel_map_package");
	}
}
	
function save_sgw_channel_map(){
	var value_arr = {};
	var channel_map_status = get_value("#channel_map_status :selected");
	
	value_arr["channel_map_status"] = "#channel_map_status";
	value_arr["sgw_protocol"] = "#sgw_protocol";
	if(channel_map_status == "yes"){
		value_arr["no_of_channel_map"] = "#no_of_channel_map";
		var no_of_channel_map = get_value("#no_of_channel_map");
		
		for(var count=1;count<=no_of_channel_map; count++){
			value_arr["dpc_"+count] = "#dpc_"+count;
			value_arr["cic_"+count] = "#cic_"+count;
			value_arr["channel_no_"+count] = "#channel_no_"+count;
			value_arr["no_of_channel_"+count] = "#no_of_channel_"+count;
		}
	} else {
		set_value("no_of_channel_map","0",selector_type_id);
	}
	
	save_files("insert",null,"modules/sgw/submit_sgw_channel_map",value_arr,null,null,null,null,null);
}


/**
 *******************************
 ******** Call Handler *********
 *******************************
 */

/**
 * Call Handler Configuration
 */
function get_ch_configuration(radio_arr){
	var return_val_arr = restore_fields("modules/ch/get_ch_configuration",null);
	var obj = jQuery.parseJSON( return_val_arr );
	$.each(obj,function(key, value){
		if($.inArray( key, radio_arr) >= 0){
			//console.log("Key "+key+" in array");
			set_value(key,value,selector_type_radio);
		} else {
			set_value(key,value,selector_type_id);
		}
	});
	reassign_value("#cgw_host","#cgw_host_ip"," ",".");
}

function save_ch_conf(){
	var value_arr = {};
	value_arr["signaling_protocol"] = "input[name='signaling_protocol']:checked";
	value_arr["machine_id"] = "#machine_id";
	value_arr["operator_code"] = "#operator_code";
	value_arr["start_channel"] = "#start_channel";
	value_arr["end_channel"] = "#end_channel";
	value_arr["st_obd_channel"] = "#st_obd_channel";
	value_arr["e_obd_channel"] = "#e_obd_channel";
	value_arr["no_signal_channel"] = "#no_signal_channel";
	value_arr["timeslot"] = "#timeslot";
	value_arr["vm_enabled"] = "#vm_enabled";
	value_arr["log_enabled"] = "input[name='log_enabled']:checked";
	value_arr["patch_enabled"] = "#patch_enabled";
	value_arr["FILETRACK_ENABLED"] = "#FILETRACK_ENABLED";
	value_arr["ENABLE_REL_CALL"] = "#ENABLE_REL_CALL";
	value_arr["COT_ENABLED"] = "#COT_ENABLED";
	value_arr["ADDR_COMP_PATCH"] = "#ADDR_COMP_PATCH";
	value_arr["PATCH_SELF"] = "#PATCH_SELF";
	value_arr["CRBT_SERVICE_NO"] = "#CRBT_SERVICE_NO";
	value_arr["VM_SERVICE_NO"] = "#VM_SERVICE_NO";
	value_arr["RECORD_BIT_RATE"] = "#RECORD_BIT_RATE";
	value_arr["skip_enable"] = "#skip_enable";
	
	value_arr["skip_key"] = "#skip_key";
	value_arr["back_key"] = "#back_key";
	value_arr["NO_VOICE_TIME"] = "#NO_VOICE_TIME";
	value_arr["max_record_time"] = "#max_record_time";
	value_arr["PLACECALL_EXTEN_ENABLED"] = "#PLACECALL_EXTEN_ENABLED";
	value_arr["HTTP_HOST_IP"] = "#HTTP_HOST_IP";
	value_arr["HTTP_PORT"] = "#HTTP_PORT";
	value_arr["HOST"] = "#HOST";
	value_arr["HEADERNOTAVAILABLE"] = "#HEADERNOTAVAILABLE";
	value_arr["SECOND_RECV"] = "#SECOND_RECV";
	value_arr["DebugGetContent"] = "#DebugGetContent";
	value_arr["CDRPATH"] = "#CDRPATH";
	value_arr["NODELOGS_DIRNAME"] = "#NODELOGS_DIRNAME";
	value_arr["LOG_DIRNAME"] = "#LOG_DIRNAME";
	
	value_arr["LinesToSkip"] = "#LinesToSkip";
	value_arr["cgw_host"] = "#cgw_host";
	value_arr["cgw_port"] = "#cgw_port";
	value_arr["channel_utilize"] = "#channel_utilize";
	value_arr["cgw_port"] = "#cgw_port";
	value_arr["rate_code_enabled"] = "#rate_code_enabled";
	value_arr["cgw_enabled"] = "input[name='cgw_enabled']:checked";
	value_arr["parallel_cg_status"] = "#parallel_cg_status";
	value_arr["max_session_enabled"] = "#max_session_enabled";
	value_arr["MEDIA_SERVER"] = "#MEDIA_SERVER";
	value_arr["sip_intr_ip"] = "#sip_intr_ip";
	value_arr["media_server_ip"] = "#media_server_ip";
	value_arr["codec"] = "#codec";
	value_arr["remote_sip_server_ip"] = "#remote_sip_server_ip";
	value_arr["remote_sip_server_port"] = "#remote_sip_server_port";
	value_arr["log_level"] = "#log_level";
	value_arr["log_dest"] = "#log_dest";
	value_arr["sleep_time"] = "#sleep_time";
	value_arr["local_sip_port"] = "#local_sip_port";
	value_arr["bChRx_thread_stack"] = "#bChRx_thread_stack";
	value_arr["SDP_IPBCP_ENABLED"] = "input[name='SDP_IPBCP_ENABLED']:checked";
	
	value_arr["DEFAULT_PAYLOAD_TYPE_VOICE"] = "#DEFAULT_PAYLOAD_TYPE_VOICE";
	value_arr["DEFAULT_PAYLOAD_TYPE_DTMF"] = "#DEFAULT_PAYLOAD_TYPE_DTMF";
	value_arr["iufp_enabled"] = "#iufp_enabled";
	value_arr["SNMP_ENABLED"] = "input[name='SNMP_ENABLED']:checked";
	value_arr["SNMP_MANAGER_HOST_IP"] = "#SNMP_MANAGER_HOST_IP";
	value_arr["snmp_port"] = "#snmp_port";
	value_arr["SNMP_LOCAL_IP"] = "#SNMP_LOCAL_IP";
	value_arr["SNMP_LOCAL_PORT"] = "#SNMP_LOCAL_PORT";
	value_arr["SNMP_AGENT_IP"] = "#SNMP_AGENT_IP";
	value_arr["webserver_socket_time"] = "#webserver_socket_time";
	value_arr["NODELOG_ENABLED"] = "input[name='NODELOG_ENABLED']:checked";
	value_arr["RTP_MAX_GAP"] = "#RTP_MAX_GAP";
	value_arr["RELEASE_ON_RTP_MAX_GAP"] = "#RELEASE_ON_RTP_MAX_GAP";
	value_arr["RTP_GAP_FILLUP_ENABLE"] = "#RTP_GAP_FILLUP_ENABLE";
	value_arr["LOGNO1"]="#LOGNO1";
	value_arr["LOGNO2"]="#LOGNO2";
	value_arr["LOGNO3"]="#LOGNO3";
	//var required_arr = ["sctp_local_ip"];
	
	save_files("update",null,"modules/ch/submit_ch_configuration",value_arr,null,null,null,null,null);
}

/**
 * CH Channel Map
 */
/*function get_ch_channel_map(separator){
	var return_val_arr = restore_fields("modules/ch/get_channel_map",null).split(separator);
	$("#st_channel").val(return_val_arr[0]);
	$("#e_channel").val(return_val_arr[1]);
	$("#sip_server_ip").val(return_val_arr[2]);
	$("#sip_server_port").val(return_val_arr[3]);
}*/

function save_ch_channel_map() {
    var action = get_value("#action");
    var action_id = null;

    if (action == "update") {
        action_id = get_value("#action_id");
    }

    var value_arr = {};
    value_arr["st_channel"] = "#st_channel";
    value_arr["e_channel"] = "#e_channel";
    value_arr["sip_server_ip"] = "#sip_server_ip";
    value_arr["sip_server_port"] = "#sip_server_port";
    value_arr["ipbcp_enabled"] = "#ipbcp_enabled";
    value_arr["iufp_enabled"] = "#iufp_enabled";

    save_files(action, action_id, "modules/ch/submit_channel_map", value_arr, null, null, null, null, null);
    set_value("action", "insert", selector_type_id);
    pagination("ch_channelmap", ["st_channel", "e_channel", "sip_server_ip", "sip_server_port", "ipbcp_enabled", "iufp_enabled"], "report/view_page", null, null);
}

/**
 * CH Call Routing
 */
function get_ch_call_routing(radio_arr){
	var return_val_arr = restore_fields("modules/ch/get_call_routing",["action_id"]);
	var obj = jQuery.parseJSON( return_val_arr );
	$.each(obj,function(k, e_value){
		$.each(e_value,function(key, value){
			if($.inArray( key, radio_arr) >= 0){
				set_value(key,value,selector_type_radio);
			} else {
				set_value(key,value,selector_type_id);
			}
		});
	});
}

function save_ch_call_routing(action,action_id){
	var action = get_value("#action");
	var action_id = null;
	if(action == "update"){
		action_id = get_value("#action_id");
	}
	
	
	var value_arr = {};
	value_arr["ano"] = "#ano";
	value_arr["bno"] = "#bno";
	value_arr["Status"] = "input[name='status']:checked";
	value_arr["ProvisionEndDate"] = "#provision_end_date";
	value_arr["url"] = "#url";
	
	save_files(action,action_id,"modules/ch/submit_call_routing",value_arr,null,null,null,null,null);
	set_value("action","insert",selector_type_id);
	pagination("ch_call_routing",["ano","bno","status","provision_end_date","url"],"report/view_page",null,null);
}

/**
 *******************************
 ******** OBD ******************
 *******************************
 */

function get_obd_server_list(id){
	var return_val_arr = load_list("modules/obd/getOBDServerInstances",null);
	console.log(return_val_arr);
	$("#"+id).html(return_val_arr);
}

function createDropDownForOBDServerInstance(){
	var return_val_arr = restore_fields("modules/obd/getOBDServerInstances",null);
	var obj = jQuery.parseJSON( return_val_arr );	
    var str_data = "";
	$.each(obj,function(key, value){
		str_data  += "<option value='"+value+"'>"+key+"</option>";
	});
	
	return str_data;	
	//$("#obdServerInstance").html( str_data );
}

/**
 * Dashboard
 */
 function get_obd_server_list(id){
	$("#"+id).html(createDropDownForOBDServerInstance());
 }


/**
 * DND List Configuration
 */

function get_obd_dnd(radio_arr){
	var return_val_arr = restore_fields("modules/obd/get_call_routing",["action_id"]);
	var obj = jQuery.parseJSON( return_val_arr );
	$.each(obj,function(k, e_value){
		$.each(e_value,function(key, value){
			if($.inArray( key, radio_arr) >= 0){
				set_value(key,value,selector_type_radio);
			} else {
				set_value(key,value,selector_type_id);
			}
		});
	});
}

/**
 *******************************
 ******** CGW ******************
 *******************************
 */
/**
* CGW Call Type
*/
function save_cgw_callType(){
	var action = get_value("#action");
	var action_id = null;
	/*
	if(action == "update"){
		action_id = get_value("#action_id");
	}
	*/
	
	var callTypeIdVal = get_value("#call_type_id");
	if(action == "update"){
		//action_id = get_value("#action_id");
		action_id = get_value("#callTypeIdHidden");
		if(action_id != callTypeIdVal && newCallTypeExists(callTypeIdVal))
		{
			$("#call_type_id").val(action_id);
			alert(err_msg9);
			return;
		}
	}
	else
	{
		if(newCallTypeExists(callTypeIdVal))
		{
			alert(err_msg9);
			return;
		}
	}
	var value_arr = {};
	value_arr["CallTypeID"] = "#call_type_id";
	value_arr["Ano"] = "#ano";
	value_arr["Bno"] = "#bno";
	value_arr["UserID"] = "#userId";
	
	save_files(action,action_id,"modules/cgw/submit_cgw_callType",value_arr,null,null,null,null,null);
       set_value("action","insert",selector_type_id);
	pagination("cgw_callType",["call_type_id","ano","bno"],"report/view_page");
}

function get_cgw_callType(radio_arr){
	var return_val_arr = restore_fields("modules/cgw/get_cgw_callType",["action_id"]);
	var obj = jQuery.parseJSON( return_val_arr );
	$.each(obj,function(k, e_value){
		$.each(e_value,function(key, value){
			if($.inArray( key, radio_arr) >= 0){
				set_value(key,value,selector_type_radio);
			} else {
				set_value(key,value,selector_type_id);
			}
		});
	});
}
function newCallTypeExists(ct)
{
	var callTypeExist='';
	$.ajax(
		{
			url: 'modules/cgw/newCallTypeExists.php',
			type: 'post',
			data: "callTypeId="+ct,
			dataType: 'json',
			async: false,
			success: function(data) 
			{
				//alert(data); 
				//return data;
				callTypeExist = data;
			}
		});
		if(callTypeExist == null || callTypeExist =='')
		{
			//alert("callTypeExist does not exist");
			return false;
		}else{
			//alert("callTypeExist exists");
			return true;
		}
			
}


/**
* CGW Time Slot
*/
function save_cgw_timeSlot(action,action_id){
	var action = get_value("#action");
	var action_id = null;
	var timeSlotIdVal = get_value("#TimeSlotID");
	if(action == "update"){
		//action_id = get_value("#action_id");
		action_id = get_value("#timeSlotIdHidden");
		if(action_id != timeSlotIdVal && newTimeSlotExists(timeSlotIdVal))
		{
			$("#TimeSlotID").val(action_id);
			alert(err_msg10);
			return;
		}
	}
	else
	{
		if(newTimeSlotExists(timeSlotIdVal))
		{
			alert(err_msg10);
			return;
		}
	}
	var startTime = $("#StartTime").val();
	var endTime = $("#EndTime").val();
	//alert("startTime :"+startTime+"; endTime :"+endTime);
	var startTime_arr = startTime.split(" ");
	var endTime_arr = endTime.split(" ");
	
	var startTimeWithHM = startTime_arr[0];
	var startTimeWithTF = startTime_arr[1];
	var endTimeWithHM = endTime_arr[0];
	var endTimeWithTF = endTime_arr[1];
	
	var startTimeOnlyHM_arr = startTimeWithHM.split(":");
	var startTimeOnlyHour = startTimeOnlyHM_arr[0];
	var startTimeOnlyMin = startTimeOnlyHM_arr[1];
	
	var endTimeOnlyHM_arr = endTimeWithHM.split(":");
	var endTimeOnlyHour = endTimeOnlyHM_arr[0];
	var endTimeOnlyMin = endTimeOnlyHM_arr[1];
	
	var startTimeOnlyMinInt =   parseInt(startTimeOnlyMin)
	var startTimeOnlyHourInt = parseInt(startTimeOnlyHour);
	var totalStartTime;
	
	var endTimeOnlyMinInt =   parseInt(endTimeOnlyMin)
	var endTimeOnlyHourInt = parseInt(endTimeOnlyHour);
	var totalEndTime;
	

	//for start time
	if(startTimeWithTF == "AM")
	{
		if(startTimeOnlyHour == '12')
		{
			if(startTimeOnlyMinInt==0)
			{
				totalStartTime = 0;
			}
			else if(startTimeOnlyMinInt>0)
			{
				totalStartTime = startTimeOnlyMinInt;
			}
		}
		else
		{
			totalStartTime = (startTimeOnlyHourInt*60)+ startTimeOnlyMinInt;
		}
	}
	else if(startTimeWithTF == "PM")
	{
		if(startTimeOnlyHour == '12')
		{
			totalStartTime = (startTimeOnlyHourInt*60)+ startTimeOnlyMinInt;
		}
		else
		{
			totalStartTime = ((12+ startTimeOnlyHourInt)*60)+ startTimeOnlyMinInt;
		}
	}

	if(endTimeWithTF == "AM")
	{
		if(endTimeOnlyHour == '12')
		{
			if(endTimeOnlyMin=0)
			{
				totalEndTime = 0;
			}
			else if(endTimeOnlyMinInt>0)
			{
				totalEndTime = endTimeOnlyMinInt;
			}
		}
		else
		{
			totalEndTime = (endTimeOnlyHourInt*60)+endTimeOnlyMinInt;
		}
	}
	else if(endTimeWithTF == "PM")
	{
		if(endTimeOnlyHour == '12')
		{
			totalEndTime = ((endTimeOnlyHourInt)*60)+endTimeOnlyMinInt;
		}
		else
		{
			//alert("PM Total Hour :"+(12+endTimeOnlyHourInt));
			totalEndTime = ((12+endTimeOnlyHourInt)*60)+endTimeOnlyMinInt;
		}
	}
	//alert("For end time : endTimeWithTF :"+endTimeWithTF+"; endTimeOnlyHour :"+endTimeOnlyHour+"; endTimeOnlyMin :"+endTimeOnlyMin+"; totalEndTime :"+totalEndTime);
	
	
	$("#StartTimehidden").val(totalStartTime);
	$("#EndTimehidden").val(totalEndTime);
	var value_arr = {};
	value_arr["TimeSlotID"] = "#TimeSlotID";
	value_arr["StartDay"] = "#StartDay";
	value_arr["EndDay"] = "#EndDay";
	value_arr["StartTime"] = "#StartTimehidden";
	value_arr["EndTime"] = "#EndTimehidden";
	value_arr["UserID"] = "#userId";
	
	//alert("Start time :"+value_arr["StartTime"]+"; End Time :"+value_arr["EndTime"]);
	save_files(action,action_id,"modules/cgw/submit_cgw_timeSlot",value_arr);
	set_value("action","insert",selector_type_id);
	pagination("cgw_timeSlot",["id","TimeSlotID","StartDay","EndDay","StartTime","EndTime"],"report/view_page");
}

function get_cgw_timeSlot(radio_arr){
	var return_val_arr = restore_fields("modules/cgw/get_cgw_timeSlot",["action_id"]);
	var obj = jQuery.parseJSON( return_val_arr );
	$.each(obj,function(k, e_value){
		$.each(e_value,function(key, value){
			if($.inArray( key, radio_arr) >= 0){
				set_value(key,value,selector_type_radio);
			} else {
				set_value(key,value,selector_type_id);
			}
		});
	});
}

function newTimeSlotExists(ts,type){
	type = typeof type !== 'undefined' ? type : 'cgw';
	var timeSlotExist='',call_back_url='';
	
	/*if(type == "CGW"){
		call_back_url = 'modules/cgw/newTimeSlotExists.php';
	} else if(type == "SMSGW"){
		call_back_url = 'modules/cgw/newTimeSlotExists.php';
	} else if(type == "CH"){
		call_back_url = 'modules/cgw/newTimeSlotExists.php';
	}*/
	
	
	$.ajax(
		{
			url: 'modules/cgw/newTimeSlotExists.php',
			type: 'post',
			data: "timeSlotId="+ts+"&type="+type,
			dataType: 'json',
			async: false,
			success: function(data) 
			{
				//alert(data); 
				//return data;
				timeSlotExist = data;
			}
			 
		});
		if(timeSlotExist == null || timeSlotExist =='')
		{
			//alert("timeSlotExist does not exist");
			return false;
		}else{
			//alert("timeSlotExist exists");
			return true;
		}
			
}

/**
* CGW Service Promo
*/
function save_cgw_rc_servicePromo(action,action_id){
	var action = get_value("#action");
	var action_id = null;
	if(action == "update"){
		action_id = get_value("#action_id");
	}
	var value_arr = {};
	value_arr["SubscriptionGroupID"] = "#SubscriptionGroupID";
	value_arr["ToSubscriptionGroupID"] = "#ToSubscriptionGroupID";
	value_arr["ToStatus"] = "#ToStatus";
	value_arr["ActivationStart"] = "#ActivationStart";
	value_arr["ActivationEnd"] = "#ActivationEnd";
	value_arr["Status"] = "#Status";
	value_arr["Ano"] = "#Ano";
	value_arr["UserID"] = "#userId";
	
	save_files(action,action_id,"modules/cgw/submit_cgw_rc_servicePromo",value_arr,null,null,null,null,null);
	pagination("cgw_rc_servicePromo",["id","SubscriptionGroupID","ToSubscriptionGroupID","ToStatus","ActivationStart","ActivationEnd","Status","Ano"],"report/view_page",null,null);
}

function get_cgw_rc_servicePromo(radio_arr){
	var return_val_arr = restore_fields("modules/cgw/get_cgw_rc_servicePromo",["action_id"]);
	var obj = jQuery.parseJSON( return_val_arr );
	$.each(obj,function(k, e_value){
		$.each(e_value,function(key, value){
			if($.inArray( key, radio_arr) >= 0){
				set_value(key,value,selector_type_radio);
			} else {
				set_value(key,value,selector_type_id);
			}
		});
	});
}


/**
* CGW Subscription Group
*/
function save_cgw_rc_sg(){
	var action = get_value("#action");
	var action_id = null;
	if(action == "update"){
		action_id = get_value("#SubscriptionGroupID");
	}
	var value_arr = {};
	value_arr["SubscriptionGroupID"] = "#SubscriptionGroupID";
	value_arr["ParentID"] = "#ParentID";
	value_arr["CMSSeviceID"] = "#CMSSeviceID";
	value_arr["ServiceDuration"] = "#ServiceDuration";
	value_arr["GracePeriod"] = "#GracePeriod";
	value_arr["AllowDowngrade"] = "#AllowDowngrade";
	value_arr["BNI"] = "#BNI";
	value_arr["FreeServicePeriod"] = "#FreeServicePeriod";
	value_arr["OriginalSubscriptionGroupID"] = "#OriginalSubscriptionGroupID";
	value_arr["RetryRenewalPeriod"] = "#RetryRenewalPeriod";
	value_arr["RetryRenewalIntervalMinutes"] = "#RetryRenewalIntervalMinutes";
	value_arr["RenewNotificationDays"] = "#RenewNotificationDays";
	value_arr["RenewNotificationURL"] = "#RenewNotificationURL";
	value_arr["has_balance_option"] = "#has_balance_option";
	value_arr["initial_balance"] = "#initial_balance";
	value_arr["UserID"] = "#userId";
	value_arr["cpid"] = "#cp_id";
	value_arr["ServiceID"] = "#ServiceID";
	value_arr["wallettype"] = "#wallettype";
	
	var required_arr = ["SubscriptionGroupID","ServiceDuration","GracePeriod","BNI","FreeServicePeriod","RetryRenewalPeriod","RetryRenewalIntervalMinutes","RenewNotificationDays"];
			
	save_files(action,action_id,"modules/cgw/submit_cgw_rc_sg",value_arr,required_arr,null,null,null,null);
}

function get_cgw_rc_sg(radio_arr){
	show_hide(contentId,null);
	var return_val_arr = restore_fields("modules/cgw/get_cgw_rc_sg",["action_id"]);
	var obj = jQuery.parseJSON( return_val_arr );
	$.each(obj,function(k, e_value){
		$.each(e_value,function(key, value){
			if($.inArray( key, radio_arr) >= 0){
				set_value(key,value,selector_type_radio);
			} else {
				set_value(key,value,selector_type_id);
			}
		});
	});
}


/**
* CGW General Settings
*/
function save_cgw_generalSettings(action,action_id){
	//alert("save_cgw_generalSettings Enter");
	var action = get_value("#action");
	var action_id = null;
	if(action == "update"){
		action_id = get_value("#action_id");
	}
	var value_arr = {};
	value_arr["pName"] = "#pName";
	value_arr["pValue"] = "#pValue";
	value_arr["UserID"] = "#userId";
	
	var required_arr = ["pName","pValue"];
			
	save_files(action,action_id,"modules/cgw/submit_cgw_generalSettings",value_arr,required_arr,null,null,null,null);
	pagination("cgw_generalSettings",["id","pName","pValue"],"report/view_cgw_generalSettings",null,null);
}

function get_cgw_generalSettings(radio_arr){
	var return_val_arr = restore_fields("modules/cgw/get_cgw_generalSettings",["action_id"]);
	var obj = jQuery.parseJSON( return_val_arr );
	$.each(obj,function(k, e_value){
		$.each(e_value,function(key, value){
			if($.inArray( key, radio_arr) >= 0){
				set_value(key,value,selector_type_radio);
			} else {
				set_value(key,value,selector_type_id);
			}
		});
	});
}

/**
* CGW Configuration
*/
function get_cgw_configuration(radio_arr){
	var return_val_arr = restore_fields("modules/cgw/get_cgw_configuration",null);
	var obj = jQuery.parseJSON( return_val_arr );
	$.each(obj,function(key, value){
		if($.inArray( key, radio_arr) >= 0){
			//console.log("Key "+key+" in array");
			set_value(key,value,selector_type_radio);
		} else {
			set_value(key,value,selector_type_id);
		}
	});
	//reassign_value("#cgw_host","#cgw_host_ip"," ",".");
}
function save_cgw_conf(){
	var value_arr = {};

	value_arr["DB_HOST"] = "#DB_HOST";
	value_arr["DB_USER"] = "#DB_USER";
	value_arr["DB_PASSWORD"] = "#DB_PASSWORD";
	value_arr["DB_NAME"] = "#DB_NAME";
	value_arr["LISTENING_PORT"] = "#LISTENING_PORT";
	
	value_arr["BILLING_HOST"] = "#BILLING_HOST";
	value_arr["BILLING_PORT"] = "#BILLING_PORT";	
	value_arr["LOG_LEVEL"] = "#LOG_LEVEL";
	value_arr["LOG_DESTINATION"] = "#LOG_DESTINATION";
	
	value_arr["LOG_HOST"] = "#LOG_HOST";
	value_arr["SNMP_ENABLED"] = "input[name='SNMP_ENABLED']:checked";
	value_arr["SNMP_MANAGER_HOST_IP"] = "#SNMP_MANAGER_HOST_IP";
	value_arr["SNMP_MANAGER_PORT_NO"] = "#SNMP_MANAGER_PORT_NO";
	
	
	value_arr["SNMP_LOCAL_IP"] = "#SNMP_LOCAL_IP";
	value_arr["SHOULD_USE_REMARKS"] = "#SHOULD_USE_REMARKS";	
	value_arr["REGISTRATION_OUTPUT_ENABLED"] = "input[name='REGISTRATION_OUTPUT_ENABLED']:checked";
	value_arr["PACKAGE_CHECK_ENABLED_SESSION"] = "input[name='PACKAGE_CHECK_ENABLED_SESSION']:checked";
	
	value_arr["PACKAGE_CHECK_ENABLED_SPECIFIC"] = "input[name='PACKAGE_CHECK_ENABLED_SPECIFIC']:checked";
	value_arr["PREPAID_HOST_IP"] = "#PREPAID_HOST_IP";
	value_arr["PREPAID_HOST_PORT"] = "#PREPAID_HOST_PORT";
	value_arr["POSTPAID_HOST_IP"] = "#POSTPAID_HOST_IP";	
	value_arr["POSTPAID_HOST_PORT"] = "#POSTPAID_HOST_PORT";
	

	value_arr["DEBUG_GET_CONTENT"] = "input[name='DEBUG_GET_CONTENT']:checked";
	value_arr["CHARGE_USING_WEBSERVICE_ENABLE"] = "input[name='CHARGE_USING_WEBSERVICE_ENABLE']:checked";
	value_arr["CHARGING_WEBSERVICE_HOST_IP"] = "#CHARGING_WEBSERVICE_HOST_IP";
	value_arr["MSISDN_LENGTH"] = "#MSISDN_LENGTH";
	value_arr["REFUND_SESSION"] = "input[name='REFUND_SESSION']:checked";
	
	value_arr["DISCARD_PREFIX_OBD"] = "#DISCARD_PREFIX_OBD";
	value_arr["PERMEABLE_REQUEST_PROCESSING_TIME"] = "#PERMEABLE_REQUEST_PROCESSING_TIME";
	value_arr["COUNTRY_CODE"] = "#COUNTRY_CODE";
	value_arr["REGION_CHECK_ENABLE"] = "input[name='REGION_CHECK_ENABLE']:checked";
	
	
	//var required_arr = ["sctp_local_ip"];
	
	save_files("update",null,"modules/cgw/submit_cgw_configuration",value_arr,null,null,null,null,null);
}

/**
* CGW Rate Plan
*/
function save_cgw_ratePlan(){
	var action = get_value("#action");
	var action_id = null;
	
	if(action == "update"){
		action_id = get_value("#action_id");
	}

	/*rateIdStr ='';
	var package = get_value("#PackageID");
	var serviceIdStr = get_value("#ServiceID");
	var steppulserateVal =  get_value("#steppulserate_1");
	//alert("steppulserateVal :"+steppulserateVal);
	var steppulserateStr = "Zero";
	var prefixStr =  get_value("#prefix");
	var suffixStr = get_value("#suffix");
	
	if(steppulserateVal == 0)
	{
		//alert("steppulserateVal is zero :"+steppulserateVal);
		rateIdStr = steppulserateStr+'_'+serviceIdStr+'_'+'000';
	}
	else
	{
		//alert("steppulserateVal is not zero :"+steppulserateVal);
		rateIdStr = serviceIdStr+'_'+steppulserateVal;
	}

	if(prefixStr != null && prefixStr !='')
	{
		rateIdStr = prefixStr+'_'+rateIdStr;
	}
	else
	{	
		rateIdStr = rateIdStr;
	}
	if(suffixStr != null && suffixStr !='')
	{
		rateIdStr = rateIdStr+'_'+suffixStr;
	}
	else
	{
		rateIdStr = rateIdStr;
	}
	//alert("rateIdStr :"+rateIdStr);
	$("#RateIDhidden").val(rateIdStr);
	$("#RateIDhiddenOld").val(rateIdStr);*/
	
	var value_arr = {};
	// value_arr["RateName"] = "#RateName";
	value_arr["ServiceID"] = "#ServiceID";
	value_arr["PackageID"] = "#PackageID";
	value_arr["ChargingType"] = "#ChargingType";
	value_arr["ActivationStart"] = "#ActivationStart";
	value_arr["ActivationEnd"] = "#ActivationEnd";
	value_arr["Priority"] = "#Priority";
	
	value_arr["CallTypeID"] = "#CallTypeID";
	value_arr["TimeSlotID"] = "#TimeSlotID";
	value_arr["SubscriptionGroupID"] = "#SubscriptionGroupID";
	value_arr["SubscriptionStatus"] = "#SubscriptionStatus";
	value_arr["RateID"] = "#RateIDhidden";
	
	value_arr["region"] = "#region";
	value_arr["channel"] = "#channel";
	value_arr["cpid"] = "#cp_id";
	// value_arr["accumulatorid"] = "#accumulatorid";
	
	//var required_arr = ["RateName"];

			
	save_files(action,action_id,"modules/cgw/submit_cgw_ratePlan",value_arr,null,null,null,null,null,true);

}

function get_cgw_ratePlan(radio_arr){
	show_hide(contentId,null);
	var rateIdParam;
	var return_val_arr = restore_fields("modules/cgw/get_cgw_ratePlan",["action_id"]);
	var obj = jQuery.parseJSON( return_val_arr );
	$.each(obj,function(k, e_value){
		$.each(e_value,function(key, value){
			if($.inArray( key, radio_arr) >= 0){
				set_value(key,value,selector_type_radio);
			} else {
				if(key == "RateID")
				{
					//alert("key :"+key+"; value :"+value);
					rateIdParam = value;
				}
				set_value(key,value,selector_type_id);
			}
		});
	});
	prepareRatePulse(rateIdParam);
	setPrefixAndSuffix(rateIdParam);
	
}


/**
* CGW Rate Pulse
*/
function save_cgw_ratePulse(){
	//alert("save_cgw_ratePulse Enter");
	
	var action = get_value("#action");
	var action_id = null;
	var i=0;	
	var value_arr = {};
	var return_val = true;
	var l =document.getElementById("ratePulseTbd").childElementCount;
	if(action == "update"){
		action_id = get_value("#action_id");
		//remove_existing_ratePulse(rateIdParam);
	}
	
	
	for(i=1; i<l; i++)
	{
		value_arr["rateid"] = "#RateIDhidden";

		value_arr["stepno"] = "#stepNumber_"+i;
		value_arr["stepduration"] = "#stepduration_"+i;
		value_arr["steppulse"] = "#steppulse_"+i;
		value_arr["steppulserate"] = "#steppulserate_"+i;
		value_arr["serviceunit"] = "#serviceunit_"+i;
		
		value_arr["ActivationStart"] = "#ActivationStart";
		value_arr["ActivationEnd"] = "#ActivationEnd";
		value_arr["UserID"] = "#userId";
		action = "insert";
		// alert(l);
		if(i==l-1 ){
			return_val = false;
		} 
		save_files(action,action_id,"modules/cgw/submit_cgw_ratePulse",value_arr,null,null,null,null,null,return_val);
	}
	//alert(err_msg2);
}

function get_cgw_ratePulse(radio_arr){
//	show_hide(ratePulseContent,null);
	var return_val_arr = restore_fields("modules/cgw/get_cgw_ratePulse",["action_id"]);
	var obj = jQuery.parseJSON( return_val_arr );
	$.each(obj,function(k, e_value){
		$.each(e_value,function(key, value){
			if($.inArray( key, radio_arr) >= 0){
				set_value(key,value,selector_type_radio);
			} else {
				set_value(key,value,selector_type_id);
			}
		});
	});
}


function prepareRatePulse(rateIdParam){
//	alert("prepareRatePulse : Enter");
//	alert("rateIdParam :"+rateIdParam);	
	var rateIdVal =rateIdParam;
	var data = "rateIdVal="+rateIdVal;
	$.ajax(
	{
		url: 'modules/cgw/get_cgw_ratePulse.php',
		type: 'post',
		data: data,
		dataType: 'json',
		success: function(data) 
		{
			var headerRow = "<tr id='headerRow'>"+$('#headerRow').html()+"</tr>";
			var tdPlus = '<table><tbody><tr><td><input name="" id="removeRow_1" value="-" style="min-width:32px;visibility:hidden;" onclick="removeCurrentRatePulse(this);" type="button"></td><td><input name="" id="addNewRow_1" value="+" style="min-width:32px;visibility:visible;" onclick="addNewRatePulse();" type="button"></td></tr></tbody></table>';
//			alert(tdPlus);
			$('#ratePulseTbd').html(headerRow);
			if(data != null && data.length>0)
			{
				for(i=0;i<data.length;i++)
				{
					var buttonColumn= "";
					
					if (data.length == 1)
						buttonColumn = "<td id='tdPlus'>"+tdPlus+"</td>";
					else if (i < (data.length - 1))
						buttonColumn = "<td id='tdPlus'>"+tdPlus.replace('visibility:visible;', 'visibility:hidden').replace('removeRow_1', 'removeRow_'+(i+1-0)).replace("addNewRow_1", "addNewRow_"+(i+1-0))+"</td>";
					else 
						buttonColumn = "<td id='tdPlus'>"+tdPlus.replace('visibility:hidden;', '').replace('removeRow_1', 'removeRow_'+(i+1-0)).replace("addNewRow_1", "addNewRow_"+(i+1-0))+"</td>";

					var newRow = "<tr id='rowNumber_"+(i+1-0)+"'>" + 
													"<td> Step&nbsp;No&nbsp;"+(i+1-0)+"<input type='hidden' name='stepNumber_" +(i+1-0)+"' id = 'stepNumber_" +(i+1-0)+"' value='" +(i+1-0)+"'/></td>"+
													"<td><input id='stepduration_" +(i+1-0)+"' type='text' value='"+data[i].stepduration +"' name='stepduration' /></td>" + 
													"<td><input id='steppulse_"    +(i+1-0)+"' type='text' value='"+data[i].steppulse    +"' name='steppulse'    /></td>" + 
													"<td><input id='steppulserate_"+(i+1-0)+"' type='text' value='"+data[i].steppulserate+"' name='steppulserate'/></td>" + 
													"<td><input id='serviceunit_"  +(i+1-0)+"' type='text' value='"+data[i].serviceunit  +"' name='serviceunit'  /></td>" + 
													buttonColumn +
												"</tr>";
					$('#ratePulseTbd').html	(	$('#ratePulseTbd').html() + newRow);
					
				}
/*				$('#stepNumber_1').html('Step No ' + data[0].stepno+"<br/>");
				$('#stepduration_1').val(data[0].stepduration);
				$('#steppulse_1').val(data[0].steppulse);
				$('#steppulserate_1').val(data[0].steppulserate);
				$('#serviceunit_1').val(data[0].serviceunit);	
*/			}		
		}
	}); 
	$("#RateIDhidden").val(rateIdParam);
}
function setPrefixAndSuffix(rateIdParam)
{
	//alert("RateIDVal :"+rateIdParam);
	var value_arr = {};
	var matches;
	value_arr = rateIdParam.split('_');
	var arrLength = value_arr.length;
	var prefixStr='';
	var suffixStr = '';
	var prefixEndLength = -1;
	var suffixStartPosition;
	var steppulserateStr = "";
	var serviceIdStr = "";
	var numPartPosition= -1;
	for(var i=0; i<value_arr.length; i++)
		if(isNumeric(value_arr[i]) && value_arr[i] != '000') 
		{ 
			numPartPosition = i;
			i=value_arr.length;
		}
	if(numPartPosition == -1)
	{
		steppulserateStr = 0;
		for(var i=0; i<(value_arr.length-2); i++)
			if(value_arr[i] == 'Zero') 
			{ 
				prefixEndLength = i;

				i=value_arr.length;
			}
		for(var i=prefixEndLength+2; i<value_arr.length; i++)
			if(value_arr[i] == '000') 
			{ 
				suffixStartPosition = i;
				i=value_arr.length;
			}
		for (var i=0; i<prefixEndLength; i++)
			prefixStr = prefixStr + "_" + value_arr[i];
		prefixStr = prefixStr.substring(1);
		for (var i=(suffixStartPosition+1); i<value_arr.length; i++)
			suffixStr = suffixStr + "_" + value_arr[i];
		suffixStr = suffixStr.substring(1);
		for (var i=(prefixEndLength+1); i<suffixStartPosition; i++)
			serviceIdStr = serviceIdStr + "_" + value_arr[i];
		serviceIdStr = serviceIdStr.substring(1);
		//alert("arrLength :"+arrLength);
	}
	else
	{
		steppulserateStr = value_arr[numPartPosition];
		serviceIdStr =value_arr[numPartPosition-1];
		for(var i=0; i<(numPartPosition-1); i++)
			prefixStr = prefixStr + value_arr[i];
		for(var i=(numPartPosition+1); i<value_arr.length; i++)
			suffixStr = suffixStr + value_arr[i];
	}
	$("#prefix").val(prefixStr);
	$("#suffix").val(suffixStr);
}

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
function remove_existing_ratePulse(rateIdStr)
{
	//alert("remove_existing_ratePulse : Enter :"+rateIdStr);
	var data = "rateIdVal="+rateIdStr;
	$.ajax(
	{
		url: 'modules/cgw/remove_cgw_ratePulse.php',
		type: 'post',
		data: data,
		dataType: 'json',
		success: function(data) 
		{			
		}
	}); 
}

/**
 * CGW CDR LOAD
 */
 function load_cgw_cdr(){
	$.ajax({
		url: 'modules/cgw/getCDRStatus.php',
		type: 'post',
		dataType: 'json',
		success: function(data) {
			$('#showCDRWriteStatus').html('');//Your success msg
			$('#showCount').html('');//Your success msg
			for(i=0;i<data.length;i++)
			{
				$('#showCDRWriteStatus').html($('#showCDRWriteStatus').html() + data[i]['CDRWriteStatus']+"<br/>");//Your success msg
				$('#showCount').html($('#showCount').html() + data[i]['Count']+"<br/>");//Your success msg
			}
		}
	}); 
 }
 
 /**
 * CGW Statewisemsg 
 * Submit functionality
 */
 function save_cgw_statewisemsg(){
 	var action = get_value("#action");
	var action_id = null;
		
	if(action=="update"){
		action_id = get_value("#action_id");
	}
		
	var value_arr = {};
	value_arr["FromState"] = "#FromState";
	value_arr["ToState"] = "#ToState";
	value_arr["Msg"] = "#Msg";
	value_arr["URL"] = "#URL";
	value_arr["NotificationStatus"] = "#NotificationStatus";
	value_arr["SubscriptionGroupID"] = "#SubscriptionGroupID";
		
	save_files(action,action_id,"modules/cgw/submit_cgw_statewisemsg",value_arr,null,null,null,null,null);
	set_value("action","insert",selector_type_id);
	pagination("cgw_statewisemsg",["FromState","ToState","Msg","URL"],"report/view_cgw_generalSettings",null,null);
 }
  
/**
 *******************************
 ******** SMS Gateway **********
 *******************************
 */

/**
 * SMSGW Configuration
 */
function get_smsgw_configuration(radio_arr){
	var return_val_arr = restore_fields("modules/smsgw/get_smsgw_configuration",null);
	var obj = jQuery.parseJSON( return_val_arr );
	
	$.each(obj,function(key, value){
		if($.inArray( key, radio_arr) >= 0){
			//console.log("Key "+key+" in array");
			set_value(key,value,selector_type_radio);
		} else {
			set_value(key,value,selector_type_id);
		}
	});
	
	//reassign_value("#cgw_host","#cgw_host_ip"," ",".");
}
 
function save_smsgw_conf(){
	var value_arr = {};
	value_arr["smsc_ip"] = "#smsc_ip";
	value_arr["password"] = "#password";
	value_arr["host"] = "#host";
	value_arr["TON"] = "#TON";
	value_arr["source_TON"] = "#source_TON";
	value_arr["destination_TON"] = "#destination_TON";
	value_arr["TPS"] = "#TPS";
	value_arr["SNMP_Enable"] = "#SNMP_Enable";
	value_arr["SNMP_Port"] = "#SNMP_Port";
	value_arr["log_destination"] = "#log_destination";
	value_arr["API"] = "#API";
	value_arr["SMSC_Port"] = "#SMSC_Port";
	value_arr["user"] = "#user";
	value_arr["mode"] = "#mode";
	value_arr["NPI"] = "#NPI";
	value_arr["source_NPI"] = "#source_NPI";
	value_arr["destination_NPI"] = "#destination_NPI";
	value_arr["retry_count"] = "#retry_count";
	value_arr["SNMP_Manager_IP"] = "#SNMP_Manager_IP";
	value_arr["log_level"] = "#log_level";
	value_arr["method"] = "#method";
	
	//var required_arr = ["sctp_local_ip"];
	
	save_files("update",null,"modules/smsgw/submit_smsgw_configuration",value_arr,null,null,null,null,null);
}

/**
 * SMSGW Account Management
 */
function get_smsgw_account_info(){
	var return_val = restore_fields("modules/smsgw/get_smsgw_account_info",["action_id"]);
	var obj = jQuery.parseJSON( return_val );
	
	$.each(obj,function(key, value){
		set_value(key,value,selector_type_id);
	});
}

function save_smsgw_account_manager(tbl,callback_script){
	var action = get_value("#action");
	var action_id = null;
	if(action == "update"){
		action_id = get_value("#action_id");
	}
	
	var value_arr = {};
	value_arr["acc_name"] = "#acc_name";
	value_arr["balance"] = "#balance";
	value_arr["masks"] = "#masks";
	value_arr["is_active"] = "#is_active";
	
	save_files(action,action_id,"modules/smsgw/submit_account_manager",value_arr,null,tbl,callback_script,null,null);
	set_value("action","insert",selector_type_id);
}

/**
* SMSGW Single SMS
*/
function save_smsgw_singleSMS(action,action_id){
	
	var action = get_value("#action");

	var dstMNStr='';
	var countryCodeStr = get_value("#country_code");
	var recipientNo = get_value("#recipientNo");

	dstMNStr = countryCodeStr+recipientNo;

	//alert("dstMNStr :"+dstMNStr);
	$("#dstMN").val(dstMNStr);
	var currentdate = new Date(); 
	//alert("currentdate :"+currentdate+"; currentdate .getDate() :"+getDateTime())
	$("#writeTime").val(getDateTime());
	$("#msgStatus").val('QUE');
	
	var value_arr = {};
	value_arr["dstMN"] = "#dstMN";
	value_arr["msg"] = "#msg";
	value_arr["writeTime"] = "#writeTime";
	value_arr["msgStatus"] = "#msgStatus";
	
	var required_arr = ["msg"];
	var maskVal = get_value("#mask");
	
	$.ajax(
	{
		url: 'modules/smsgw/get_srcMN_From_Mask.php',
		type: 'post',
		data: "maskVal="+maskVal,
		dataType: 'json',
		async: false,
		success: function(data) 
		{ 
			//alert(data+" # "+data['srcMN']);
			if(data['srcMN'] != "undefined" && data['srcMN'])
			{
				var srcMNVal = data['srcMN'];
				//alert("save_smsgw_singleSMS : srcMNVal :"+srcMNVal);
				$("#srcMN").val(srcMNVal);
				
				value_arr["srcMN"] = "#srcMN";
				save_files(action,action_id,"modules/smsgw/submit_smsgw_singleSMS",value_arr,required_arr,null,null,null,null);
			}
					
			else
			{
				alert("Invalid Mask Value");
				return;
			}
		}	
	});	
}

function getDateTime() {
    var now     = new Date(); 
    var year    = now.getFullYear();
    var month   = now.getMonth()+1; 
    var day     = now.getDate();
    var hour    = now.getHours();
    var minute  = now.getMinutes();
    var second  = now.getSeconds(); 
    if(month.toString().length == 1) {
        var month = '0'+month;
    }
    if(day.toString().length == 1) {
        var day = '0'+day;
    }   
    if(hour.toString().length == 1) {
        var hour = '0'+hour;
    }
    if(minute.toString().length == 1) {
        var minute = '0'+minute;
    }
    if(second.toString().length == 1) {
        var second = '0'+second;
    }   
    var dateTime = year+'-'+month+'-'+day+' '+hour+':'+minute+':'+second;   
     return dateTime;
}


function calStringLength(id,limit,showStatus)
{
	//alert("calStringLength : id :"+id+"; limit :"+limit+"; showStatus :"+showStatus);
	var idLength = $(id).val().length;
	//limit = limit-1;
	if(idLength<=limit)
	{
		//alert("idLength<=limit : "+idLength);
		var strLength = limit-idLength;
		var showLengthStatus= strLength+" Remaining character";
		$(showStatus).html(showLengthStatus);
	}
	else
	{
		//alert("idLength > limit : "+idLength);
		$(id).val('');
		var strLength = limit;
		var showLengthStatus= strLength+" Remaining character";
		$(showStatus).html(showLengthStatus);
		return;
	}
}

function showInitialLength(showStatus,limit)
{
	var strLength = limit;
	var showLengthStatus= strLength+" Remaining character";
	$(showStatus).html(showLengthStatus);
}


/**
* SMSGW Contact Group
*/

function get_smsgw_contactGroup(radio_arr){
	var return_val_arr = restore_fields("modules/smsgw/get_smsgw_contactGroup",["action_id"]);
	var obj = jQuery.parseJSON( return_val_arr );
	$.each(obj,function(k, e_value){
		$.each(e_value,function(key, value){
			if($.inArray( key, radio_arr) >= 0){
				set_value(key,value,selector_type_radio);
			} else {
				set_value(key,value,selector_type_id);
			}
		});
	});
}

function save_smsgw_contactGroup(action,action_id){
	//alert("save_smsgw_contactGroup"); 
	var action = get_value("#action");
	var action_id = null;
	if(action == "update"){
		action_id = get_value("#action_id");
	}
	$("#last_updated").val(getDateTime());
	var value_arr = {};
	value_arr["group_name"] = "#group_name";
	value_arr["created_by"] = "#created_by";
	value_arr["last_updated"] = "#last_updated";
	
	save_files(action,action_id,"modules/smsgw/submit_smsgw_contactGroup",value_arr,null,null,null,null,null);
	set_value(action,"insert",selector_type_id);
	set_value("action","insert",selector_type_id);
	pagination("smsgw_contactGroup",["group_name"],"report/view_page",null,null);
}



/**
* SMSGW Contact Group Recipient
*/
function save_smsgw_contactGroupRecipient(action,action_id){
	
	var action = get_value("#action");

	var dstMNStr='';
	var countryCodeStr = get_value("#country_code");
	var recipient_noStr = get_value("#recipient_no");

	dstMNStr = countryCodeStr+recipient_noStr;

	//alert("dstMNStr :"+dstMNStr);
	$("#dstMN").val(dstMNStr);
	$("#last_updated").val(getDateTime());
	
	var value_arr = {};
	value_arr["group_id"] = "#group_id";
	value_arr["recipient_no"] = "#dstMN";
	value_arr["created_by"] = "#created_by";
	value_arr["last_updated"] = "#last_updated";
	value_arr["recipient_name"] = "#recipient_name_input";

	save_files(action,action_id,"modules/smsgw/submit_smsgw_contactGroupRecipient",value_arr,null,null,null,null,null);
	set_value(action,"insert",selector_type_id);
	//pagination("smsgw_contactGroupRecipient",null,"report/view_smsgw_contactGroupRecipient",null,null);
	pagination("smsgw_contactGroupRecipient",["group_id"],"report/view_smsgw_contactGroupRecipient",null,null,["group_id"],null);
}


/**
*Bulk SMS
*/
function submitForBulkSms(group_idValue,msgValue,maskValue){
	//alert("submitForBulkSms : Enter");
	$.ajax(
	{
		url: 'modules/smsgw/get_srcMN_From_Mask.php',
		type: 'post',
		data: "maskVal="+maskValue,
		dataType: 'json',
		async: false,
		success: function(data) 
		{ 
			if(data['srcMN'] != "undefined" && data['srcMN'])
			{
				var srcMNVal = data['srcMN'];
				//alert("save_smsgw_singleSMS : srcMNVal :"+srcMNVal);
				
				$.ajax(
				{
					/*url: 'modules/smsgw/submitBulkSms.php',*/
					url: 'modules/smsgw/submit_smsgw_bulksms.php',
					type: 'POST',
					data: "action=insert&group_id="+group_idValue+"&msg="+msgValue+"&mask="+srcMNVal,
					async: false,
					success: function(response) 
					{
						if(response == 0){
							alert("Submit successfully");
						} else {
							alert("Submit failed");
						}
					}
	
				});	
			}
					
			else
			{
				alert("Invalid Mask Value");
				return;
			}
		}	
	});	
}


/**
* SMSGW Keyword
*/
function save_smsgw_keyword(){
	var action = get_value("#action");
	var action_id = get_value("#keywordHidden");
	var keywordVal = get_value("#keywordHidden");
	/*if(action == "update"){
		//action_id = get_value("#action_id");
		action_id = get_value("#keywordHidden");
		if(newKeyExists(keywordVal))
		{
			$("#keyword").val(action_id);
			alert("Update Unsuccessful. New KeyWord already exists");
			return;
		}
	}
	else
	{
		if(newKeyExists(keywordVal))
		{
			alert("Insert Unsuccessful. New KeyWord already exists");
			return;
		}
	}*/
	var value_arr = {};
	value_arr["keyword"] = "#keyword";
	value_arr["SMSText"] = "#SMSText";
	value_arr["SrcType"] = "#SrcType";
	value_arr["URL"] = "#URL";
	value_arr["ShortCode"] = "#ShortCode";
	value_arr["Status"] = "#Status";

	
	save_files(action,action_id,"modules/smsgw/submit_smsgw_keyword",value_arr,null,null,null,null,null);
	set_value("action","insert",selector_type_id);
	pagination("smsgw_keyword",["keyword","SMSText","SrcType","URL","ShortCode","Status"],"report/view_page",null,null);
}

function get_smsgw_keyword(radio_arr){
	var return_val_arr = restore_fields("modules/smsgw/get_smsgw_keyword",["action_id"]);
	var obj = jQuery.parseJSON( return_val_arr );
	$.each(obj,function(k, e_value){
		$.each(e_value,function(key, value){
			if($.inArray( key, radio_arr) >= 0){
				set_value(key,value,selector_type_radio);
			} else {
				set_value(key,value,selector_type_id);
			}
		});
	});
}


function newKeyExists(kw)
{
	var keywordExist='';
	var ShortCode = get_value("#ShortCode");
	$.ajax(
		{
			url: 'modules/smsgw/newKeyExists.php',
			type: 'post',
			data: "keyword="+kw+"&ShortCode="+ShortCode,
			dataType: 'json',
			async: false,
			success: function(data) 
			{
				//alert(data); 
				//return data;
				keywordExist = data;
			}
			 
		});
		if(keywordExist == null || keywordExist =='')
		{
			//alert("keyword does not exist");
			return false;
		}else{
			//alert("keyword exists");
			return true;
		}
			
}


/**
* SMSGW Shortcode
*/
function save_smsgw_shortcode(action,action_id){
	var action = get_value("#action");
	var action_id = null;
	var shortcodeVal = get_value("#shortcode");
	if(action == "update"){
		//action_id = get_value("#action_id");
		action_id = get_value("#shortcodeHidden");
		if(action_id != shortcodeVal && newShortCodeExists(shortcodeVal))
		{
			$("#shortcode").val(action_id);
			alert("Update Unsuccessful. New Short Code already exists");
			return;
		}
	}
	else
	{
		if(newShortCodeExists(shortcodeVal))
		{
			alert("Insert Unsuccessful. New Short Code already exists");
			return;
		}
	}
	var value_arr = {};
	value_arr["shortcode"] = "#shortcode";
	value_arr["ErrorSMS"] = "#ErrorSMS";
	value_arr["DefaultKeyword"] = "#DefaultKeyword";
	
	save_files(action,action_id,"modules/smsgw/submit_smsgw_shortcode",value_arr,null,null,null,null,null);
       set_value("action","insert",selector_type_id);
	pagination("smsgw_shortcode",["shortcode","ErrorSMS","DefaultKeyword"],"report/view_page",null,null);
}

function get_smsgw_shortcode(radio_arr){
	var return_val_arr = restore_fields("modules/smsgw/get_smsgw_shortcode",["action_id"]);
	var obj = jQuery.parseJSON( return_val_arr );
	$.each(obj,function(k, e_value){
		$.each(e_value,function(key, value){
			if($.inArray( key, radio_arr) >= 0){
				set_value(key,value,selector_type_radio);
			} else {
				set_value(key,value,selector_type_id);
			}
		});
	});
}


function newShortCodeExists(sw)
{
	var keywordExist='';
	$.ajax(
		{
			url: 'modules/smsgw/newShortCodeExists.php',
			type: 'post',
			data: "shortcode="+sw,
			dataType: 'json',
			async: false,
			success: function(data) 
			{
				//alert(data); 
				//return data;
				shortCodeExist = data;
			}
			 
		});
		if(shortCodeExist == null || shortCodeExist =='')
		{
			//alert("shortcode does not exist");
			return false;
		}else{
			//alert("shortcode exists");
			return true;
		}
			
}

/**
* SMSGW Account Template
*/

function get_smsgw_account_template(radio_arr){
	var return_val_arr = restore_fields("modules/smsgw/get_smsgw_template",["action_id"]);
	var obj = jQuery.parseJSON( return_val_arr );
	$.each(obj,function(k, e_value){
		$.each(e_value,function(key, value){
			if($.inArray( key, radio_arr) >= 0){
				set_value(key,value,selector_type_radio);
			} else {
				set_value(key,value,selector_type_id);
			}
		});
	});
}

function save_smsgw_account_template(action,action_id){
	//alert("save_smsgw_account_template"); 
	var action = get_value("#action");
	var action_id = null;
	if(action == "update"){
		action_id = get_value("#action_id");
	}
	$("#last_updated").val(getDateTime());
	var value_arr = {};
	value_arr["msg"] = "#msg";
	value_arr["created_by"] = "#created_by";
	value_arr["last_updated"] = "#last_updated";
	
	save_files(action,action_id,"modules/smsgw/submit_smsgw_account_template",value_arr,null,null,null,null,null);
	set_value("action","insert",selector_type_id);
	pagination("smsgw_account_template",["msg"],"report/view_page",null,null);
}

/**
 * CMS
 */
function get_user_data(call_back_script,condition_arr){
	
    var return_val = restore_fields(call_back_script,condition_arr);
	var obj = jQuery.parseJSON( return_val );
	
	$.each(obj,function(key, value){
		if(key != "file" ){
			set_value(key,value,selector_type_id);
		}
	});
}

/**
* CMS Time Slot
*/
function save_cms_timeSlot(){
	var action = get_value("#action");
	var action_id = get_value("#action_id");
	var timeSlotIdVal = get_value("#TimeSlotID");
	/*if(action == "update"){
		//action_id = get_value("#action_id");
		action_id = get_value("#timeSlotIdHidden");
		if(action_id != timeSlotIdVal && newTimeSlotExists(timeSlotIdVal))
		{
			$("#TimeSlotID").val(action_id);
			alert(err_msg10);
			return;
		}
	}
	else
	{
		if(newTimeSlotExists(timeSlotIdVal))
		{
			alert(err_msg10);
			return;
		}
	}*/
	var startTime = $("#StartTime").val();
	var endTime = $("#EndTime").val();
	//alert("startTime :"+startTime+"; endTime :"+endTime);
	var startTime_arr = startTime.split(" ");
	var endTime_arr = endTime.split(" ");
	
	var startTimeWithHM = startTime_arr[0];
	var startTimeWithTF = startTime_arr[1];
	var endTimeWithHM = endTime_arr[0];
	var endTimeWithTF = endTime_arr[1];
	
	var startTimeOnlyHM_arr = startTimeWithHM.split(":");
	var startTimeOnlyHour = startTimeOnlyHM_arr[0];
	var startTimeOnlyMin = startTimeOnlyHM_arr[1];
	
	var endTimeOnlyHM_arr = endTimeWithHM.split(":");
	var endTimeOnlyHour = endTimeOnlyHM_arr[0];
	var endTimeOnlyMin = endTimeOnlyHM_arr[1];
	
	var startTimeOnlyMinInt =   parseInt(startTimeOnlyMin)
	var startTimeOnlyHourInt = parseInt(startTimeOnlyHour);
	var totalStartTime;
	
	var endTimeOnlyMinInt =   parseInt(endTimeOnlyMin)
	var endTimeOnlyHourInt = parseInt(endTimeOnlyHour);
	var totalEndTime;
	

	//for start time
	if(startTimeWithTF == "AM")
	{
		if(startTimeOnlyHour == '12')
		{
			if(startTimeOnlyMinInt==0)
			{
				totalStartTime = 0;
			}
			else if(startTimeOnlyMinInt>0)
			{
				totalStartTime = startTimeOnlyMinInt;
			}
		}
		else
		{
			totalStartTime = (startTimeOnlyHourInt*60)+ startTimeOnlyMinInt;
		}
	}
	else if(startTimeWithTF == "PM")
	{
		if(startTimeOnlyHour == '12')
		{
			totalStartTime = (startTimeOnlyHourInt*60)+ startTimeOnlyMinInt;
		}
		else
		{
			totalStartTime = ((12+ startTimeOnlyHourInt)*60)+ startTimeOnlyMinInt;
		}
	}

	
	//alert("For start time : startTimeWithTF :"+startTimeWithTF+"; startTimeOnlyHour :"+startTimeOnlyHour+"; startTimeOnlyMin :"+startTimeOnlyMin+"; totalStartTime :"+totalStartTime);

	if(endTimeWithTF == "AM")
	{
		if(endTimeOnlyHour == '12')
		{
			if(endTimeOnlyMin=0)
			{
				totalEndTime = 0;
			}
			else if(endTimeOnlyMinInt>0)
			{
				totalEndTime = endTimeOnlyMinInt;
			}
		}
		else
		{
			totalEndTime = (endTimeOnlyHourInt*60)+endTimeOnlyMinInt;
		}
	}
	else if(endTimeWithTF == "PM")
	{
		if(endTimeOnlyHour == '12')
		{
			totalEndTime = ((endTimeOnlyHourInt)*60)+endTimeOnlyMinInt;
		}
		else
		{
			//alert("PM Total Hour :"+(12+endTimeOnlyHourInt));
			totalEndTime = ((12+endTimeOnlyHourInt)*60)+endTimeOnlyMinInt;
		}
	}
	//alert("For end time : endTimeWithTF :"+endTimeWithTF+"; endTimeOnlyHour :"+endTimeOnlyHour+"; endTimeOnlyMin :"+endTimeOnlyMin+"; totalEndTime :"+totalEndTime);
	
	
	$("#StartTimehidden").val(totalStartTime);
	$("#EndTimehidden").val(totalEndTime);
	var value_arr = {};
	value_arr["TimeSlotID"] = "#TimeSlotID";
	value_arr["StartDay"] = "#StartDay";
	value_arr["EndDay"] = "#EndDay";
	value_arr["StartTime"] = "#StartTimehidden";
	value_arr["EndTime"] = "#EndTimehidden";
	value_arr["UserID"] = "#userId";
	
	//alert("Start time :"+value_arr["StartTime"]+"; End Time :"+value_arr["EndTime"]);
	save_files(action,action_id,"modules/cms/submit_cms_timeSlot",value_arr);
	set_value("action","insert",selector_type_id);
	pagination("cms_timeSlot",["action_id","TimeSlotID","StartDay","EndDay","StartTime","EndTime"],"report/view_page");
}

function get_prompt_location(call_back_script,condition_arr){
	var location = restore_fields(call_back_script,condition_arr);
	return location;
}

function set_content_provider(call_back_script,condition_arr){
	
    var return_val = restore_fields(call_back_script,condition_arr);
	var obj = jQuery.parseJSON( return_val );
	
	var val_of_hidden="";
	$.each(obj,function(key, value){
			if( val_of_hidden!="")
			{
				val_of_hidden+=",";
			}
			val_of_hidden+=value;
	});
	set_value("cph",val_of_hidden,selector_type_id);
	
	
	
	
	$("#cp option:selected").removeAttr("selected");
	$.each(obj,function(key, value){
		
			$( "select#cp option" ).each(function() {
					 if($( this ).val()==value)
					 {
						 $(this).prop("selected",true);   
					 }
					 
			});
			
	});
	
	
	
	
}

function set_request_source(call_back_script,condition_arr)
{
	var return_val = restore_fields(call_back_script,condition_arr);
	var obj = jQuery.parseJSON( return_val );
	
	var val_of_hidden="";
	$.each(obj,function(key, value){
			if( val_of_hidden!="")
			{
				val_of_hidden+=",";
			}
			val_of_hidden+=value;
	});
	set_value("sourceh",val_of_hidden,selector_type_id);
	$("#source option:selected").removeAttr("selected");
	$.each(obj,function(key, value){
		
			$( "select#source option" ).each(function() {
					 if($( this ).val()==value)
					 {
						 $(this).prop("selected",true);     
					 }
			});
			
	});
	
}


function save_user_data()
{
	var value_arr = {};
	value_arr["user_name"] = "#user_name";
	value_arr["email"] = "#email";
	value_arr["password"] = "#password";
	value_arr["file"] = "#file";
	value_arr['action_id']="#action_id";
	value_arr['action']="#action";
	value_arr['user_id']="#user_id";
	value_arr['role_id']="#role_id";
	value_arr['cp'] = "#cp";
	var emailText = get_value("#email");
	var action=get_value("#action");

	//if(emailText != "" ) // && !isValidEmail(emailText)
	//{
	//	alert(err_msg_invalid_email);
	//	return;
	//}
	file_upload(false,"modules/cms/fileupload","file",value_arr,["jpg","jpeg","png"],null,"tbl_user","report/view_page");
	
	//action,action_id,php_value,value_arr,required_arr,tbl,callback_script,show_id,hide_id
	
//	save_files(action,action_id,"modules/cms/update_user_data",value_arr,null,'tbl_user','report/view_page',null,null);
	set_value("action","insert",selector_type_id);
	
	$("#user_id").prop("disabled",false);
	//$("#role_id").prop("disabled",false);
	//$("#password").prop("disabled",false);

	/*var action = get_value("#action");
	var action_id = null;
	if(action == "update"){
		action_id = get_value("#action_id");
	}
	
	var value_arr = {};
	value_arr["user_name"] = "#user_name";
	value_arr["email"] = "#email";
	value_arr["password"] = "#password";
	value_arr['action_id']="#action_id";
	value_arr['action']="#action";
	file_upload(false,"modules/cms/fileupload","file",value_arr,["jpg","jpeg","png"],null,"tbl_user","report/view_page");
	
	//action,action_id,php_value,value_arr,required_arr,tbl,callback_script,show_id,hide_id
	
//	save_files(action,action_id,"modules/cms/update_user_data",value_arr,null,'tbl_user','report/view_page',null,null);
	set_value("action","insert",selector_type_id);
	*/
}


function save_uploaded_content()
{
	var action = get_value("#action");
	var action_id = null;
	if(action == "update"){
		action_id = get_value("#action_id");
	}
	
	var value_arr = {};
	value_arr["category_id"] = "#category_id";
	value_arr["cname"] = "#cname";
	value_arr["title"] = "#title";
	value_arr["description"] = "#desc";
	value_arr["content_type"] = "#c_type";
	value_arr["sms"] = "#sms";
	value_arr["sms_type"] = "#sms_type";
	value_arr["download_url"] = "#d_url";
	value_arr["preview_url"] = "#u_url";
	value_arr["actdate"] = "#actdate";
	value_arr['deadate']="#deadate";
	value_arr['action']="#action";
	value_arr['action_id']="#action_id";
	
	if(get_value("#c_type") == "ivr")
		file_upload(true,"modules/cms/content_upload","file",value_arr,["wav"],null,"content_list","report/view_page");
	else
		save_files(action,action_id,"modules/cms/content_upload",value_arr,null,"content_list","report/view_page");
	
	//action,action_id,php_value,value_arr,required_arr,tbl,callback_script,show_id,hide_id
	
//	save_files(action,action_id,"modules/cms/update_user_data",value_arr,null,'tbl_user','report/view_page',null,null);
	set_value("action","insert",selector_type_id);
	
	$("#category_id").prop("disabled",false);
	
}

function save_account_manager_data()
{
	
	var action = get_value("#action");
	var action_id = null;
	if(action == "update"){
		action_id = get_value("#action_id");
	}
	
	var value_arr = {};
	value_arr["action"] = "#action";
	value_arr["action_id"] = "#action_id";
	value_arr["name"] = "#name";
	value_arr["email"] = "#email";
	value_arr["user_name"] = "#user_name";
	value_arr["password"] = "#password";
	value_arr["cpid"] = "#cpid";
	
	save_files(action,action_id,"modules/cms/save_account_data",value_arr,null,"tbl_cms_account","report/view_page",null,null);
	set_value("action","insert",selector_type_id);
	$("#cpid").prop("disabled",false);
	
	
}
function saveCategoryAndServices()
{

	var action = get_value("#action");
	var action_id = null;
	if(action == "update"){
		action_id = get_value("#action_id");
	}
	
	
			var m_select = "";
			$( "select#cp option:selected" ).each(function() {
				 if(m_select) m_select += ",";
				 m_select += $( this ).val();
			});
			
			set_value("cph", m_select,selector_type_id);
			
			var m_select = "";
			$( "select#source option:selected" ).each(function() {
				 if(m_select) m_select += ",";
				 m_select +=$( this ).val();
			});
			
			set_value("sourceh", m_select,selector_type_id);
			
			
	
	var value_arr = {};
	value_arr["category_name"] = "#category_name";
	value_arr["prompt"] = "#prompt";
	value_arr["post_prompt"] = "#post_prompt";
	value_arr["display_order"] = "#display_order";
	value_arr["active"] = "#active";
	
	value_arr["parent"] = "#parent";
	value_arr["pre_prompt"] = "#pre_prompt";
	value_arr["ivr_string"] = "#ivr_string";
	value_arr["status"] = "#status";
	value_arr["deactive"] = "#deactive";
	value_arr["cph"] = "#cph";
	value_arr["sourceh"] = "#sourceh";
	value_arr["TimeSlotID"] = "#timeslot_id";
	
	
	$("#source option:selected").removeAttr("selected");
	$("#cp option:selected").removeAttr("selected");
	
	save_files(action,action_id,"modules/cms/save_category_and_services",value_arr,null,"tbl_cms_category","report/view_page",null,null);
	set_value("action","insert",selector_type_id);
	$("#category_name").prop("disabled",false);
	//alert(get_value("#action"));
	//$("#cpid").prop("disabled",false);
	
}

/**
* CMS Service Keyword 
*/
function save_cms_service_keyword(){
	var action = get_value("#action");
	var action_id = null;
	if(action == "update"){
		action_id = get_value("#action_id");
	}
	var value_arr = {};
	value_arr["operator_db"] = "#operator_db";
	value_arr["Root"] = "#Root";
	value_arr["ServiceID"] = "#ServiceID";
	value_arr["ServiceName"] = "#ServiceName";
	value_arr["Description"] = "#Description";
	value_arr["IsDeregMsg"] = "#IsDeregMsg";
	value_arr["DeRegURL"] = "#DeRegURL";
	value_arr["DeRegMsg"] = "#DeRegMsg";
	value_arr["DeRegAllMsg"] = "#DeRegAllMsg";
	value_arr["DeRegExtraURL"] = "#DeRegExtraURL";
	value_arr["RegURL"] = "#RegURL";
	value_arr["RegMsg"] = "#RegMsg";
	value_arr["RegExtraURL"] = "#RegExtraURL";
	value_arr["AlreadyRegistedMsg"] = "#AlreadyRegistedMsg";
	value_arr["InfoURL"] = "#InfoURL";
	value_arr["Status"] = "#Status";
	value_arr["SrcType"] = "#SrcType";
	value_arr["SMSText"] = "#SMSText";
	value_arr["ShortCode"] = "#ShortCode";
	
	var required_arr = ["operator_db","Root"];
			
	save_files(action,action_id,"modules/cms/submit_cms_service_keyword",value_arr,required_arr);
	pagination("cms_service_keyword",null,"report/view_cms_service_keyword",null,null,["operator_db"],["operator_db"]);
}


function load_obd_service_list(callback_script,condition_arr)
{
	
	var return_val_arr = restore_fields(callback_script,condition_arr);
    var obj = jQuery.parseJSON( return_val_arr );    
    var str_data = "";
    $.each(obj,function(key, value){
    	str_data  += "<option value='"+key+"'>"+value+","+"Instance ID: "+key+"</option>";
	});
                
    return str_data;  
}
function show_obd_dashboard()
{
	return restore_fields("modules/obd/show_obd_dashboard",["server_id","service_id"]);
}



function save_cs_service_config(){
	
 	var action = get_value("#action");
	var action_id = null;
		
	if(action=="update"){
		action_id = get_value("#action_id");
	}
		
	var value_arr = {};
	value_arr["ServiceName"] = "#ServiceName";
	value_arr["RegURL"] = "#RegURL";
	value_arr["DeregURL"] = "#DeregURL";
	value_arr["BlockURL"] = "#BlockURL";
	value_arr["UnblockURL"] = "#UnblockURL";
	
	var encode_field_arr = ["#RegURL","#DeregURL","#BlockURL","#UnblockURL"];
	
		
	save_files(action,action_id,"modules/cs/submit_cs_service_config",value_arr,null,null,null,null,null,null,encode_field_arr);
	set_value("action","insert",selector_type_id);
	pagination("cs_service_config",["ServiceName","RegURL","DeregURL","BlockURL","UnblockURL"],"report/view_cs_service_config",null,null);	
}