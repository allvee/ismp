<script type="application/javascript">
	$(document).ready(function() {
		pagination("ch_call_routing",["ano","bno","status","provision_end_date","url"],"report/view_page",null,null);
		
		$("#submit").click(function() { 
			save_ch_call_routing();
			pagination("ch_call_routing",["ano","bno","status","provision_end_date","url"],"report/view_page",null,null);
		});
		
		$('#provision_end_date').datetimepicker({
                datepicker:true,
                timepicker:true,
				format: 'Y-m-d H:i:s',
				formatTime: 'H:i',
				step:30
		});	
	});
</script>
	<h1>USSD : Dial Plan</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
            <li><a href="#">USSD</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="id" value="" id="action_id" />
            
			<label>ANO </label>
			<input type="text" name="ano" value="" id="ano" />
			<label>BNO </label>
			<input type="text" name="bno" value="" id="bno" />
			<label>Status </label>
			<div class="inputreplace">
				 Provision <input name="status" type="radio" value="Provision" /> Active <input name="status" type="radio" value="Active" />
			</div>
			<label>Provision End Date </label>
			<input type="text" name="provision_end_date" value="" id="provision_end_date"/>
			<label>URL</label>
			<input type="text" name="url" value="" id="url" />
		</div>
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
    <div class="tblcss" id="view_ch_call_routing" style="height:1048px; overflow:auto;"></div>