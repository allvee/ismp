<script type="application/javascript">
	$(document).ready(function() {
		
		pagination("cgw_callType",["call_type_id","ano","bno"],"report/view_page",null,null);
		
		$("#submit").click(function() {
			save_cgw_callType();
		});
		
		$("#call_type_id").blur(function() {
			var action = get_value("#action");
			var callTypeIdVal = get_value("#call_type_id");
			if(action == "update"){
				//action_id = get_value("#action_id");
				action_id = get_value("#callTypeIdHidden");
				if(action_id != callTypeIdVal && newCallTypeExists(callTypeIdVal))
				{
					$("#call_type_id").val(action_id);
					alert("Update Unsuccessful. New Call Type Id already exists");
					return;
				}
			}
			else
			{
				if(newCallTypeExists(callTypeIdVal))
				{
					alert("Insert Unsuccessful. New Call Type Id already exists");
					return;
				}
			}
		});
	});
</script>
	<h1>CGW : Rate Configuration : Rate Plan Management : Call Type</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">CGW</a></li>
			<li><a href="#">Rate Configuration</a></li>
			<li><a href="#">Rate Plan Management</a></li>
			<li><a href="#">Call Type</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="id" value="" id="action_id" />
            <input type="hidden" name="callTypeIdHidden" value="" id="callTypeIdHidden" />
            <input type="hidden" name="userId" id="userId" value="<?php echo $_SESSION['USER_ID']; ?>"/>
            
            <label>Call Type Id </label>
			<input type="text" name="call_type_id" value="" id="call_type_id" />
			<label>ANO </label>
			<input type="text" name="ano" value="" id="ano" />
			<label>BNO </label>
			<input type="text" name="bno" value="" id="bno" />
		</div>
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
    <div class="tblcss" id="view_cgw_callType" style="height:300px; overflow:auto;"></div>