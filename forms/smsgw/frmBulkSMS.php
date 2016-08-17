<script type="application/javascript">
	$(document).ready(function() {
		createDropDown('timeslot_id','modules/cgw/getTimeSlotID',null, '--Search--',' ');


		showInitialLength(maskLength,11);
		showInitialLength(msgLength,160);
		createDropDown('template', 'modules/smsgw/getTemplate', null, '--Search--',' ');
		createDropDown('group_id', 'modules/smsgw/getContactGroupList', null, '--Search--',' ');
	
		$("#submit").click(function() {
			//alert("submit");
			var group_idValue =$("#group_id").val();
			var msgValue =$("#msg").val();
			var maskValue =$("#mask").val();
			submitForBulkSms(group_idValue,msgValue,maskValue);
		});
		
		$('#mask').keydown( function(e) {
			calStringLength(mask,11,maskLength);	
		});
		
		$('#msg').keydown( function(e) {
			calStringLength(msg,160,msgLength);
	
		});
		
		$('#mask').keyup( function(e) {
			calStringLength(mask,11,maskLength);
	
		});
		
		$('#msg').keyup( function(e) {
			calStringLength(msg,160,msgLength);
	
		});
		
		$("#template").change(function() 
        {
  			var templateValue =$("#template").val();
  			var initialMsg = $("#msg").val();
  			var totalMsg='';
  			
  			if(initialMsg != null && initialMsg !='')
  			{
  				totalMsg =initialMsg+' '+templateValue; 
  			}
  			else
  			{
  				totalMsg = templateValue;
  			}
  			$("#msg").val(totalMsg);
        });
	});
</script>
	<h1>SMSGW : SMS Service Configuration : Services : Bulk SMS </h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">SMSGW</a></li>
			<li><a href="#">SMS Service Configuration</a></li>
			<li><a href="#">Services</a></li>
			<li><a href="#">Bulk SMS</a></li>
		</ul>
	</div>
	<div class="content">
		<input type="hidden" name="action" value="insert" id="action" />
		<input type="hidden" name="userId" id="userId" value="<?php echo $_SESSION['USER_ID']; ?>"/>
		<input type="hidden" name="srcMN" value="" id="srcMN" />
		<input type="hidden" name="dstMN" value="" id="dstMN" />
		<input type="hidden" name="writeTime" value="" id="writeTime" />
		<input type="hidden" name="msgStatus" value="" id="msgStatus" />
		
		<label>Message </label>
		<table id="msgTableId" width="50%"><tbody><tr><td align="left" style="vertical-align: top; height: 100px" width="60%">
			<textarea class="txtarea" style="width: 258px;" rows="3" name="msg" id="msg" value=""></textarea>
		</td>
		<td width="40%">
			<label id="msgLength" value="" style="height: 45px; width: 300px;"/>
		</td></tr>
		</tbody></table>
		
		
		<label>Load Template </label>
			<select id="template" name="template" style="width: 265px;">
			</select>
				
		<label>Masking </label>
		<table id="maskTableId"><tbody><tr><td align="left" style="vertical-align: top;" width="50%">
			<input name="mask" type="text" value="" id="mask"  style="width: 256px;">
		</td>
		<td width="50%">
			<label id="maskLength" value="" style="height: 45px; width: 300px;"/>
		</td></tr></tbody></table>

		<label>Group </label>
			<select id="group_id" name="group_id" style="width: 265px;">
			</select>
		<label>Time Slot </label>
			<select id="timeslot_id" name="timeslot_id" style="width: 265px;" >
            	<!--<option value="anytime">Anytime</option>-->
                
			</select>	
		<div class="btnarea">
			<input name="submit" type="button" id="submit" value="Submit" />
		</div>
	</div>