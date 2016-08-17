<script type="application/javascript">
	$(document).ready(function() {
		createDropDown('group_id','modules/ussd/getContactGroupList',null, '--Search--',' ');
		createDropDown('flow_id','modules/ussd/getFlowList',null, '--Search--',' ');
		createDropDown('timeslot_id','modules/ussd/getTimeslotList',null, '--Search--',' ');
        
	});
</script>
	<h1>USSD : Blast</h1>
	<div class="content">
		
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="id" value="" id="action_id" />
            <input type="hidden" name="created_by" id="created_by" value="<?php echo $_SESSION['USER_ID']; ?>"/>
            <input type="hidden" name="last_updated" value="" id="last_updated" />
            <input type="hidden" name="dstMN" value="" id="dstMN" />
            
            <label>Flow </label>
				<select id="flow_id" name="flow_id">
				</select>
            
            <label>Group </label>
				<select id="group_id" name="group_id">
				</select>
                
            <label>Timeslot </label>
				<select id="timeslot_id" name="timeslot_id">
				</select>    
			
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>