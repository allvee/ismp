<script type="application/javascript">
	$(document).ready(function(){
		createDropDown('ParentID','modules/cgw/getOriginalSubscriptionGroupID', null, 'Root','Root');
		createDropDown('OriginalSubscriptionGroupID','modules/cgw/getOriginalSubscriptionGroupID', null, 'NA','Null');
		createDropDown('cp_id', 'modules/cms/get_all_cp', null, 'NA','');
		
		$("#submit").click(function() {
			save_cgw_rc_sg();
		});
	});

</script>
	<h1>CGW : Rate Configuration : Subscription Group : Add</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">CGW</a></li>
			<li><a href="#">Rate Configuration</a></li>
			<li><a href="#">Subscription Group</a></li>
			<li><a href="#">Add</a></li>
		</ul>
	</div>
	<div class="content">
		
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="id" value="" id="action_id" />
            <input type="hidden" name="userId" id="userId" value="<?php echo $_SESSION['USER_ID']; ?>"/>
            
            <label>Subscription Group ID</label>
				<input name="SubscriptionGroupID" type="text"  id="SubscriptionGroupID" maxlength="50" style="width:525px;"/>
			<label>Parent</label>
				<select id="ParentID" name="ParentID">
				</select>
		    <label>CMS Service ID</label>
				<input name="CMSSeviceID" type="text"  id="CMSSeviceID" style="width:525px;"/>
		    <label>Service ID</label>
				<input name="ServiceID" type="text"  id="ServiceID" style="width:525px;"/>
		    <label>Service Duration</label>
				<input name="ServiceDuration" type="text"  id="ServiceDuration" style="width:525px;"/>				
		    <label>Grace Period</label>
				<input name="GracePeriod" type="text"  id="GracePeriod" style="width:525px;"/>
			<label>Allow Downgrade </label>
			<select id="AllowDowngrade" name="AllowDowngrade">
            	<option value=Null>NA</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
           </select>				
            <label>BNI</label>
				<input name="BNI" type="text"  id="BNI" style="width:525px;"/>
            <label>Free Service Period</label>
				<input name="FreeServicePeriod" type="text"  id="FreeServicePeriod"  style="width:525px;"/>
			<label>Original Subscription Group </label>
				<select id="OriginalSubscriptionGroupID" name="OriginalSubscriptionGroupID">
				</select>
            <label>Retry Renewal Period</label>
				<input name="RetryRenewalPeriod" type="text"  id="RetryRenewalPeriod" style="width:525px;"/>
            <label>Retry Renewal Interval Minutes</label>
				<input name="RetryRenewalIntervalMinutes" type="text"  id="RetryRenewalIntervalMinutes" style="width:525px;"/>
            <label>Renew Notification Days</label>
				<input name="RenewNotificationDays" type="text"  id="RenewNotificationDays" style="width:525px;"/>
            <label>Renew Notification URL</label>
				<input name="RenewNotificationURL" type="text"  id="RenewNotificationURL" style="width:525px;"/>
			<label>Has balance option </label>
			<select id="has_balance_option" name="has_balance_option">
                <option value="1">Yes</option>
                <option value="0">No</option>
           </select>
            <label>Initial balance</label>
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