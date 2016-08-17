<script type="application/javascript">
	$(document).ready(function() {
		get_sgw_configuration("+");
		
		$("#submit").click(function() { 
			save_sgw_conf();		
        });
	});
</script>
	<h1>SGW : Configuration Panel </h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">SGW</a></li>
		</ul>
	</div>
	<div class="content">
    	<input name="id" type="hidden" value="" id="id" />
		<div class="halfpan fl">
			<label>SCTP Local IP</label>
			<input name="sctp_local_ip" type="text" value="" id="sctp_local_ip" />
			<label>SCTP Remote IP </label>
			<input name="sctp_remote_ip" type="text" value="" id="sctp_remote_ip" />
			<label>SCTP Mode </label>
			<div class="inputreplace">
				Client <input name="sctp_mode" type="radio" value="client" /> 
                Server <input name="sctp_mode" type="radio" value="server" />
			</div>
			<label>DPC </label>
			<input name="dpc" type="text" value="" id="dpc" />
			<label>Route Context </label>
			<input name="route_context" type="text" value="" id="route_context" />
			<label>Local SIP IP </label>
			<input name="local_sip_ip" type="text" value="" id="local_sip_ip" />
			<label>Media Server IP </label>
			<input name="media_server_ip" type="text" value="" id="media_server_ip" />
			<label>Log Level</label>
			<input name="log_level" type="text" value="" id="log_level" />
		</div>
		<div class="halfpan fr">
			<label>SCTP Local Port</label>
			<input name="sctp_local_port" type="text" value="" id="sctp_local_port" />
			<label>SCTP Remote Port </label>
			<input name="sctp_remote_port" type="text" value="" id="sctp_remote_port" />
			<label>OPC </label>
			<input name="opc" type="text" value="" id="opc" />
			<label>No of Channel </label>
			<input name="no_of_channel" type="text" value="" id="no_of_channel" />
			<label>M3UA Register </label>
			<input name="m3ua_register" type="text" value="" id="m3ua_register" />
			<label>Local SIP Port </label>
			<input name="local_sip_port" type="text" value="" id="local_sip_port" />
			<label> Media Server SIP Port</label>
			<input name="media_server_sip_port" type="text" value="" id="media_server_sip_port" />
			<label>Log Destination</label>
			<input name="log_destination" type="text" value="" id="log_destination" />
		</div>
		<div class="btnarea"><input name="submit" type="button" id="submit" value="Submit" /></div>
    </div>