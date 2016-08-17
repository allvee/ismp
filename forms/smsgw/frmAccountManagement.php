<script type="application/javascript">

	$(document).ready(function() {
		pagination("smsgw_account_manager",["acc_name","balance","masks"],"report/view_page",null,null);
		$("#submit").click(function() { 
			save_smsgw_account_manager("smsgw_account_manager","report/view_page");
		});
	});
</script>
	<h1>SMSGW : Account Management</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">SMSGW</a></li>
            <li><a href="#">SMS Service Configuration</a></li>
            <li><a href="#">Administration</a></li>
		</ul>
	</div>
	<div class="content">
    <input type="hidden" name="action" value="insert" id="action" />
    <input type="hidden" name="action_id" value="" id="action_id" />
		<div class="halfpan fl">
			<label>Account Name</label>
            <input type="text" name="acc_name" value="" id="acc_name" />
			<label>Credit Balance</label>
			<input type="text" name="balance" value="" id="balance" />
        </div>
        <div class="halfpan fr">
            <label>Masks</label>
            <textarea id="masks" name="masks" cols="30"></textarea>
			<label>Status </label>
            <select name="is_active" id="is_active">
            	<option value="inactive">Inactive</option>
                <option value="active">Active</option>
            </select>
		</div>
		<div class="clear"></div>
		<div class="btnarea"><input type="button" value="Submit" id="submit" /></div>
	</div>
    
    <div class="tblcss" id="view_smsgw_account_manager" style="height:1048px; overflow:auto;"></div>