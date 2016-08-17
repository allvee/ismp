<script type="application/javascript">
/**
* CGW TPS
*/
function save_cgw_tps(){
	var action = get_value("#action");
	var action_id = null;
	if(action == "update"){
		action_id = get_value("#action_id");
	}
	var value_arr = {};
	value_arr["appid"] = "#appid";
	value_arr["timeslot"] = "#timeslot";
	value_arr["value"] = "#value";
	value_arr["serviceid"] = "#serviceid";
	value_arr["priority"] = "#priority";
	
	var required_arr = ["appid","value"];
			
	 save_files(action,action_id,"modules/cgw/submit_cgw_tps",value_arr,required_arr,null,null,null,null);
	pagination("cgw_tps",["appid","value"],"report/view_cgw_generalSettings",null,null);
}

	$(document).ready(function() {
		createDropDown('serviceid', 'modules/cgw/getServiceID',null,'--Select--',' ');
		createDropDown('appid', 'modules/cgw/get_application_info',null,'--Select--',' ');
		createDropDown('timeslot', 'modules/cgw/getTimeSlotID',null,'--Select--',' ');
		pagination("cgw_tps",["appid","value"],"report/view_cgw_generalSettings",null,null);
		
		$("#submit").click(function() { 
			save_cgw_tps();
		});

		
	});

</script>
	<h1>CGW : Rate Configuration : TPS</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">CGW</a></li>
			<li><a href="#">Rate Configuration</a></li>
            <li><a href="#">Rate Plan Management</a></li>
			<li><a href="#">TPS</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="action_id" value="" id="action_id" />
            

           	<label>App Id </label>
            <select name="appid" id="appid"></select>
            <label>Service Id </label>
            <select name="serviceid" id="serviceid"></select>
			<!--<label>Service Id </label>
            <input type="text" name="serviceid" value="" id="serviceid"/>-->
            <label>Time Slot </label>
			<select name="timeslot" id="timeslot"></select>
			<label>Priority</label>
			<select name="priority" id="priority">
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
			</select>
			<label>Value </label>
			<input type="text" name="value" value="" id="value"/>
		</div>
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
    <div class="tblcss" id="view_cgw_tps" style="height:300px; overflow:auto;"></div>