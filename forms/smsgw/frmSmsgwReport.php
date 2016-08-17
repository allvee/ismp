<script type="application/javascript">
	$(document).ready(function() 
	{
		pagination("smsgw_report",null,"report/view_smsgw_report",null,null,null,null);
		
		$("#mask").blur(function() {
            searchSmsReport(get_value("#mask"));
        });
		
		$("#search").click(function() 
		{	
			var search_options = {};
			search_options["start_date"] = "start_date";
			search_options["end_date"] = "end_date";
			search_options["destination_number"] = "destination_number";
			search_options["msg"] = "msg";
			search_options["srcMN"] = "srcMN";
			pagination("smsgw_report",null,"report/view_smsgw_report",null,null,search_options,null);
			
		});
		
		$('#start_date').datetimepicker({
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            "showTime": "false"
		});	
		
		$('#end_date').datetimepicker({
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            "showTime": "false"
		});	
	
	});
	
	function searchSmsReport(maskValue){
		$.ajax(
		{
			url: 'modules/smsgw/get_srcMN_From_Mask.php',
			type: 'post',
			data: "maskVal="+maskValue,
			dataType: 'json',
			asyc: false,
			success: function(data) 
			{ 
				if(data['srcMN'] != "undefined" && data['srcMN'])
				{
					var srcMNVal = data['srcMN'];
					$("#srcMN").val(srcMNVal);
				}
						
				else
				{
					alert("Invalid Mask Value");
					return;
				}
			}	
		});	
	}


</script>
	<h1>SMSGW : SMS Service Configuration : Report</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">SMSGW</a></li>
			<li><a href="#">SMS Service Configuration</a></li>
			<li><a href="#">Report</a></li>
		</ul>
	</div>
	
	<div class="content" id="contentId">
		<div class="halfpan fl">	
			<input type="hidden" name="action" value="insert" id="action" />
			<input type="hidden" name="id" value="" id="action_id" />
			<input type="hidden" name="userId" id="userId" value="<?php echo $_SESSION['USER_ID']; ?>"/>
			<input type="hidden" name="srcMN" value="" id="srcMN" />
			<div class="searchPanel">
				<label>Start Date </label>
					<input name="start_date" type="text"  id="start_date" style="width:245px;"/>
				<label>End Date</label>
					<input name="end_date" type="text"  id="end_date" style="width:245px;"/>
				<label>Destination Number </label>
					<input name="destination_number" type="text" value="" id="destination_number"  style="width: 256px;">
				<label>Mask </label>
					<input name="mask" type="text" value="" id="mask"  style="width: 256px;">
				<label>Message </label>
					<textarea class="txtarea" style="width: 258px;" rows="3" name="msg" id="msg" value=""></textarea>
		
				<input type="button" value="Search" id="search" />
			</div>
		</div>
	</div>
	<div class="tblcss" id="view_smsgw_report" style="height:500px; overflow:auto;"></div>