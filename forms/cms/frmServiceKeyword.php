<script type="application/javascript">

	$(document).ready(function() {
		createDropDown('operator_db', 'modules/cms/getProcessdb',null,'--Select--','');
		createDropDown('Root', 'modules/cms/get_keyword',null,'--Select--','');
		//createDropDown('timeslot', 'modules/cgw/getTimeSlotID',null,'--Select--',' ');
		pagination("cms_service_keyword",null,"report/view_cms_service_keyword",null,null,["operator_db"],["operator_db"]);
		//pagination(tbl,value_arr,callback_script,show_id,hide_id,param_arr,required_arr)
		$("#submit").click(function() { 
			if(operator_db == ""){
				alert("Please select database");	
			} else {
				save_cms_service_keyword();
			}
		});
		
		$("#operator_db").change(function() {
            pagination("cms_service_keyword",null,"report/view_cms_service_keyword",null,null,["operator_db"],["operator_db"]);
        });

		
	});

</script>
	<h1>CMS : Service Keyword</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">CMS</a></li>
			<li><a href="#">Service Keyword</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="action_id" value="" id="action_id" />
            

           	<label>DB Name </label>
            <select name="operator_db" id="operator_db"></select>
            <label>Root</label>
            <select name="Root" id="Root"></select>
			<label>Service ID</label>
            <input type="text" name="ServiceID" value="" id="ServiceID"/>
			<!--<select name="ServiceID" id="ServiceID"></select>-->
            <label>ServiceName </label>
			<input type="text" name="ServiceName" value="" id="ServiceName"/>
            <label>Description </label>
			<input type="text" name="Description" value="" id="Description"/>
            <label>IsDeregMsg </label>
			<input type="text" name="IsDeregMsg" value="0" id="IsDeregMsg"/>
            <label>DeRegURL </label>
			<input type="text" name="DeRegURL" value="" id="DeRegURL"/>
            <label>DeRegMsg </label>
			<input type="text" name="DeRegMsg" value="" id="DeRegMsg"/>
            <label>DeRegAllMsg </label>
			<input type="text" name="DeRegAllMsg" value="" id="DeRegAllMsg"/>
            <label>DeRegExtraURL </label>
			<input type="text" name="DeRegExtraURL" value="" id="DeRegExtraURL"/>
            <label>RegURL </label>
			<input type="text" name="RegURL" value="" id="RegURL"/>
            <label>RegMsg </label>
			<input type="text" name="RegMsg" value="" id="RegMsg"/>
            <label>RegExtraURL </label>
			<input type="text" name="RegExtraURL" value="" id="RegExtraURL"/>
            <label>AlreadyRegistedMsg </label>
			<input type="text" name="AlreadyRegistedMsg" value="" id="AlreadyRegistedMsg"/>
            <label>InfoURL </label>
			<input type="text" name="RegURL" value="" id="InfoURL"/>
            <label>Status </label>
			<select name="Status" id="Status">
            	<option value="Active">Active</option>
				<option value="Inactive">Inactive</option>
            </select>
            <label>SrcType </label>
			<input type="text" name="SrcType" value="" id="SrcType"/>
            <label>SMSText </label>
			<input type="text" name="SMSText" value="" id="SMSText"/>
            <label>ShortCode </label>
			<input type="text" name="ShortCode" value="" id="ShortCode"/>
            
		</div>
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
    <div class="tblcss" id="view_cms_service_keyword" style="height:300px; overflow:auto;"></div>