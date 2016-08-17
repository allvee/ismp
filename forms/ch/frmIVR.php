<script type="application/javascript">
	$(document).ready(function() {
		$("#submit").click(function() { 
			save_sgw_conf();
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
            <label>Channel Map Enable </label>
            <div class="inputreplace">
                 Yes <input name="channel_map_status" type="radio" value="yes" /> No <input name="" type="radio" value="no" />
            </div>
            <label>No of Channel Map </label>
            <input type="text" name="no_of_channel_map" value="" id="no_of_channel_map" />
            <label>DPC</label>
            <input type="text" name="dpc" value="" id="dpc" />
            <label>CIC </label>
            <input type="text" name="cic" value="" id="cic" />
            <label>Channel No </label>
            <input type="text" name="channel_no" value="" id="channel_no" />
            <label>No of Channels </label>
            <input type="text" name="no_of_channel" value="" id="no_of_channel" />
		</div>
		<div class="clear"></div>
		<div class="btnarea">
            <input type="button" value="Submit" id="submit" />
            <input type="button" value="Add New" class="color1" id="add_new" />
        </div>
	</div>