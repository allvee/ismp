<?php

session_start();
include("../commonlib.php");

$cn = connectDB();
//Receive passing data	
$edit_tbl = mysql_real_escape_string(htmlspecialchars($_REQUEST['tbl']));
$page = mysql_real_escape_string(htmlspecialchars($_REQUEST['page']));
$per_page = mysql_real_escape_string(htmlspecialchars($_REQUEST['per_page']));	

$user_id = $_SESSION['USER_ID'];
$ROLE_ID = $_SESSION['ROLE_ID'];
$CP_ID = $_SESSION['CP_ID'];


// Initialize 
$count_qry = "";
$content_arr = NULL;
$load_qry = "";
$key = '';
$editOption = false;
$deleteOption = false;
$extraBtn = false;
$extraBtnText = "";
$deleteBtnText = "Delete";
$editBtnTxt = "Edit";
$remoteCn = null;
$extraBtnCnd = array();	
//if($edit_tbl == "cs_service_config"){
    
	$count_qry = "select count(id) from `tbl_cs_service_config`";
	$content_arr = array("ID","Service Name", "Register URL", "Deregister URL", "Block URL", "Unblock URL");

	$load_qry = "select id,ServiceName,RegURL,DeregURL,BlockURL,UnblockURL from `tbl_cs_service_config`";
	
	$key = 'id';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
//}
	$options = array();
		$options['cn'] = $cn;
		$options['count_qry'] = $count_qry;
		$options['page'] = $page;
		$options['per_page'] = $per_page;
		$options['content_arr'] = $content_arr;
		$options['load_qry'] = $load_qry;
		$options['key'] = $key;
		$options['isEdit'] = $editOption;
		$options['edit_tbl'] = $edit_tbl;
		$options['isDelete'] = $deleteOption;	
		$options['extraBtn'] = $extraBtn;
		$options['extraBtnText'] = $extraBtnText;
		$options['deleteBtnText'] = $deleteBtnText;
		$options['editBtnTxt'] = $editBtnTxt;
        $options['extraBtnCondition '] = $extraBtnCnd;			
		
		pagination_all_page($options);
	
if($cn)ClosedDBConnection($cn);	
if($remoteCn)ClosedDBConnection($remoteCn);		
?>

	<script>
	
	$(document).ready(function() {
		
		
		function page_load(page,per_page){
			var tbl = "<?php echo $edit_tbl; ?>";
			var data = "page="+page+"&per_page="+per_page+"&tbl="+tbl;
			
				$.ajax({
					type: "POST",
					url: "report/view_cs_service_config.php",
					data: data,
					cache: false,
					success: function(response){
						$("#view_"+tbl).html(response);
					}
				});
		}
		
		
		$("#view_<?php echo $edit_tbl; ?> ul li a").click(function() {
			var id = $(this).attr("id");
			if(id == "#"){
				return false;
			}
				
			var id_arr = id.split("-");
			var page = id_arr[0];
			var per_page = id_arr[1];
				
			page_load(page,per_page);
		});
		
		$("#view_<?php echo $edit_tbl; ?> select.per_page").bind('change keyup',function() {
			var page = 1;
			var per_page = $("#view_<?php echo $edit_tbl; ?> select.per_page :selected").val();
				
			page_load(page,per_page);
		});
	
		// edit,delete operation
		$("#view_<?php echo $edit_tbl; ?> .action_post").click(function() {
			
			//$("#errorMsgSubnet,#errorMsgSubnetHost,#errorMsgSubnetRange").empty();
            var id = $(this).attr('id');
			var id_arr = id.split("|");
			var action = id_arr[0];
			var tbl = id_arr[1];
			var value = id_arr[2];
			
			if(action == "edit"){
				$("#action_id").val(value);
					get_user_data("modules/cs/get_cs_service_config",["action_id"]);
					set_value("action","update",selector_type_id);
				} 

			else if(action == "delete"){
				r=confirm("Are you sure you want to delete this?");
				
				if (r==true){
					//var data = "action="+tbl+"&value="+value;
					
				var data = "action=delete&action_id="+value;
						
				$.post("modules/cs/submit_cs_service_config.php",data,function(response){
					if(response == 0){
						alert("Deleted successfully");
				        $("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");
	                    set_value("action","insert",selector_type_id);								
							} else {
								alert("Deletion failed");
							}
						});
				}
			}
		});
	});
		
</script>



