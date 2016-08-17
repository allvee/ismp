
<h1>CMS : USER PANEL</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">CMS</a></li>
			<li><a href="#">User Panel</a></li>
            <li><a href="#">Report</a></li>
            <li><a href="#">Subscription Attempt</a></li>
		</ul>
	</div>
	<div class="content">
      <div class="halfpan fl">
         <h2>Subscription Attempt</h2>
          <input type="hidden" value="OAM" id="request_type" />
          <input type="hidden" value="subscription_attempt" id="page_type" />
          <label>Operator</label>
          <select  name="operator_id" id="operator_id" ></select> 
          <label>Service</label>
          <select  name="service_id" id="service_id" ></select> 
        
 
         
          <label>From</label>
          <input name="from" id="from_id" type="text"  />
           <label>To</label>
          <input name="to" id="to_id" type="text"  />
          
          <input type="button" value="Show" id="submit" />
         
      </div>
     </div>
    <div class="tblcss" id="view_subscription_attempt" style="height:1048px; overflow:auto;"></div>

<script>
$( document ).ready(function() {
		
	
	  
		var list=load_list("modules/cms/get_operator_list",['request_type']);
		list='<option  value="">--Select--</option>'+list;
	    $("#operator_id").html(list);
	
	
	    var list=load_list("modules/cms/get_subscription_group_list",['page_type']);
		list='<option value="">--Select--</option><option value="All">--[ All ]--</option>'+list;
	    $("#service_id").html(list);
	
		
		
		function load_again()
		{
				var list=load_list("modules/cms/get_operator_list",['request_type']);
				list='<option  value="">--Select--</option>'+list;
				$("#operator_id").html(list);
				
				
				var list=load_list("modules/cms/get_subscription_group_list",['page_type']);
				list='<option value="">--Select--</option><option value="All">--[ All ]--</option>'+list;
				$("#service_id").html(list);
		
		}
		
	
	
	    $("#submit").click(function(){
		
		            var canSubmit=true;
		            if($("#operator_id").val()=="")
					{
					var node=$("<p>Select an operator</p>").css({"left":"190px","position":"relative","top":"-10px","color":"#C00"});
						$( "#operator_id" ).next().empty();
						$( "#operator_id" ).after(node);
						canSubmit=false;
						
					}
					if($("#service_id").val()=="")
					{
					   var node=$("<p>Select a service</p>").css({"left":"190px","position":"relative","top":"-10px","color":"#C00"});
						$( "#service_id" ).next().empty();
						$( "#service_id" ).after(node);
						canSubmit=false;
					}
					if(	$("#from_id").val()=="" )
					{
					var node=$("<p>Select from date</p>").css({"left":"190px","position":"relative","top":"-10px","color":"#C00"});
						$( "#from_id" ).next().empty();
						$( "#from_id" ).after(node);
						canSubmit=false;
					}
					if(	$("#to_id").val()=="" )
					{
					var node=$("<p>Select to date</p>").css({"left":"190px","position":"relative","top":"-10px","color":"#C00"});
						$( "#to_id" ).next().empty();
						$( "#to_id" ).after(node);
						canSubmit=false;
					
					}
					
					if(!canSubmit){
						
						load_again();
						console.log("test");
						return;
					}else{
						
						var list=restore_fields("modules/cms/showSubscriptionAttempt",['operator_id','service_id','from_id','to_id']);
						 // console.log(list);	 
						  $("#view_subscription_attempt").html(list);
					
					}	
			
		});	
	
	
	jQuery('#from_id,#to_id').datetimepicker({
				format:			'Y-m-d H:i:s'
		});
		

});


</script>





