<script type="application/javascript">
	$(document).ready(function(){
		pagination("smsgw_sms_permission",null,"report/view_smsgw_contactGroupRecipient",null,null,null,null);
		
		$("#search").click(function(){	
			var search_options = {};
			search_options["msg"] = "msg";
			search_options["mask"] = "mask";
			pagination("smsgw_sms_permission",null,"report/view_smsgw_contactGroupRecipient",null,null,search_options,null);
			
		});
	});
</script>

	<h1>SMS Blast : Bulk SMS Permission</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">SMS Blast</a></li>
			<li><a href="#">Bulk SMS Permission</a></li>
		</ul>
	</div>
	
	<div class="content" id="contentId">
		<div class="halfpan fl">	
			<input type="hidden" name="action" value="insert" id="action" />
			<input type="hidden" name="id" value="" id="action_id" />
			<div class="searchPanel">
				<label>Mask </label>
				<input name="mask" type="text" value="" id="mask"  style="width: 256px;">
				<label>Message </label>
				<textarea class="txtarea" style="width: 258px;" rows="3" name="msg" id="msg" value=""></textarea>
		
				<input type="button" value="Search" id="search" />
			</div>
		</div>
	</div>
	<div class="tblcss" id="view_smsgw_sms_permission" style="height:1000px; overflow:auto;"></div>