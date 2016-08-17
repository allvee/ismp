<script type="application/javascript">
	$(document).ready(function() {
		
		pagination("smsgw_shortcode",["shortcode","ErrorSMS","DefaultKeyword"],"report/view_page",null,null);
		
		$("#submit").click(function() {
			//alert("submit"); 
			save_smsgw_shortcode();
		});
		
		$("#shortcode").blur(function() {
			var action = get_value("#action");
			var shortcodeVal = get_value("#shortcode");
			if(action == "update"){
				action_id = get_value("#shortcodeHidden");
				if(action_id != shortcodeVal && newShortCodeExists(shortcodeVal))
				{
					$("#shortcode").val(action_id);
					alert("Update Unsuccessful. New Shortcode already exists");
					return;
				}
			}
			else
			{
				if(newShortCodeExists(shortcodeVal))
				{
					alert("Insert Unsuccessful. New Shortcode already exists");
					return;
				}
			}
		});
	});
</script>
	<h1>SMSGW : SMS Service Configuration : Short Code</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">SMSGW</a></li>
			<li><a href="#">SMS Service Configuration</a></li>
			<li><a href="#">Short Code</a></li>
		</ul>
	</div>
	
	<div class="content">
		<div class="halfpan fl">
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="id" value="" id="action_id" />
            <input type="hidden" name="shortcodeHidden" value="" id="shortcodeHidden" />
            
            <label>Short Code </label>
				<input type="text" name="shortcode" value="" id="shortcode" />
			<label>Error SMS </label>
				<input type="text" name="ErrorSMS" value="" id="ErrorSMS" />
			<label>DefaultKeyword </label>
				<input type="text" name="DefaultKeyword" value="" id="DefaultKeyword" />
		</div>
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
    <div class="tblcss" id="view_smsgw_shortcode" style="height:300px; overflow:auto;"></div>