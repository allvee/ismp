<script type="application/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
		$("#sgw_link_status").click(function() {
			$("#inline1").empty();
            		get_maintainance("link","on");
        	});
		
		$("#sgw_running_status").click(function() {
			$("#inline1").empty();
            		get_maintainance("running","on");
        	});
		
		$("#sgw_start").click(function() {
			$("#inline1").empty();
              // get_maintainance("start","on");
                 var data="gateway=ch&status=start";
                 $.ajax({
        			type: "POST",
        			url: "modules/get_maintainance.php",
				data: data,
        			async: true,
        			success : function(res) {
            				//remote = res;
        			}
			});      
		});
		
		$("#sgw_stop").click(function() {
			$("#inline1").empty();
                  get_maintainance("stop","off");
        });
	});
</script>
	<h1>CH : Maintenance</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">CH</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
			<label>Call Handler Link Status</label>
            <a href="#inline1" class="fancybox" id="sgw_link_status"><input type="button" value="Log" /></a>
			<label>Call Handler Running Status</label>
			<a href="#inline1" class="fancybox" id="sgw_running_status"><input type="button"  value="Status" /></a>
			<label>Start Call Handler</label>
       		<a href="#inline1" class="fancybox" id="sgw_start"><input type="button"  value="Start" /></a>
			<label>Stop Call Handler</label>
			<a href="#inline1" class="fancybox2" id="sgw_stop"><input type="button"  value="Stop" /></a>
		</div>
		<div class="clear"></div>
        <input type="hidden" name="gateway" value="ch" id="gateway" />
        <input type="hidden" name="status" value="" id="status" />
	</div>
    <div id="inline1" style="min-width:200px;width:auto;height:auto;display: none;"></div>