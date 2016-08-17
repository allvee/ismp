<script type="application/javascript">
	$(document).ready(function() {
		
		pagination("cgw_timeSlot",["TimeSlotID","StartDay","EndDay","StartTime","EndTime"],"report/view_page",null,null);
		
		$("#submit").click(function() {
			//alert("submit"); 
			save_cgw_timeSlot();
		});
		
		$("#TimeSlotID").blur(function() {
			var action = get_value("#action");
			var timeSlotIdVal = get_value("#TimeSlotID");
			if(action == "update"){
				//action_id = get_value("#action_id");
				action_id = get_value("#timeSlotIdHidden");
				if(action_id != timeSlotIdVal && newTimeSlotExists(timeSlotIdVal))
				{
					$("#TimeSlotID").val(action_id);
					alert("Update Unsuccessful. New Time Slot Id already exists");
					return;
				}
			}
			else
			{
				if(newTimeSlotExists(timeSlotIdVal))
				{
					alert("Insert Unsuccessful. New Time Slot Id already exists");
					return;
				}
			}
		});
		
		
		$('#StartTime').datetimepicker({
                datepicker:false,
                timepicker:true,
				format: 'h:i A',
				formatTime: 'h:i A',
				step:30
		});	
		$('#EndTime').datetimepicker({
				datepicker:false,
                timepicker:true,
				format: 'h:i A',
				formatTime: 'h:i A',
				step:30
		});	
		
		//$('#StartTime').timepicker();
		//$('#EndTime').timepicker();	
	});
</script>
	<h1>OBD : Time Slot</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">OBD</a></li>
			<li><a href="#">Time Slot</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="id" value="" id="action_id" />
            <input type="hidden" name="timeSlotIdHidden" value="" id="timeSlotIdHidden" />
            <input type="hidden" name="userId" id="userId" value="<?php echo $_SESSION['USER_ID']; ?>"/>
            
            <label>Time Slot Id </label>
			<input type="text" name="TimeSlotID" value="" id="TimeSlotID" />
			<label>Start Day </label>
			<select id="StartDay" name="StartDay">
            	<option value="0">Sunday</option>
                <option value="1">Monday</option>
                <option value="2">Tuesday</option>
                <option value="3">Wednesday</option>
                <option value="4">Thursday</option>
                <option value="5">Friday</option>
                <option value="6">Satday</option>
           </select>
		   <label>End Day </label>
		   <select id="EndDay" name="EndDay">
            	<option value="0">Sunday</option>
                <option value="1">Monday</option>
                <option value="2">Tuesday</option>
                <option value="3">Wednesday</option>
                <option value="4">Thursday</option>
                <option value="5">Friday</option>
                <option value="6">Satday</option>
           </select>
           <label>Start Time</label>
		   <input name="StartTime" type="text"  id="StartTime" value=""/>
		   <label>End Time</label>
		   <input name="EndTime" type="text"  id="EndTime" value=""/>
		   <input name="StartTime" type="hidden"  id="StartTimehidden" value=""/>
		   <input name="EndTime" type="hidden"  id="EndTimehidden" value=""/>
		</div>
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
    <div class="tblcss" id="view_cgw_timeSlot" style="height:300px; overflow:auto;"></div>