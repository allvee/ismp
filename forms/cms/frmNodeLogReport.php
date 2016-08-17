
<h1>CMS : USER PANEL</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">CMS</a></li>
			<li><a href="#">User Panel</a></li>
            <li><a href="#">Report</a></li>
            <li><a href="#">Node Log Report</a></li>
		</ul>
	</div>
	<div class="content">
        <div class="halfpan fl">
            <h2>Node Log Report</h2>
            <input type="hidden" value="no" id="trigger" /> 
            <input type="hidden" value="NLOG" id="request_type" />
            <input type="hidden" value="node_log_report" id="page_type" />
            <label>Operator</label>
            <select  name="operator_id" id="operator_id"></select> 
            <label>Service</label>
            <select  name="service_id" id="service_id" ></select> 
         
            <label>From</label>
            <input name="from" id="from_id" type="text"  />
            <label>To</label>
            <input name="to" id="to_id" type="text"  />
            
            <input type="button" value="Show" id="submit" />
        </div>
     </div>
     
    <img src="img/csv_1.png" id="csv" style="width:64px;height:24px;cursor:pointer;float:right"/>
    <div class="tblcss" id="view_nodelog_report" style="height:1024px;overflow:auto;"></div>

<script type="text/javascript">
function load_again()
{
	var list=load_list("modules/cms/get_operator_list",['request_type']);
	list='<option  value="">--Select--</option>'+list;
	$("#operator_id").html(list);
	var list=load_list("modules/cms/get_subscription_group_list",['page_type']);
	list='<option value="">--Select--</option><option value="All">--[ All ]--</option>'+list;
	$("#service_id").html(list);
}

$(document).ready(function(){
		
		var list=load_list("modules/cms/get_operator_list",['request_type']);
		list='<option  value="">--Select--</option>'+list;
	    $("#operator_id").html(list);

		var list=load_list("modules/cms/get_subscription_group_list",['page_type']);
		list='<option value="">--Select--</option><option value="All">--[ All ]--</option>'+list;
	    $("#service_id").html(list);
	
		$("#csv").hide();
	    
		$("#submit").click(function(){
		
				var op=get_value("#operator_id")==""?0:1,sv=get_value("#service_id")==""?0:1;
				var fd=get_value("#from_id")==""?0:1,td=get_value("#to_id")==""?0:1;
				//alert(op+":"+sv+":"+fd+":"+td);
				if(op==1 && sv==1 && fd==1 && td==1)
				{
				    var list=restore_fields("modules/cms/show_nodelog_report",['operator_id','service_id','from_id','to_id','trigger']);
				    //console.log(list);	
					if(list && list.indexOf("tr")>-1){ 
					   $("#view_nodelog_report").html(list);
					   $("#csv").show();
					}else if(list==1){
						$("#view_nodelog_report").empty().html("<p style='color:salmon'>No Data Available</p>");
						$("#csv").hide();
					}else{ //database connection error
						$("#view_nodelog_report").empty().html(list);
						$("#csv").hide();
					}
					
					
				}else{
					   $("#view_nodelog_report").html("");
					   $("#csv").hide();
				}
		});	
	
		jQuery('#from_id,#to_id').datetimepicker({
				format:'Y-m-d',
				timepicker:false
		});
});

$("#csv").click(function(){
		var param="operator_id="+get_value("#operator_id")+"&"+"service_id="+get_value("#service_id")+"&"+"from_id="+
		get_value("#from_id")+"&"+"to_id="+get_value("#to_id")+"&"+"page_type="+get_value("#page_type")+"&"+"trigger=yes";
		window.open("modules/cms/show_nodelog_report.php?"+param);
});
</script>

