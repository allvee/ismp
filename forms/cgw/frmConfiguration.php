<script type="application/javascript">
	$(document).ready(function() {
		var radio_arr = [ "SNMP_ENABLED", "REGISTRATION_OUTPUT_ENABLED", "PACKAGE_CHECK_ENABLED_SESSION", "PACKAGE_CHECK_ENABLED_SPECIFIC","DEBUG_GET_CONTENT","CHARGE_USING_WEBSERVICE_ENABLE","REFUND_SESSION","REGION_CHECK_ENABLE" ];
		get_cgw_configuration(radio_arr);
		
		$("#submit").click(function() { 
			save_cgw_conf();		
        });		
	});
</script>
	<h1>CGW : Configuration Panel </h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">CGW</a></li>
		</ul>
	</div>
	<div class="content">
			<label>DB HOST </label>
			<input name="DB_HOST" type="text" value="" id="DB_HOST" />
			<label>DB USER </label>
			<input name="DB_USER" type="text" value="" id="DB_USER" />			
			<label>DB PASSWORD </label>
			<input name="DB_PASSWORD" type="text" value="" id="DB_PASSWORD" />
            <label>DB NAME </label>
			<input name="DB_NAME" type="text" value="" id="DB_NAME" />
			<label>LISTENING PORT </label>
			<input name="LISTENING_PORT" type="text" value="" id="LISTENING_PORT" />			
			<label>BILLING HOST </label>
			<input name="BILLING_HOST" type="text" value="" id="BILLING_HOST" />
			<label>BILLING PORT </label>
			<input name="BILLING_PORT" type="text" value="" id="BILLING_PORT" />			
			<label>LOG LEVEL </label>
			<input name="LOG_LEVEL" type="text" value="" id="LOG_LEVEL" />
			<label>LOG DESTINATION </label>
			<input name="LOG_DESTINATION" type="text" value="" id="LOG_DESTINATION" />			
			<label>LOG HOST </label>
			<input name="LOG_HOST" type="text" value="" id="LOG_HOST" />
			<label>SNMP ENABLED </label>
			<div class="inputreplace">
				 Yes<input name="SNMP_ENABLED" type="radio" value="1" /> No <input name="SNMP_ENABLED" type="radio" value="0" />
			</div><br clear="all" />			
			<label>SNMP MANAGER HOST IP </label>
			<input name="SNMP_MANAGER_HOST_IP" type="text" value="" id="SNMP_MANAGER_HOST_IP" />
			<label>SNMP MANAGER PORT NO </label>
			<input name="SNMP_MANAGER_PORT_NO" type="text" value="" id="SNMP_MANAGER_PORT_NO" />			
			<label>SNMP LOCAL IP </label>
			<input name="SNMP_LOCAL_IP" type="text" value="" id="SNMP_LOCAL_IP" />		
			<label>SHOULD USE REMARKS </label>
			<input name="SHOULD_USE_REMARKS" type="text" value="" id="SHOULD_USE_REMARKS" />			
			<label>REGISTRATION OUTPUT ENABLED </label>
			<div class="inputreplace">
				 Yes<input name="REGISTRATION_OUTPUT_ENABLED" type="radio" value="1" /> No <input name="REGISTRATION_OUTPUT_ENABLED" type="radio" value="0" />
			</div><br clear="all" />
			<label>PACKAGE CHECK ENABLED SESSION </label>
			<div class="inputreplace">
				 Yes<input name="PACKAGE_CHECK_ENABLED_SESSION" type="radio" value="1" /> No <input name="PACKAGE_CHECK_ENABLED_SESSION" type="radio" value="0" />
			</div><br clear="all" />				
			<label>PACKAGE CHECK ENABLED SPECIFIC </label>
			<div class="inputreplace">
				 Yes<input name="PACKAGE_CHECK_ENABLED_SPECIFIC" type="radio" value="1" /> No <input name="PACKAGE_CHECK_ENABLED_SPECIFIC" type="radio" value="0" />
			</div><br clear="all" />
			<label>PREPAID HOST IP </label>
			<input name="PREPAID_HOST_IP" type="text" value="" id="PREPAID_HOST_IP" />							
			<label>PREPAID HOST PORT </label>
			<input name="PREPAID_HOST_PORT" type="text" value="" id="PREPAID_HOST_PORT" />
			<label>POSTPAID HOST IP </label>
			<input name="POSTPAID_HOST_IP" type="text" value="" id="POSTPAID_HOST_IP" />			
			<label>POSTPAID HOST PORT </label>
			<input name="POSTPAID_HOST_PORT" type="text" value="" id="POSTPAID_HOST_PORT" />
			<label>DEBUG GET CONTENT </label>
			<div class="inputreplace">
				 Yes<input name="DEBUG_GET_CONTENT" type="radio" value="1" /> No <input name="DEBUG_GET_CONTENT" type="radio" value="0" />
			</div><br clear="all" />			
			<label>CHARGE USING WEBSERVICE ENABLE </label>
			<div class="inputreplace">
				 Yes<input name="CHARGE_USING_WEBSERVICE_ENABLE" type="radio" value="1" /> No <input name="CHARGE_USING_WEBSERVICE_ENABLE" type="radio" value="0" />
			</div><br clear="all" />
			<label>CHARGING WEBSERVICE HOST IP </label>
			<input name="CHARGING_WEBSERVICE_HOST_IP" type="text" value="" id="CHARGING_WEBSERVICE_HOST_IP" />				
			<label>MSISDN LENGTH </label>
			<input name="MSISDN_LENGTH" type="text" value="" id="MSISDN_LENGTH" />
			<label>REFUND SESSION </label>
			<div class="inputreplace">
				 Yes<input name="REFUND_SESSION" type="radio" value="1" /> No <input name="REFUND_SESSION" type="radio" value="0" />
			</div><br clear="all" />
            
            <label>DISCARD PREFIX</label>
			<input name="DISCARD_PREFIX_OBD" type="text" value="" id="DISCARD_PREFIX_OBD" />				
			<label>PERMEABLE REQUEST PROCESSING TIME</label>
			<input name="PERMEABLE_REQUEST_PROCESSING_TIME" type="text" value="" id="PERMEABLE_REQUEST_PROCESSING_TIME" />
			<label>COUNTRY CODE</label>
			<input name="COUNTRY_CODE" type="text" value="" id="COUNTRY_CODE" />
			<label>REGION CHECK ENABLE</label>
			<div class="inputreplace">
				 Yes<input name="REGION_CHECK_ENABLE" type="radio" value="1" /> No <input name="REGION_CHECK_ENABLE" type="radio" value="0" />
			</div><br clear="all" />			
		<div class="btnarea">
			<input name="submit" type="button" id="submit" value="Submit" />
		</div>
	</div>