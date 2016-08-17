<script type="application/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
		$("#sgw_link_status").click(function() {
            get_maintainance("link","on");
        });
		
		$("#sgw_running_status").click(function() {
            get_maintainance("running","on");
        });
		
		$("#sgw_start").click(function() {
            get_maintainance("start","on");
        });
		
		$("#sgw_stop").click(function() {
            get_maintainance("stop","off");
        });
	});
</script>
	<h1>SGW : Maintenance</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">SGW</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
			<label>SGW Link Status</label>
            <a href="#inline1" class="fancybox" id="sgw_link_status"><input type="button" value="Log" /></a>
			<label>SGW Running Status</label>
			<a href="#inline1" class="fancybox" id="sgw_running_status"><input type="button"  value="Status" /></a>
			<label>Start SGW</label>
       		<a href="#inline1" class="fancybox" id="sgw_start"><input type="button"  value="Start" /></a>
			<label>Stop SGW</label>
			<a href="#inline1" class="fancybox2" id="sgw_stop"><input type="button"  value="Stop" /></a>
		</div>
		<div class="clear"></div>
        <input type="hidden" name="gateway" value="sgw" id="gateway" />
        <input type="hidden" name="status" value="" id="status" />
	</div>
    <div id="inline1" style="width:800px;display: none;"></div>