<h1>User Administration : Role Manager</h1>
	<div class="breadcrumb">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">CMS</a></li>
            <li><a href="#">Admin Panel</a></li>
            <li><a href="#">User Administration</a></li>
        </ul>
	</div>
	<div class="content">
		<div class="halfpan fl">
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="id" value="" id="action_id" />
            <label>Name </label>
			<input type="text" name="rolename" value="" id="rolename" />
		</div>
		<div class="btnarea"><input type="button" value="Submit" id="submit" />
		</div>
	</div>
    <div class="tblcss" id="view_role_manager" style="height:1048px; overflow:auto;"></div>
<script type="application/javascript">
function save_cms_role_manager()
{
	var action = get_value("#action");
	var action_id = null;
	if(action == "update"){
		action_id = get_value("#action_id");
	}
	var value_arr = {};
	value_arr["rolename"] = "#rolename";
	var required_arr = ["rolename"];
	
	save_files(action,action_id,"modules/cms/submit_role_manager",value_arr,required_arr,"role_manager","report/view_page",null,null);
	set_value("action","insert",selector_type_id);
}
	
$(document).ready(function(){
	$("#submit").click(function() { 
		save_cms_role_manager();
	});
	pagination("role_manager",["rolename"],"report/view_page",null,null);
});
</script>