<script type="application/javascript">
	$(document).ready(function() {
		createDropDown('SubscriptionGroupID', 'modules/cgw/getSubscriptionGroupIDForRatePlan',null,'--SELECT--','');
		pagination("cgw_statewisemsg",["FromState","ToState","Msg","URL"],"report/view_cgw_generalSettings",null,null);
		
		$("#submit").click(function() {
			save_cgw_statewisemsg();
		});
	});
</script>
	<h1>CGW : State-wise Message</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">CGW</a></li>
			<li><a href="#">State-wise Message</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="action_id" value="" id="action_id" />
            
            <label>From State</label>
			<input type="text" name="FromState" value="" id="FromState" />
			<label>To State</label>
            <input type="text" name="ToState" value="" id="ToState" />
			
            <label>Message</label>
            <input type="text" name="Msg" value="" id="Msg" />
			<label>URL</label>
            <input type="text" name="URL" value="" id="URL" />
			<label>NotificationStatus</label>
            <input type="text" name="NotificationStatus" value="" id="NotificationStatus" />
			<label>SubscriptionGroupID</label>
            <select id="SubscriptionGroupID" name="SubscriptionGroupID"></select>
             
		</div>
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
    <div class="tblcss" id="view_cgw_statewisemsg" style="height:300px; overflow:auto;"></div>