<h1>CMS : Admin Panel</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">CMS</a></li>
			<li><a href="#">Admin Panel</a></li>
            <li><a href="#">User Administration</a></li>
            <li><a href="#">Account Manager</a></li>
        </ul>
	</div>
	<div class="content">
      <div class="halfpan fl">
         	<h2>Account Manager</h2>
            <input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="action_id" value="" id="action_id" />
          	<label>Name</label>
            <input name="name" id="name" type="text"  />
            <label>Email Address</label>
            <input name="email" id="email" type="text"  />
            <label>User Name</label>
            <input name="user_name" id="user_name" type="text"  />
         
            <label>Password</label>
            <input name="password" id="password" type="password"  />
            <label>CP ID</label>
            <select  name="cpid" id="cpid" ></select> 
            <input type="button" value="Submit" id="update"/>
        </div>
     </div>
    <div class="tblcss" id="view_tbl_cms_account" style="height:1048px; overflow:auto;"></div>

<script>
function loadContentProviderList()
{
	var list=load_list("modules/cms/getcontentprovider",null);
	$("#cpid").empty().html(list);
}
$(document).ready(function(){
	 	loadContentProviderList();
		$("#update").click(function(){
			save_account_manager_data();
			loadContentProviderList();
		});	
		pagination("tbl_cms_account",["name","email","user_name"],"report/view_page",null,null);
});
</script>
