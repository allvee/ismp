
<script src="../../js/jquery-1.8.0.min.js" ></script>
<script src="../../js/jquery.datetimepicker.js" ></script> 
<link type="text/css" href="../../css/jquery.datetimepicker.css"/>
<script>
   
</script>

<h1>Customer Support: customer support </h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Customer Support</a></li>
			<li><a href="#">Customer support</a></li>
            
		</ul>
	</div>
	<div class="content">
      <div class="halfpan fl">
         <h2> Customer Support</h2>
         
          <input type="hidden" name="action" value="insert" id="action"/>
          <input type="hidden" name="action_id" value="" id="action_id"/>
        
          <label>MSISDN </label>
          <input name="msisdn" id="msisdn" type="text"/>
          <label>Short Codes </label>
          <input name="shcodec" id="shcodec" type="text"/>
 
         
          <label>Start Date</label>
          <input name="startdate" id="startdate" type="text"/>
          <label>End Date </label>
          <input name="enddate" id="enddate" type="text"/>
          
    <!--      <select multiple id="operator" size="5" >
                          <option value="volvo">Volvo</option>
                          <option value="saab">Saab</option>
                          <option value="opel">Opel</option>
                          <option value="audi">Audi</option>
                           <option value="volvo">Human</option>
                          <option value="saab">Baron</option>
                          <option value="opel">OpelGL</option>
                          <option value="audi">OpenNL</option>
		  </select>   -->
          
          
          
          <input type="button" value="Generate" id="submit"/>
         
         
      </div>
     </div>
    <div class="tblcss" id="view_content_list" style="height:1048px; overflow:auto;"></div>
<script>
$(document).ready(function(){
	
	
	jQuery('#startdate,#enddate').datetimepicker({
			format: 'Y/m/d H:i:i',
            formatTime: 'H:i:i', // means increment with step
            formatDate: 'Y/m/d',
			step:1,
			yearStart:1800,
            yearEnd:2250
		}); 
		
});
</script>

