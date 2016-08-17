<script type="application/javascript">
	$(document).ready(function() {
		get_sgw_channel_map("+");
		$("#no_of_channel_map").keyup(function() {
            StepIncrease();
        });
		
		$("#submit").click(function() { 
			save_sgw_channel_map();
		});
		
		$("#channel_map_status").change(function() {
            view_channel_map_status();
        });
	});
</script>
	<h1>SGW : Channel Map</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">SGW</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
            <label>Signaling Protocol</label>
            <input type="text" name="sgw_protocol" value="" id="sgw_protocol"/>
            <label>Channel Map Enable </label>
            <select name="channel_map_status" id="channel_map_status">
            	<option value="yes">YES</option>
                <option value="no">NO</option>
            </select>
            <div class="clear"></div>
            <div id="channel_map_no">
            	<label>No of Channel Map </label>
            	<input type="text" name="no_of_channel_map" value="0" id="no_of_channel_map" />
            </div>
            <div id="channel_map_package"></div>
		</div>
		<div class="clear"></div>
		<div class="btnarea">
            <input type="button" value="Submit" id="submit" />
        </div>
	</div>