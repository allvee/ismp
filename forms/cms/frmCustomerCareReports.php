<h1>CMS : Customer Support </h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">CMS</a></li>
			<li><a href="#">Customer Support</a></li>
        </ul>
	</div>
	<div class="content">
   
      <div class="halfpan fl">
          <h2> Customer Support</h2>
          <label>MSISDN</label>
          <input name="msisdn" id="msisdn" type="text"  />
          <label>Short Codes</label>
          <input name="short_code" id="short_code" type="text" onkeyPress="return numeralsOnly(event)" />
 		  <label>Start Date</label>
          <input name="start_date" id="start_date" type="text"  />
           <label>End Date</label>
          <input name="end_date" id="end_date" type="text"  />
          
          <input type="button" value="Generate" id="submit" />
       </div>
      
       <div class="subsection" id="view_customer_list" style="height:1048px; overflow:auto;">
  		<h2>Subscription Service Status</h2>
        <table class="tblcss subtbl" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tbody>
            <tr>
                <td>Service Name</td>
                <td>Port Registered</td>
                <td>Registration Date</td>
                <td>Deregistration Date</td>
                <td>Activation Channel</td>
                <td>Charging Plan</td>
                <td>Status</td>
            </tr>
            <tr>
                <td>Sports</td><td>2002</td><td>20 May 2014<br>22:15:25</td>
                <td>22 May 2014<br>22:15:25</td>
                <td>IVR</td>
                <td>Sportsmontly (15.00tk)</td>
                <td>
                <a href="#">Active</a>
                </td>
            </tr>
            <tr>
                <td>Sports</td>
                <td>2002</td>
                <td>
                20 May 2014
                <br>
                22:15:25
                </td>
                <td>
                22May 2014
                <br>
                22:15:25
                </td>
                <td>IVR</td>
                <td>Sportsmontly (15.00tk)</td>
                <td>
                <a href="#">Active</a>
                </td>
            </tr>
        </tbody>
        </table>
        
        <br/>
        <h2>Call Details</h2>
        <table class="tblcss subtbl" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tbody>
                <tr>
                <td>Unique ID</td>
                <td>MSISDN</td>
                <td>Port</td>
                <td>Service Name</td>
                <td>Start time</td>
                <td>End time</td>
                <td>Duration (hh:mm:ss)</td>
                </tr>
                <tr>
                <td>Unique ID</td>
                <td>MSISDN</td>
                <td>Port</td>
                <td>Service Name</td>
                <td>Start time</td>
                <td>End time</td>
                <td>Duration (hh:mm:ss)</td>
                </tr>
            </tbody>
        </table>
        <br/>
        <h2>SMS Details</h2>
        <table class="tblcss subtbl" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tbody>
                <tr>
                <td>MO</td>
                <td>MT</td>
                <td>SMS Time</td>
                <td>SMS Content</td>
                </tr>
                               <tr>
                <td>MO</td>
                <td>MT</td>
                <td>SMS Time</td>
                <td>SMS Content</td>
                </tr>

            </tbody>
        </table>
        

</div>


</div>
  
<script>
$(document).ready(function() {
		
	$('#start_date,#end_date').datetimepicker({
				format:			'Y-m-d',
				timepicker:false
		});

	
	$("#submit").click(function(){
		
		var list=restore_fields("modules/cms/show_customer_report",['msisdn','short_code','start_date','end_date']);
		$("#view_customer_list").html(list);
		
	});
		 
});
</script>

