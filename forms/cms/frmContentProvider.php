
<h1>User Administration: CP Manager</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">User Administration</a></li>
			<li><a href="#">CP Manager</a></li>
            
		</ul>
	</div>
	<div class="content">
      <div class="halfpan fl">
         <h2>User Setting</h2>
          <input type="hidden" name="action" value="insert" id="action" />
          <input type="hidden" name="action_id" value="" id="action_id" />
          <label>CP Name</label>
          <input name="CPName" id="CPName" type="text"/>
          <label>Address</label>
          <input name="CPAddress" id="CPAddress" type="text"/>
         
          <input type="button" value="Submit" id="submit"/>
         
      </div>
     </div>
    <div class="tblcss" id="view_cp" style="height:600px; overflow:auto;"></div>

<script>
function save_cp_data(){
	var action = get_value("#action");
	var action_id = null;
	if(action == "update"){
		action_id = get_value("#action_id");
	}
	
	var value_arr = {};
	value_arr["CPID"] = "#CPName";
	value_arr["CPName"] = "#CPName";
	value_arr["CPAddress"] = "#CPAddress";
	
	save_files(action,action_id,"modules/cms/submit_cp",value_arr,null,"cp","report/view_page");
	set_value("action","insert",selector_type_id);
}

$(document).ready(function(){
	  pagination("cp",["CPName","CPAddress"],"report/view_page",null,null);
	  $("#submit").click(function(){
		  save_cp_data();
	  });	
	  
	  
});
</script>





