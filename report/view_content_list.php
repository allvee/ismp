<?php
session_start();
// DND LIST etc. report show,edit,delete etc.
// Date: August 10, 2014
// Author: Atanu Saha
include("../commonlib.php");
//Receive passing data	
$edit_tbl =$_REQUEST['tbl'];
$page = $_REQUEST['page'];
$per_page = $_REQUEST['per_page'];				

//$user_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['param']));
$user_id = $_SESSION['USER_ID'];
	

if($edit_tbl == "content_list"){
	$count_qry = "select count(content_id) from tbl_cms_content";
	$content_arr = array("ID","Content","Activation Date","Deactivation Date");
	$load_qry = "SELECT content_id,content_name,activation_date,deactivation_date FROM  tbl_cms_content ORDER BY content_id DESC";
	$key = 'content_id';
	$extraBtn = false;
	$editOption = true;
	$deleteOption = false;
	$extraBtnText = NULL;
} else {
	$count_qry = "";
	$content_arr = NULL;
	$load_qry = "";
	$key = '';
	$extraBtn = false;
	$editOption = false;
	$deleteOption = false;
	$extraBtnText = NULL;
}
	
	$cn = connectDB();
		
		// function Parameters
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
		
					
		pagination_all_page($options);
	
	ClosedDBConnection($cn);		
?>

<script>
	$(document).ready(function() {
		
		// Pagination Javascript
		function page_load(page,per_page){
			var tbl = "<?php echo $edit_tbl; ?>";
			
			var data = "page="+page+"&per_page="+per_page+"&tbl="+tbl;
			
				$.ajax({
					type: "POST",
					url: "report/view_content_list.php",
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
			var per_page = $("#view_<?php echo $edit_tbl;?> select.per_page :selected").val();
				
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
			
			var trRow = $("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr");
			
			if(action == "edit"){
				$("#action_id").val(value);
				var data = "action="+tbl+"&value="+value;
				
				if(tbl == "content_list"){
					//get_obd_dnd([ "status" ]);
					//set_value("action","update",selector_type_id);
				}
			} else if(action == "delete"){
				r=confirm("Are you sure you want to delete this?");
				
				if (r==true){
					//var data = "action="+tbl+"&value="+value;
					if(tbl == "content_list"){
						var data = "action=delete&action_id="+value;
						
						$.post("modules/obd/submit_obd_dnd.php",data,function(response){
							if(response == 0){
								alert("Deleted successfully");
								$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");
								
							} else {
								alert("Deletion failed");
							}
						});
					}
				}
			} else if(action == "extra"){
					//var data = "action="+tbl+"&value="+value;
					if(tbl == "dnd_list"){
					var data = "action=download&action_id="+value;
					//alert("value :"+value);
					//header("Location: report/downloadDND.php?action_id="+value);
					location.href="report/downloadDND.php?action_id="+value;
				}
			}
        });
	});


</script>