<script type="application/javascript">
	$(document).ready(function() {
		$("#submit_white").click(function() { 
			file_upload(true,"modules/obd/submit_obd_screening","white",null,["csv"]);
		});
		
		$("#submit_dnd").click(function() { 
			file_upload(true,"modules/obd/submit_obd_screening","dnd",null,["csv"]);
		});
	});
</script>
	<h1>OBD : Screening MSISDN</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">Call Handler</a></li>
            <li><a href="#">OBD</a></li>
		</ul>
	</div>
	<div class="content">
        <form method="post" action="modules/obd/submit_obd_screening.php" enctype="multipart/form-data">
            <div class="halfpan fl">
                <label>White List </label>
                <input name="white" type="file" id="white" />
                <div class="btnarea"><input type="button" value="Upload" id="submit_white" /></div>
                <br clear="all" />
                <label>DND List </label>
                <input name="dnd" type="file" id="dnd" />
                <div class="btnarea"><input type="button" value="Upload" id="submit_dnd" /></div>
            </div>
            <!--<div class="btnarea">
                <input type="button" value="Upload" id="submit" />
            </div>-->
            <!--<input type="submit" value="Get Distribution List " />-->
        </form>
    </div>