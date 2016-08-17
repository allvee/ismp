
<h1>CMS: Remote File Upload</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">CMS</a></li>
			<li><a href="#">User Panel</a></li>
            <li><a href="#">CMS Report</a></li>
            <li><a href="#">Remote File Upload</a></li>
            
		</ul>
	</div>
	<div class="content">
      <div class="halfpan fl">
         <h2>Remote File Upload</h2>
          <input type="hidden" name="action" value="insert" id="action" />
          <input type="hidden" name="action_id" value="" id="action_id" />
         
          
          <label>User Image</label>
          <input name="file" id="file" type="file" value="" />
          
          <input type="button" value="Submit" id="submit"/>
          
          
         
      </div>
     </div>
    <div class="tblcss" id="view_tbl_user" style="height:1048px; overflow:auto;"></div>

<script>
function reload_role()
{
	var list=load_list("modules/cms/get_roles",null);
	$("#role_id").html(list);
}

function UserExist()
{
	 return restore_fields("modules/cms/user_exist",["user_id"]);
}
$(document).ready(function(){
	 // reload_role();
	 // pagination("tbl_user",null,"report/view_page",null,null);
	  $("#submit").click(function(){
		 
		// trigger,php_script_url,file_id,value_arr,supported_file_type,required_arr,tbl,callback_script,show_id,hide_id,progress_id 
		file_upload(true,"modules/cms/remote_file_upload","file",null,['png','jpg','jif'],null,null,null,null,null,null);
				
			
	  });	
	  
	
	   
	  
});
</script>





