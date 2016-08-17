<script type="application/javascript">
/**
* CGW TPS DB Operation
*/
function save_cgw_subscription_wallet(){
	var action = get_value("#action");
	var action_id = null;
	if(action == "update"){
		action_id = get_value("#action_id");
	}
	var value_arr = {};
	value_arr["subscriptiongroupid"] = "#subscriptiongroupid";
	value_arr["serviceid"] = "#serviceid";
	value_arr["bno"] = "#bno";
	
	value_arr["balance"] = "#balance";
	value_arr["walletid"] = "#walletid";
	value_arr["startdate"] = "#startdate";
	
	value_arr["enddate"] = "#enddate";
	value_arr["freewallet"] = "#freewallet";
	value_arr["freewallet_enddate"] = "#freewallet_enddate";
	
	//var required_arr = ["appid","value"];
			
	save_files(action,action_id,"modules/cgw/submit_cgw_subscription_wallet",value_arr,null,null,null,null,null);
	pagination("cgw_subscription_wallet",["bno","balance","startdate","enddate","freewallet","freewallet_enddate"],"report/view_cgw_generalSettings",null,null);
}

	$(document).ready(function() {
		createDropDown('subscriptiongroupid', 'modules/cgw/getSubscriptionGroupIDForRatePlan',null,'--Select--',' ');
		createDropDown('serviceid', 'modules/cgw/getServiceID',null,'--Select--',' ');
		createDropDown('walletid', 'modules/cgw/get_wallet',null,'--Select--',' ');
		
		pagination("cgw_subscription_wallet",["bno","balance","startdate","enddate","freewallet","freewallet_enddate"],"report/view_cgw_generalSettings",null,null);
		
		jQuery('#startdate,#enddate,#freewallet_enddate').datetimepicker({
			format: 'Y/m/d H:i:i',
			formatTime: 'H:i:i', // i means increment with step
			formatDate: 'Y/m/d',
			step:1,
			yearStart:1800,
			yearEnd:2250,
		}); 
		
		
		
		$("#submit").click(function() { 
			save_cgw_subscription_wallet();
		});

		
	});

</script>
	<h1>CGW : Rate Configuration : Subscription Wallet</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">CGW</a></li>
            <li><a href="#">Rate Plan Management</a></li>
			<li><a href="#">Subscription Wallet</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="action_id" value="" id="action_id" />
            

           	<label>Subscription Group Id </label>
            <select name="subscriptiongroupid" id="subscriptiongroupid"></select>
			<label>Service Id </label>
            <select name="serviceid" id="serviceid"></select>
			
            <label>BNo </label>
			<input type="text" name="bno" value="" id="bno"/>
            <label>Balance </label>
			<input type="text" name="balance" value="" id="balance"/>
            
            <label>Wallet Id</label>
			<select name="walletid" id="walletid"></select>
			
            <label>Start Date </label>
			<input type="text" name="startdate" value="" id="startdate"/>
            <label>End Date </label>
			<input type="text" name="enddate" value="" id="enddate"/>
            
            <label>Free Wallet </label>
			<input type="text" name="freewallet" value="" id="freewallet"/>
            <label>Free Wallet End Date </label>
			<input type="text" name="freewallet_enddate" value="" id="freewallet_enddate"/>
            
		</div>
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
    <div class="tblcss" id="view_cgw_subscription_wallet" style="height:400px; overflow:auto;"></div>