<h1>CMS : Content Permission </h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">CMS</a></li>
			<li><a href="#">User Panel</a></li>
            <li><a href="#">Content Permission</a></li>
		</ul>
	</div>
	<div class="content">
      <input id="current_src_holder" type="hidden" value="" />
      <div id="playfile" title="Play your file" style="display:none">
            <audio style = "position:relative;top:15%;left:15%;width:200px;height:30px;"  id = "audio_id" controls>
  				<source id = "play" src="" type="audio/wav"/>
 
				Your browser does not support the audio element.
			</audio>
       </div>
    	<label>Content</label>
        <input name="cname" id="cname" type="text"  />
        <!--<label>Status</label>
        <select  name="status" id="status" >
        	<option value="all">All</option>
            <option value="pending">Pending</option>
            <option value="accepted">Accepted</option>
            <option value="rejected">Rejected</option>
        </select> -->
        <input type="button" value="Search" id="submit" />
    </div>
  
    <div class="tblcss" id="view_content_permission" style="overflow:auto;"></div>
<script>

 $("#playfile").dialog({
            position:{ my: "center", at: "center", of: window },
			widht: 1000,
			height:200,
            autoOpen: false,
            hide: "puff",
            show: "slide",
            modal: true,
            open: function(event, ui) {
               
                

                console.log("Triggered when dialog is created");
            },
            buttons: [{
                    	text: "Cancel",
                    	click: function() {
                        			
									$(this).dialog("close");
									console.log("Cancel button is clicked");
                    		}
                	}, 
				
					{
                    	text: "OK",
                    	click: function() {
                       
					   	$(this).dialog("close");
                       	console.log("Ok button is clicked");

                    }
                }

            ]

        });

	$(document).ready(function(){
		pagination("content_permission",null,"report/view_cms_permission");  
		
		$("#submit").click(function(){
			var param_arr = {};
			param_arr["content_name"] = "cname";
		//	param_arr["status"] = "status";
			pagination("content_permission",null,"report/view_cms_permission",null,null,param_arr);
		});	   
	});
</script>

