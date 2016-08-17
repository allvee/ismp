<script type="text/javascript" src="js/jquery-1.4.4.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.3.custom.css"/>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>    
<script type="text/javascript" src="js/jquery.checkboxtree.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.checkboxtree.css"/>

<h1>User Administration :Menu Permission</h1>
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
        <input type="hidden" name="id" value="" id="action_id" />
        <label>Name</label>
        <select  name="roles_id" id="roles_id" ></select> 
     </div>
</div>
<div><p style="font-size:16px;">Check or Uncheck to change Menu Permission:</p></div>
<div class="tblcss" id="view_role_manager" style="overflow:auto;"></div>
<div class="content">
	<input style="top:-40px;left:-10px;" type="button" value="Submit" id="submit" />
    <input style="top:-40px;left:-10px;float:left" type="button" value="Select/Deselect All" id="sd_all" />
</div>
<script type="application/javascript">
function load_menu_list(){
	// get_all_menuinfo_with_respect_to_roleid
	var res = restore_fields("modules/cms/get_all_menu_info",["roles_id"]); 
	//res='<ul id="tree">'+res+'</ul>';
	$("#view_role_manager").html(res);
	$('#tree1').checkboxTree();
}
	
$(document).ready(function(){
		var list=load_list("modules/cms/get_role_name",null);
	    $("#roles_id").html(list);
		load_menu_list(); //initially load the menu list
		
		$("#roles_id").change(function() {
				load_menu_list();  
		});
			
		$("#submit").click(function(){
			var obj={};
			$('input[type="checkbox"]').each(function (index, currentObject) {
				if($(currentObject).is(':checked')) {
						obj[$(currentObject).attr('value')]='yes';
				}else{
					obj[$(currentObject).attr('value')]='no';
				}
			});
			obj['roles_id']=get_value("#roles_id");
			//console.log(obj);
			$.post("modules/cms/update_menu_permission.php",obj,
					function(response)
					{
						if(response==0){
							alert("Updated successfully!");
						}else{
							alert("Update Failed!");	
						}
					});
				
		});
			
		var state=true;
		$("#sd_all").click(function(){
				
			if(state==true){
				state=false;
				$('input[type="checkbox"]').attr('checked',true);
					// $('input[type="checkbox"]').prop('checked' , true); // this will work only in jquery version above 1.6
			}else{
				state=true;
				// $('input[type="checkbox"]').prop('checked' , false);
				$('input[type="checkbox"]').attr('checked',false);
			}
		});
});
</script>
 