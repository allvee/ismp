<h1>Customer Support </h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">CMS</a></li>
			<li><a href="#">Customer Support</a></li>
        </ul>
	</div>
	<div class="content">
   
      <div class="halfpan fl">
          <h2> Customer Support</h2>
          <label>MSISDN</label>
          <input name="msisdn" id="msisdn" type="text"  />
          <label>Short Code</label>
          <input name="short_code" id="short_code" type="text" onkeyPress="return numeralsOnly(event)" />
 		  <label>Start Date</label>
          <input name="start_date" id="start_date" type="text"  />
           <label>End Date</label>
          <input name="end_date" id="end_date" type="text"  />
          
          <input type="button" value="Generate" id="submit" />
       </div>
       <!--<div class="halfpan fr">
          
          <input name="purpose" id="purpose" type="hidden" value="" />
          <label>MSISDN</label>
          <input name="msisdn_service" id="msisdn_service" type="text"  />
          <label>Service</label>
          <select name="service_name" id="service_name">
          	<option value="all">ALL</option>
          </select>
          
          <input type="button" value="Register" id="register" style="font-size:15px; height:28px; min-width:160px;" />
          <input type="button" value="Deregister" id="deregister" style="font-size:15px; height:28px; min-width:160px;"  />
          <input type="button" value="Block" id="block" style="font-size:15px; height:28px; min-width:160px;"  />
          <input type="button" value="Unblock" id="unblock" style="font-size:15px; height:28px; min-width:160px;"  />
       </div>-->
      
       <div class="subsection" id="view_customer_list" style="height:1048px; overflow:auto;"></div>
</div>
  
<script>
function load_reports(){
	if(get_value("#msisdn") != ""){
		var list=restore_fields("modules/cs/show_customer_report",['msisdn','short_code','start_date','end_date']);
		$("#view_customer_list").html(list);
	}
}

function callurl(url){
	var data = "call_url="+encodeURIComponent(url);
	$.post("modules/cs/statuschange.php",data,function(response){
		// alert(response);
		load_reports();
	});
	
}

function execute_customer_functionality(purpose){
	var msisdn = get_value("#msisdn_service");
	var service_name = get_value("#service_name");
	set_value("purpose",purpose,selector_type_id);
		
	if(msisdn != ""){
		var return_val_arr = restore_fields("modules/cs/execute_customer_requirement",["msisdn_service","service_name","purpose"]);
		alert(return_val_arr);
	} else {
		alert("Please provide MSISDN");
		return false;
	}
}

$(document).ready(function() {
		
	$('#start_date,#end_date').datetimepicker({
		format:			'Y-m-d',
		timepicker:false
	});

	
	$("#submit").click(function(){
		load_reports();
	});
	
	$("#register").click(function(){
		execute_customer_functionality("register");
		
	});
	$("#deregister").click(function(){
		execute_customer_functionality("deregister");
	});
	$("#block").click(function(){
		execute_customer_functionality("block");
	});
	$("#unblock").click(function(){
		execute_customer_functionality("unblock");
	});
	// $("#view_customer_list").html(restore_fields("modules/cs/show_customer_report",['msisdn','short_code','start_date','end_date']));	 
});
</script>

