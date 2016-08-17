<script type="application/javascript">
	
	function get_cgw_counter_list(){
		var data = "action_id="+get_value("#action_id");
		$.post("modules/cgw/get_cgw_counter_list.php",data,function(response){
			$("#counter_id").html(response);
		});
	}
		
	function get_cgw_accumulator_info(){
		var return_val = restore_fields("modules/cgw/get_cgw_accumulator_info",["action_id"]);
		var obj = jQuery.parseJSON( return_val );
		
		$.each(obj,function(key, value){
			set_value(key,value,selector_type_id);
		});
	}
	
	function save_cgw_accumulator(){
		var action = get_value("#action");
		var action_id = get_value("#action_id");
		
		if(action=="insert"){
			var action_id =null;
		}
		
		var value_arr = {};
		value_arr["id"] = "#accumulator_id";
		value_arr["discounttype"] = "#discount_type_id";
		value_arr["counterid"] = "#counter_id";
		value_arr["amount"] = "#amount_id";
		
		save_files(action,action_id,"modules/cgw/submit_cgw_accumulator",value_arr,null,null,null,null,null);
		set_value("action","insert",selector_type_id);
		$("#counter_id option:selected").removeAttr("selected");
		pagination("cgw_accumulator",["accumulator_id","amount_id"],"report/view_page",null,null);
	}	
	
	
	
	
	$(document).ready(function() {
		
		pagination("cgw_accumulator",["accumulator_id","amount_id"],"report/view_page",null,null);
		get_cgw_counter_list();
		
		$("#submit").click(function() {
			save_cgw_accumulator();
		});
	});
</script>
	<h1>CGW : Rate Configuration : Rate Plan Management : Accumulator</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">CGW</a></li>
			<li><a href="#">Rate Configuration</a></li>
			<li><a href="#">Rate Plan Management</a></li>
			<li><a href="#">Accumulator</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="id" value="" id="action_id" />
            <input type="hidden" name="accumulatorHidden" value="" id="accumulatorHidden" />
            <input type="hidden" name="userId" id="userId" value="<?php echo $_SESSION['USER_ID']; ?>"/>
            
            <label>Accumulator ID </label>
			<input type="text" name="accumulator_id" value="" id="accumulator_id" />
			<label>Counter ID</label>
			<select name="counter_id" id="counter_id" multiple="multiple" >
            </select>
			<label>Discount Type</label>
			<select id="discount_type_id" name="discount_type_id">
                <option value="FIXED">FIXED</option>
                <option value="PERCENT">PERCENT</option>
			</select>
            <label>Amount</label>
			<input type="text" name="amount_id" value="0.00" id="amount_id" />    
		</div>
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
    <div class="tblcss" id="view_cgw_accumulator" style="height:300px; overflow:auto;"></div>