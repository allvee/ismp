
<h1>User Administration: Account Manager</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">User Administration</a></li>
			<li><a href="#">Account Manager</a></li>
            
		</ul>
	</div>
	<div class="content">
      <div class="halfpan fl">
         <h2>User Setting</h2>
          <input type="hidden" name="action" value="insert" id="action" />
          <input type="hidden" name="action_id" value="" id="action_id" />
          <label>User ID</label>
          <input name="user_id" id="user_id" type="text"/>
          <label>User Name</label>
          <input name="user_name" id="user_name" type="text"/>
          <label>Email</label>
          <input name="email" id="email" type="text"/>
         
          <label>Password</label>
          <input name="password" id="password" type="password"/>
          
          <label>Role Name</label>
          <select  name="role_id" id="role_id"></select> 
          <label>CP</label>
		  <select name="cp" id="cp"></select>
          <label>User Image</label>
          <input name="file" id="file" type="file" value="" />
          <input type="button" value="Submit" id="update"/>
          
          
         
      </div>
     </div>
    <div class="tblcss" id="view_tbl_user" style="height:1048px; overflow:auto;"></div>

<script>
function reload_role()
{
	var list=load_list("modules/cms/get_roles",null);
	$("#role_id").html(list);
}
function reload_cp(){
    var cp_list = load_list("modules/cms/get_all_cp",null);
    $("#cp").html(cp_list);
}
function UserExist()
{
	 return restore_fields("modules/cms/user_exist",["user_id"]);
}
$(document).ready(function(){
	  reload_role();
	  createDropDown("cp", "modules/cms/get_all_cp", null, "Select", "0");
	  pagination("tbl_user",null,"report/view_page",null,null);
	  $("#update").click(function(){
		  
		    if(get_value("#action")=="insert")
			{
				if(UserExist()==0){
					alert("User Exist with the same ID");	
					return;
				}
			}
			
			save_user_data();
	  });	
	  
	  $("#user_id").blur(function(){
		  		if(UserExist()==0)alert("User Exist with the same User ID");
	   });
	   
	  
});
</script>





