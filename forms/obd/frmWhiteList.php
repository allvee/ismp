<style>
#view_dnd_list {
    color: #000000;
}
</style>

<script type="application/javascript">
	$(document).ready(function() {
		createDropDown("obdServerInstance", "modules/obd/getOBDServerInstances", null, "--Select--", "");
		pagination("white_list",["obdServerInstance"],"report/view_white_list",null,null);
		
		
		$("#submit").click(function() {
			var value_arr = {};
			value_arr["obdServerInstance"] = "#obdServerInstance";
			file_upload(true,"modules/obd/fileImportWhite","file",value_arr,["csv"],null,"white_list","report/view_white_list",null,null);
		});
			
	});

</script>

<h1>CMS : White List </h1>
<div class="breadcrumb">
	<ul>
		<li><a href="#">Home</a></li>
		<li><a href="#">CMS</a></li>
	</ul>
</div>
<div class="content">
	<div class="halfpan fl">
		<label>Select Instance</label>
		<select id="obdServerInstance" name="obdServerInstance">
		</select>
			<div class="clear"></div>
			<label> Browse</label>
			<input name="file" id="file" type="file" />
            
            <input type="checkbox" name="dnd_for" value="SMSGW">SMS GW
			<input type="checkbox" name="dnd_for" value="IVR">IVR  
        	<input type="checkbox" name="dnd_for" value="USSD">USSD<br />
			<div class="btnarea">
  				<input name="submit" type="button" id="submit" value="Submit" />
			</div>
			<input type="hidden" name="userId" id="userId" value="<?php echo $_SESSION['USER_ID']; ?>"/>
	</div>
</div>
<div class="subsection">
	<h2>Your Uploaded List</h2>
	<div class="tblcss" id="view_white_list" style="height:300px; overflow:auto;">
	</div>
</div>
	
	
	
	