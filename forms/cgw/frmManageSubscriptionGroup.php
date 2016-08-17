<script type="application/javascript">

function update_all_drop_down()
{
	createDropDownForSubscriptionGroupID('ParentID', 'Root','Root');
	createDropDownForSubscriptionGroupID('OriginalSubscriptionGroupID', 'NA','Null');
	createDropDownForSubscriptionGroupID('SubscriptionGroupIDSearch', '--Search--',' ');
}
	$(document).ready(function() {
		$('#SubscriptionGroupID').attr("disabled", true); 
		
		createDropDownForSubscriptionGroupID('ParentID', 'Root','Root');
		createDropDownForSubscriptionGroupID('OriginalSubscriptionGroupID', 'NA','Null');
		createDropDownForSubscriptionGroupID('SubscriptionGroupIDSearch', '--Search--',' ');
		createDropDown('cp_id', 'modules/cms/get_all_cp', null, 'NA','');
		show_hide(null,contentId);
		
		$("#submit").click(function() {
			save_cgw_rc_sg();
			update_all_drop_down();
			show_hide(null,contentId);
		});
		
		$("#search").click(function() { 
			show_hide(null,contentId);
			pagination("cgw_rc_sg",["id","SubscriptionGroupID","ParentID","CMSSeviceID","ServiceDuration","GracePeriod","AllowDowngrade","BNI","FreeServicePeriod","OriginalSubscriptionGroupID","RetryRenewalPeriod","RetryRenewalIntervalMinutes","RenewNotificationDays","RenewNotificationURL","has_balance_option","initial_balance"],"report/view_cgw_rc_sg",null,null,["SubscriptionGroupIDSearch"],null);
		});
		
		$("#showPanel").click(function() {
			var contentIdValue =$("#contentId").val();
			show_hide(contentId,null);
		});	
		
		$("#hidePanel").click(function() {
			var contentIdValue =$("#contentId").val();
			show_hide(null,contentId);
		});		
		
	});
	
	function createDropDownForSubscriptionGroupID(selectId, firstText, firstValue)
	{
		var $select = $("#"+selectId);
	    $select.html("");
	  
	    var $sel = $("<option/>");
	        $sel.val(firstValue);
	        $sel.text(firstText);
	        $select.append($sel);
		var return_val_arr = restore_fields("modules/cgw/getOriginalSubscriptionGroupID",null);
		var obj = jQuery.parseJSON( return_val_arr );	
	    $.each(obj,function(key, value){
			var $o = $("<option/>");
	        $o.val(value);
	        $o.text(key);
	        $select.append($o);
		});
		
	}

</script>
	<h1>CGW : Rate Configuration : Subscription Group : Manage</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">CGW</a></li>
			<li><a href="#">Rate Configuration</a></li>
			<li><a href="#">Subscription Group</a></li>
			<li><a href="#">Manage</a></li>
		</ul>
	</div>
	<div class="searchPanel">
		<label>Subscription Group ID    </label>
			<select id="SubscriptionGroupIDSearch" name="SubscriptionGroupIDSearch">
			</select>
		<input type="button" value="Search" id="search" />
		
	<!--	<input type="button" value="Show" id="showPanel"/>
		<input type="button" value="Hide" id="hidePanel"/>-->
	</div>
	<div class="content" id="contentId">	
			<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="id" value="" id="action_id" />
            <input type="hidden" name="userId" id="userId" value="<?php echo $_SESSION['USER_ID']; ?>"/>
            
            <label>Subscription Group ID </label>
				<input name="SubscriptionGroupID" type="text"  id="SubscriptionGroupID"  style="width:525px;"/>
			<label>Parent</label>
				<select id="ParentID" name="ParentID">
				</select>
		    <label>CMS Sevice ID </label>
				<input name="CMSSeviceID" type="text"  id="CMSSeviceID" style="width:525px;"/>
		    <label>Service ID</label>
				<input name="ServiceID" type="text"  id="ServiceID" style="width:525px;"/>
            <label>Service Duration </label>
				<input name="ServiceDuration" type="text"  id="ServiceDuration" style="width:525px;"/>				
		    <label>Grace Period </label>
				<input name="GracePeriod" type="text"  id="GracePeriod" style="width:525px;"/>
			<label>Allow Downgrade </label>
			<select id="AllowDowngrade" name="AllowDowngrade">
            	<option value=Null>NA</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
           </select>				
            <label>BNI </label>
				<input name="BNI" type="text"  id="BNI" style="width:525px;"/>
            <label>Free Service Period </label>
				<input name="FreeServicePeriod" type="text"  id="FreeServicePeriod" style="width:525px;"/>
			<label>Original Subscription Group </label>
				<select id="OriginalSubscriptionGroupID" name="OriginalSubscriptionGroupID">
				</select>
            <label>Retry Renewal Period </label>
				<input name="RetryRenewalPeriod" type="text"  id="RetryRenewalPeriod" style="width:525px;"/>
            <label>Retry Renewal Interval Minutes </label>
				<input name="RetryRenewalIntervalMinutes" type="text"  id="RetryRenewalIntervalMinutes" style="width:525px;"/>
            <label>Renew Notification Days </label>
				<input name="RenewNotificationDays" type="text"  id="RenewNotificationDays" style="width:525px;"/>
            <label>Renew Notification URL </label>
				<input name="RenewNotificationURL" type="text"  id="RenewNotificationURL" style="width:525px;"/>
			<label>Has balance option </label>
			<select id="has_balance_option" name="has_balance_option">
                <option value="1">Yes</option>
                <option value="0">No</option>
           </select>
            <label>Initial balance </label>
				<input name="initial_balance" type="text"  id="initial_balance" style="width:525px;"/>
			<label>CP</label>
			<select name="cp_id" id="cp_id"></select>
            <label>Balance Type</label>
			<select name="wallettype" id="wallettype">
            	<option value="2">percall</option>
                <option value="1">serviceunit</option>
            </select>
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
	<div class="tblcss" id="view_cgw_rc_sg" style="height:300px; overflow:auto;"></div>