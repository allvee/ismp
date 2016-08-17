<script type="application/javascript">
	$(document).ready(function() {
		//load_list("modules/obd/getOBDServerInstances",null);
		createDropDown("server_id", "modules/obd/get_obd_dashboard_data");
		
		var list= load_obd_service_list("modules/obd/get_obd_service_list_v1",['server_id']);
		$("#service_id").html(list);
		
		$("#server_id").change(function() {
            
			var list= load_obd_service_list("modules/obd/get_obd_service_list_v1",['server_id']);
			$("#service_id").html(list);
        });
		
		$("#submit").click(function() { 
			var res=show_obd_dashboard();
			if(res==0)
			{
			    	$(".subsection").html("No Data Available");
			}else{
			       	$(".subsection").html(res);
			}		
        });
	});
</script>
	<h1>OBD : Dashboard </h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">Call Handler</a></li>
            <li><a href="#">OBD</a></li>
		</ul>
	</div>
	<div class="content">
      <div class="halfpan fl">
          <label>Target Server</label>
          <select  name="server_id" id="server_id"></select>
          <div class="clear"></div>
          <label>Service Name</label>
          <select name="service_id" id="service_id"></select>
           <div class="clear"></div>
          <input type="button" value="Submit" id="submit" />
      </div>
      <div id="view_obd_dashboard"></div>
       <!--<div class="subsection">
          <h2> Reporting Section</h2>
          <label>Target Server</label>
          <select  name="server_id" id="server_id"></select>
          <div class="clear"></div>
          <label>Service Name</label>
          <select name="service_name" id="service_name"></select>
           <div class="clear"></div>
          <input type="button" value="Submit" id="submit" />
        </div>-->
        <div class="subsection">
    
        </div>
    </div>