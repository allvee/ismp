<script type="application/javascript">
	
	function get_cgw_counter_info(){
		var return_val = restore_fields("modules/cgw/get_cgw_counter_info",["action_id"]);
		var obj = jQuery.parseJSON( return_val );
		
		$.each(obj,function(key, value){
			set_value(key,value,selector_type_id);
		});
	}
	
	function save_cgw_counter(){
		var action = get_value("#action");
		var action_id = get_value("#action_id");
		
		if(action=="insert"){
			var action_id =null;
		}
		
		var value_arr = {};
		value_arr["id"] = "#counter_id";
		value_arr["countertype"] = "#countertype";
		value_arr["aggtype"] = "#agg_type_id";
		value_arr["clause"] = "#clause_id";
		value_arr["value"] = "#value_id";
		value_arr["period"] = "#period_id";
		
		save_files(action,action_id,"modules/cgw/submit_cgw_counter",value_arr,null,null,null,null,null);
		set_value("action","insert",selector_type_id);
		pagination("cgw_counter",["counter_id","countertype","value_id"],"report/view_page",null,null);
	}	
	
	$(document).ready(function() {
		
		pagination("cgw_counter",["counter_id","countertype","value_id"],"report/view_page",null,null);
		
		$("#submit").click(function() {
			save_cgw_counter();
		});
	});
</script>
	<h1>CGW : Rate Configuration : Rate Plan Management : Counter</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">CGW</a></li>
			<li><a href="#">Rate Configuration</a></li>
			<li><a href="#">Rate Plan Management</a></li>
			<li><a href="#">Counter</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="id" value="" id="action_id" />
            <input type="hidden" name="counterHidden" value="" id="counterHidden" />
            <input type="hidden" name="userId" id="userId" value="<?php echo $_SESSION['USER_ID']; ?>"/>
            
            <label>Counter ID </label>
			<input type="text" name="counter_id" value="" id="counter_id" />
			<label>Counter Type</label>
            <select id="countertype" name="countertype">
                <option value="talktime">talktime</option>
                <option value="data">data</option>
                <option value="sms">sms</option>
			</select>
			<!--<input type="text" name="countertype" value="" id="countertype" />-->
			<label>AggType</label>
			<select id="agg_type_id" name="agg_type_id">
                <option value="COUNT">COUNT</option>
                <option value="SUM">SUM</option>
			</select>
            <label>Period</label>
			<select id="period_id" name="period_id">
                <option value="DAY">DAY</option>
                <option value="WEEK">WEEK</option>    
                <option value="MONTH">MONTH</option>
                <option value="YEAR">YEAR</option>             
			</select> 
			<label>Clause</label>
			<select id="clause_id" name="clause_id">
                <option value="=">=</option>
                <option value=">">></option>    
                <option value=">=">>=</option>
                <option value="<"><</option>    
                <option value="<="><=</option>            
			</select> 
            <label>Value </label>
			<input type="text" name="value_id" value="0.00" id="value_id" />    
		</div>
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
    <div class="tblcss" id="view_cgw_counter" style="height:300px; overflow:auto;"></div>