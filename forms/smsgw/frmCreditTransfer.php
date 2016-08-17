<script type="application/javascript">
function get_smsgw_accounts(){
	var return_val = restore_fields("modules/smsgw/get_smsgw_accounts",null);
	$("#acc_name").html(return_val);
	get_smsgw_accounts_balance();
}

function get_smsgw_accounts_balance(){
	var return_val = restore_fields("modules/smsgw/get_smsgw_accounts_balance",["acc_name"]);
	set_value("balance",return_val,selector_type_id);
}

function save_smsgw_credit_transfer(){
	var value_arr = {};
	value_arr["acc_name"] = "#acc_name";
	value_arr["amount_credit"] = "#amount_credit";
	
	save_files("insert",null,"modules/smsgw/submit_credit_transfer",value_arr,null,null,null,null,null);
	set_value("amount_credit","",selector_type_id);
	get_smsgw_accounts();
}

	$(document).ready(function() {
		get_smsgw_accounts();
		$("#submit").click(function() { 
			save_smsgw_credit_transfer();
		});
		
		$("#acc_name").change(function() {
            get_smsgw_accounts_balance();
        });
	});
</script>
	<h1>SMSGW : Credit Transfer</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">SMSGW</a></li>
            <li><a href="#">SMS Service Configuration</a></li>
            <li><a href="#">Administration</a></li>
		</ul>
	</div>
	<div class="content">
    <input type="hidden" name="action" value="update" id="action" />
    <input type="hidden" name="action_id" value="" id="action_id" />
		<div class="halfpan fl">
			<label>Account Name</label>
            <select name="acc_name" id="acc_name"></select>
            <label>Current Balance</label>
			<input type="text" name="balance" value="" id="balance" readonly="readonly" />
            <label>Amount of Credit</label>
            <input type="text" name="amount_credit" value="" id="amount_credit" />
		</div>
		<div class="clear"></div>
		<div class="btnarea"><input type="button" value="Submit" id="submit" /></div>
	</div>
    