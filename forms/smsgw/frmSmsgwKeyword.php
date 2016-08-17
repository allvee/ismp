  <script type="application/javascript">
	  $(document).ready(function() {
		
		  pagination("smsgw_keyword",["keyword","SMSText","SrcType","URL","ShortCode"],"report/view_page",null,null);
		
		  $("#submit_Keyword").click(function() {
			  //alert("submit"); 
			  save_smsgw_keyword();
		  });
		
		  $("#search_Keyword").click(function() {
			  //var search_array =[];
			  //search_array["kw_search_bar"]="kw_search_bar";
			  //search_array["kw_search_bar"]="kw_search_bar";
			  pagination("smsgw_keyword",["keyword","SMSText","SrcType","URL","ShortCode"],"report/view_page", null, null, ["kw_search_bar"], null );

			  });
			
			  //search_for_keyword();
			
		  /*$("#keyword").blur(function() {
			  var action = get_value("#action");
			  var keywordVal = get_value("#keyword");
			
			  if(action == "update"){
				  action_id = get_value("#keywordHidden");
				  if(action_id != keywordVal && newKeyExists(keywordVal))
				  {
					  $("#keyword").val(action_id);
					  alert("KeyWord already exists");
					  return;
				  }
			  }
			  else
			  {
				  if(newKeyExists(keywordVal))
				  {
					  alert("KeyWord already exists");
					  return;
				  }
			  }
		  });*/
	  });
  </script>
	  <h1>SMSGW : SMS Service Configuration : Keyword</h1>
	  <div class="breadcrumb">
		  <ul>
			  <li><a href="#">Home</a></li>
			  <li><a href="#">SMSGW</a></li>
			  <li><a href="#">SMS Service Configuration</a></li>
			  <li><a href="#">Keyword</a></li>
		  </ul>
	  </div>
	
	  <div class="content">
		  <div class="halfpan fl">
        	  <input type="hidden" name="action" value="insert" id="action" />
              <input type="hidden" name="id" value="" id="action_id" />
              <input type="hidden" name="keywordHidden" value="" id="keywordHidden" />
              <input type="hidden" name="HitCount" value="" id="HitCount" />
              <input type="hidden" name="LastHit" value="" id="LastHit" />
            
              <label>Short Code </label>
				  <input type="text" name="ShortCode" value="" id="ShortCode" />
              <label>Keyword </label>
				  <input type="text" name="keyword" value="" id="keyword" />
			  <label>SMS Text </label>
				  <input type="text" name="SMSText" value="" id="SMSText" />
			  <label>Source Type </label>
				  <!--<input type="text" name="SrcType" value="" id="SrcType" />-->
				  <select id="SrcType" name="SrcType" style="width:270px;">
	            	  <option value="SMS">SMS</option>
	                  <option value="URL">URL</option>
	           	  </select>
			  <label>URL</label>
				  <input type="text" name="URL" value="" id="URL" />
			
			  <label>Status </label>
				  <!--<input type="text" name="Status" value="" id="Status" />-->
				  <select id="Status" name="Status" style="width:270px;">
	            	  <option value="active">Active</option>
	                  <option value="inactive">Inactive</option>
	           	  </select>
		  </div>
		  <div class="clear"></div>
		  <div class="btnarea">
			  <input type="button" value="Submit" id="submit_Keyword" />
          </div>
        
        
		
       
  </div>

        <div class="searchPanel">
	  <!--
		  <label>Group </label>
				  <select id="group_id_search" name="group_id_search">
				  </select>-->
		  <label>Keyword   </label>
			  <input name="kw_search_bar" type="text" id="kw_search_bar" placeholder= "Search for Keywords" style="width:245px; text-align:center;"/>
		
		  <input type="button" value="Search" id="search_Keyword" />
	  </div>

	
      <div class="tblcss" id="view_smsgw_keyword" style="height:300px; overflow:auto;"></div>