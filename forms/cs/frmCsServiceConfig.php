  <script type="application/javascript">
	  $(document).ready(function() {
		
		  pagination("cs_service_config",["ServiceName","RegURL","DeregURL","BlockURL","UnblockURL"],"report/view_cs_service_config",null,null);
		
		  $("#submit_Keyword").click(function() {
			  //alert("submit"); 
			  save_cs_service_config();
		  });
	  });
  </script>
	
    
    
    
    <h1>Customer Support </h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">CMS</a></li>
			<li><a href="#">Customer Support</a></li>
        </ul>
	</div>
	
	  <div class="content">
		  <div class="halfpan fl">
        	  <input type="hidden" name="action" value="insert" id="action" />
              <input type="hidden" name="id" value="" id="action_id" />
              
            
              <label>Service Name </label>
				  <input type="text" name="ServiceName" value="" id="ServiceName" />
              <label>Register URL </label>
				  <input type="text" name="RegURL" value="" id="RegURL" />
			  <label>Deregister URL </label>
				  <input type="text" name="DeregURL" value="" id="DeregURL" />
                  
              <label>Block URL </label>
				  <input type="text" name="BlockURL" value="" id="BlockURL" />
			  <label>Unblock URL </label>
				  <input type="text" name="UnblockURL" value="" id="UnblockURL" />
			  
				  		  <div class="clear"></div>
		  <div class="btnarea">
			  <input type="button" value="Submit" id="submit_Keyword" />
          </div>
        
        
						  <div class="clear"></div>
        </br> </br>
       
  </div>

  </div>

	
      <div class="tblcss" id="view_cs_service_config" style="height:300px; overflow:auto;"></div>
      