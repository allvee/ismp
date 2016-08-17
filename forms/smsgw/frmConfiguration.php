<script type="application/javascript">
	$(document).ready(function() {
		var radio_arr = [];
		get_smsgw_configuration(radio_arr);
	
		$("#submit").click(function() { 
			save_smsgw_conf();		
        });
		
		/*
		$("#HOST").blur(function() {
			reassign_value("#HOST","#HTTP_HOST_IP","."," ");
        });
		
		$("#cgw_host_ip").blur(function() {
            reassign_value("#cgw_host_ip","#cgw_host","."," ");
        });
	*/
	});
</script>
	<h1>SMSGW : Configuration Panel </h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">SMSGW</a></li>
		</ul>
	</div>
	<div class="content">
	<!--
    	sample hidden input fields
        <input type="hidden" name="RELEASE_ON_RTP_MAX_GAP" value="" id="RELEASE_ON_RTP_MAX_GAP" />
        <input type="hidden" name="RTP_GAP_FILLUP_ENABLE" value="" id="RTP_GAP_FILLUP_ENABLE" />
        -->
		<div class="halfpan fl">
			<label>Select Method </label>
            <select name="method" id="method">
            	<option value="SMPP">SMPP</option>
                <option value="API">API</option>
            </select>
			<label>SMSC IP </label>
			<input name="smsc_ip" type="text" value="" id="smsc_ip" />
			<label>Password </label>
			<input name="password" type="password" value="" id="password">
			<label>Host </label>
			<input name="host" type="text" value="" id="host" />
			<label>TON </label>
			<input name="TON" type="text" value="" id="TON" />
			<label>Source TON </label>
			<input name="source_TON" type="text" value="" id="source_TON" />
			<label>Destination TON </label>
			<input name="destination_TON" type="text" value="" id="destination_TON" />
			<label>TPS </label>
			<input name="TPS" type="text" value="" id="TPS" />
			<label>SNMP Enable </label>
			<input name="SNMP_Enable" type="text" value="" id="SNMP_Enable" />
			<label>SNMP Port </label>
			<input name="SNMP_Port" type="text" value="" id="SNMP_Port" />
			<label>Log Destination </label>
			<input name="log_destination" type="text" value="" id="log_destination" />
			<label>API </label>
			<input name="API" type="text" value="" id="API" />
			
		</div>
		<div class="halfpan fr">
			<label>SMSC Port </label>
			<input name="SMSC_Port" type="text" value="" id="SMSC_Port" />
			<label>User </label>
			<input name="user" type="text" value="" id="user" />
			<!--<label>Mode </label>-->
			<input name="mode" type="hidden" value="" id="mode" />
			<label>NPI </label>
			<input name="NPI" type="text" value="" id="NPI" />
			<label>Source NPI </label>
			<select name="source_NPI" id="source_NPI">
            	<option value="1">a</option>
                <option value="2">b</option>
            </select>
			<label>Destination NPI </label>
			<input name="destination_NPI" type="text" value="" id="destination_NPI" />
			<label>Retry Count </label>
			<input name="retry_count" type="text" value="" id="retry_count" />
			<label>SNMP Manager IP </label>
			<input name="SNMP_Manager_IP" type="text" value="" id="SNMP_Manager_IP" />
			<label>Log Level </label>
			<input name="log_level" type="text" value="" id="log_level" />
		</div>
		<div class="btnarea">
			<input name="submit" type="button" id="submit" value="Submit" />
		</div>
	</div>