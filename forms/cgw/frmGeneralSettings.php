<script type="application/javascript">
	$(document).ready(function() {

		pagination("cgw_generalSettings",["id","pName","pValue"],"report/view_cgw_generalSettings",null,null);
		
		$("#submit").click(function() { 
			save_cgw_generalSettings();
		});

		
	});

</script>
	<h1>CGW : Rate Configuration : General Setting</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">CGW</a></li>
			<li><a href="#">Rate Configuration</a></li>
			<li><a href="#">General Setting</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="pName" value="" id="action_id" />
            <input type="hidden" name="userId" id="userId" value="<?php echo $_SESSION['USER_ID']; ?>"/>
            

           	<label>Name </label>
				<input type="text" name="pName" value="" id="pName"/>
			<label>Value </label>
				<input type="text" name="pValue" value="" id="pValue"/>
		</div>
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
    <div class="tblcss" id="view_cgw_generalSettings" style="height:300px; overflow:auto;"></div>