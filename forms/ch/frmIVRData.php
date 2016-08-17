<h1>IVR : IVR Data</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">IVR</a></li>
			<li><a href="#">IVR Data</a></li>
        </ul>
	</div>
	<div class="content">
      <div class="halfpan fl">
         <h2>IVR Data</h2>
         
          <input type="hidden" name="action" value="insert" id="action" />
          <input type="hidden" name="action_id" value="" id="action_id" />
          <label>Select Service</label>
          <select  name="service_id" id="service_id" ></select> 
          <label>Select Page</label>
          <select  name="page_id" id="page_id" ></select> 
          <input type="button" value="Submit" id="submit" />
       </div>
     </div>
    <div class="tblcss" id="view_ivr_data" style="overflow:auto;"></div>
<script>
	
	function refreshList()
	{
			var service_list = restore_fields("modules/ch/get_service_and_page",null);
			var json_data = JSON.parse(service_list);
			var service_string = "";
			$.each(json_data.service,function(key,val){
				service_string+='<option value="'+val+'">'+val+'</option>';
			});
			var page_string = "";
			$.each(json_data.page,function(key,val){
				page_string +='<option value="'+val+'">'+val+'</option>';
			});
			$("#service_id").html(service_string);
			$("#page_id").html(page_string);
			console.log("Data::",json_data.service);	
	}
	
	$(document).ready(function(){
			
		refreshList();
			
		$("#submit").click(function() { 
			var search_options = {};
			search_options["service_id"] = "service_id";
			search_options["page_id"] = "page_id";
			pagination("ivr_data",["UniqueID","RateName","ServiceID","PackageID","ChargingType","CallTypeID","TimeSlotID","SubscriptionGroupID","SubscriptionStatus","RateID"],"report/view_ivr_data",null,null,search_options,null);
			//pagination("cgw_ratePulse",["UniqueID","rateid","stepno","stepduration","steppulse","steppulserate","serviceunit"],"report/view_cgw_ratePulse",null,null,null,null);
		});
		  
		
		   // pagination("ivr_data",null,"report/view_ivr_data",null,null);  
		   
});
</script>

