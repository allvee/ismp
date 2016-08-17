<script type="application/javascript">
	$(document).ready(function() {
		createDropDown('SubscriptionGroupID', 'modules/cgw/getSubscriptionGroupIDForRatePlan',null,'--Select--',' ');
		createDropDown('ToSubscriptionGroupID', 'modules/cgw/getSubscriptionGroupIDForRatePlan',null,'--Select--',' ');
		//createDropDownForSubscriptionGroupID();
		//createDropDownForToSubscriptionGroupID();
		
		pagination("cgw_rc_servicePromo",["id","SubscriptionGroupID","ToSubscriptionGroupID","ToStatus","ActivationStart","ActivationEnd","Status","Ano"],"report/view_page",null,null);
		
		$("#submit").click(function() { 
			save_cgw_rc_servicePromo();
		});
		
		$('#ActivationStart').datetimepicker({
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true
		});	
		
		$('#ActivationEnd').datetimepicker({
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true
		});	
		
	});
	/*
	function createDropDownForSubscriptionGroupID()
	{
		var $select = $("#SubscriptionGroupID");
	    $select.html("");
	  
	    var $sel = $("<option/>");
	        $sel.val("");
	        $sel.text("--Select--");
	        $select.append($sel);
		var return_val_arr = restore_fields("modules/cgw/getSubscriptionGroupID",null);
		var obj = jQuery.parseJSON( return_val_arr );	
	    $.each(obj,function(key, value){
			var $o = $("<option/>");
	        $o.val(value);
	        $o.text(key);
	        $select.append($o);
		});
		
	}
	
	function createDropDownForToSubscriptionGroupID()
	{
		var $select = $("#ToSubscriptionGroupID");
	    $select.html("");
	  
	    var $sel = $("<option/>");
	        $sel.val("");
	        $sel.text("--Select--");
	        $select.append($sel);
		var return_val_arr = restore_fields("modules/cgw/getToSubscriptionGroupID",null);
		var obj = jQuery.parseJSON( return_val_arr );	
	    $.each(obj,function(key, value){
			var $o = $("<option/>");
	        $o.val(value);
	        $o.text(key);
	        $select.append($o);
		});
		
	}*/
</script>
	<h1>CGW : Rate Configuration : Service Promo</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">CGW</a></li>
			<li><a href="#">Rate Configuration</a></li>
			<li><a href="#">Service Promo</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="id" value="" id="action_id" />
            <input type="hidden" name="userId" id="userId" value="<?php echo $_SESSION['USER_ID']; ?>"/>
            
            <label>Subscription Group ID</label>
				<select id="SubscriptionGroupID" name="SubscriptionGroupID">
				</select>
			<label>To Subscription Group ID</label>
				<select id="ToSubscriptionGroupID" name="ToSubscriptionGroupID">
				</select>
			 <label>To Status </label>
            <select name="ToStatus" id="ToStatus">
            	<option value="Downgraded">Downgraded</option>
                <option value="InGracePeriod">InGracePeriod</option>
                <option value="Registered">Registered</option>
                <option value="RenewalFailed">RenewalFailed</option>
            </select>
			<label>Activation Start </label>
				<input name="ActivationStart" type="text"  id="ActivationStart" style="width:245px;"/>
			<label>Activation End </label>
				<input name="ActivationEnd" type="text"  id="ActivationEnd" style="width:245px;"/>
			<label>Status </label>
			<select id="Status" name="Status">
            	<option value="Active">Active</option>
                <option value="Provision">Provision</option>
                <option value="InActive">InActive</option>
           </select>
           	<label>ANO </label>
				<input type="text" name="Ano" value="" id="Ano" style="width:245px;"/>
		</div>
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
    <div class="tblcss" id="view_cgw_rc_servicePromo" style="height:300px; overflow:auto;"></div>