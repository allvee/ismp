<style>
#view_dnd_list {
    color: #000000;
}
</style>

<script type="application/javascript">
var files;
	$(document).ready(function() {
		createDropDown('timeslot_id','modules/ussd/getTimeslotList',null, '--Search--',' ');
		
		createDropDown("obdServerInstance", "modules/obd/getOBDServerInstances", null, "--Select--", "");
		createDropDown("white_list", "modules/obd/get_white_list", null, "--Select--", "");
	
		//pagination("dnd_list",["date","time","opertor","total"],"report/view_dnd_list",null,null);
		
		
		$("#btnOBDUpload").click(function() { 
			var value_arr = {};
			value_arr["promptReplace"] = "#prompt_replace";
			value_arr["files"] = "uploadcalled";
			value_arr["server_id"] = "#serverID";
			value_arr["display_no"] = "#display_number";
			value_arr["original_no"] = "#original_number";
			value_arr["schedule_date"] = "#schedule_date";
			value_arr["service_id"] = "#service_name";
			value_arr["prompt_location"] = "#prompt_replace";
			value_arr["white_list"] = "#white_list";
			var msg = file_upload(true,"modules/obd/submit_obd_instance","file",value_arr,["wav"],["serverID","service_name","prompt_replace"]);
			//alert("btnOBDUpload click Enter");
			//uploadPrompt();
			//save_obd_instace_list();
					
        });
        
        $("#obdServerInstance").change(function(){
        	var serverID = $(this).val();
        	$("#serverID").val(serverID);  
			createDropDown("service_name", "modules/obd/get_service_promt_list", ["serverID"], "--Select--", "");
        });
        
        $("#service_name").change(function(){
        	var serviceName = $(this).val();
        	$("#serviceName").val(serviceName);  
			createDropDown("prompt_replace", "modules/obd/get_promt_replace_list", ["serverID", "serviceName"], "--Select--", "");
        });
        
        $('#schedule_date').datetimepicker({
                changeMonth: true,
                changeYear: true,
                showOtherMonths: true,
                selectOtherMonths: true
		});	
		// Add events
		$('input[type=file]').on('change', prepareUpload);		
	});
	
	function uploadPrompt()
	{
		//event.stopPropagation(); // Stop stuff happening
	    //event.preventDefault(); // Totally stop stuff happening
	 
	    // START A LOADING SPINNER HERE
	 
	 
	 	//Checking prompt replace value 
	 	
	 	var prompt_replaceVal = $("#prompt_replace");
	 	alert("prompt_replaceVal :"+prompt_replaceVal.val());
	    // Create a formdata object and add the files
		if(prompt_replaceVal.val() == null || prompt_replaceVal.val() =="")
		{
			alert("Prompt Replace not selected");
			return;
		}
		else
		{
			var data = new FormData();
			var isValidFile = true;
			$.each(files, function(key, value)
			{
				data.append(key, value);
				//alert("key :"+key+"; value :"+value.name.substring(value.name.length-4)+":"+value.name.length);
				if((value.name.substring(value.name.length-4)!=".wav") && (value.name.substring(value.name.length-4)!=".WAV"))
				{
					isValidFile = isValidFile & false;
				}
			});
			data.append("promptReplace",prompt_replaceVal.val());
		    if(isValidFile == false)
		    {
		    	alert("File format must be .wav");
		    	return;
		    }
		    else
		    {
		    	$.ajax({
		        url: 'forms/obd/uploadPrompt.php?files',
		        type: 'POST',
		        data: data,
		        cache: false,
		        dataType: 'json',
		        processData: false, // Don't process the files
		        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
		        success: function(data, textStatus, jqXHR)
		        {
		        	//saving data into db
		    		save_obd_instace_list();
		        	if(typeof data.error === 'undefined')
		        	{
		        		// Success so call function to process the form
		        		//submitForm(event, data);
		        	}
		        	else
		        	{
		        		// Handle errors here
		        		console.log('ERRORS: ' + data.error);
		        	}
		        },
		        error: function(jqXHR, textStatus, errorThrown)
		        {
		        	// Handle errors here
		        	console.log('ERRORS: ' + textStatus);
		        	// STOP LOADING SPINNER
		        }
		    	});
		    	//saving data into db
		    	//save_obd_instace_list();
		    }
		}

	}
	
	// Grab the files and set them to our variable
	function prepareUpload(event)
	{
	  files = event.target.files;
	}
</script>

	<h1>OBD : Upload Prompt </h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
            <li><a href="#">Call Handler</a></li>
            <li><a href="#">OBD</a></li>
            <li>Upload Prompt</li>
		</ul>
	</div>
		
	<div class="content">
			<div class="halfpan fl">
				<div class="clear"></div>
				<label> Browse </label>
				<input name="uploadFile" id="file" type="file" />
				<label>Original Number  </label>
				<input name="original_number" type="text" value="" id="original_number" />
				<label>Select Server</label>
				<select id="obdServerInstance" name="obdServerInstance">
				</select>
				<div class="clear"></div>
				<input type="hidden" name="serverID" value="" id="serverID" />
				<label>Prompt Replace  </label>
				<select id="prompt_replace" name="prompt_replace">
				</select>
                
                <label>Timeslot </label>
				<select id="timeslot_id" name="timeslot_id">
				</select>  
                
                
				<input type="hidden" name="promptReplace" value="" id="promptReplace" />
				<div class="clear"></div>
			</div>
			<div class="halfpan fr">
				<label>Display Number </label>
				<input name="display_number" type="text" value="" id="display_number" />
				<label>Schedule Date </label>
				<input name="schedule_date" type="text"  id="schedule_date"/>
				<label>Service Name </label>
				<select id="service_name" name="service_name">
				</select>
				<input type="hidden" name="serviceName" value="" id="serviceName" />
				<div class="clear"></div>
				<label>White List </label>
				<select id="white_list" name="white_list">
				</select>
				<div class="clear"></div>
			</div>
			<div class="btnarea">
					<input type="submit" id="btnOBDUpload" value="Upload" />
			</div>
	
	</div>
	
	
	
	