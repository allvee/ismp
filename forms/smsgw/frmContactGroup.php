<script type="application/javascript">
	$(document).ready(function() {

		pagination("smsgw_contactGroup",["group_name"],"report/view_page",null,null);
				
		$("#submit").click(function() { 
			save_smsgw_contactGroup();
		});	
	});
</script>
	<h1>SMSGW : Account : Group</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">SMSGW</a></li>
			<li><a href="#">Account</a></li>
			<li><a href="#">Group</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="id" value="" id="action_id" />
            <input type="hidden" name="created_by" id="created_by" value="<?php echo $_SESSION['USER_ID']; ?>"/>
            <input type="hidden" name="last_updated" value="" id="last_updated" />
			<label>Group Name </label>
			<input name="group_name" type="text" value="" id="group_name"/>
		</div>
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
    <div class="tblcss" id="view_smsgw_contactGroup" style="height:300px; overflow:auto;"></div>