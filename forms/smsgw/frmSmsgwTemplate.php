<script type="application/javascript">
	$(document).ready(function() {

		pagination("smsgw_account_template",["msg"],"report/view_page",null,null);
				
		$("#submit").click(function() {
			//alert("submit"); 
			save_smsgw_account_template();
		});
		
		
	});
</script>
	<h1>SMSGW : Account : Template</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">SMSGW</a></li>
			<li><a href="#">Account</a></li>
			<li><a href="#">Template</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="id" value="" id="action_id" />
            <input type="hidden" name="created_by" id="created_by" value="<?php echo $_SESSION['USER_ID']; ?>"/>
            <input type="hidden" name="last_updated" value="" id="last_updated" />
			<label>Text </label>
			<textarea class="txtarea" style="width: 256px; height: 64px;" rows="3" name="msg" id="msg" value=""></textarea>
		</div>
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
    <div class="tblcss" id="view_smsgw_account_template" style="height:300px; overflow:auto;"></div>