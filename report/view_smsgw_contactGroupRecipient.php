<?php
session_start();
include("../commonlib.php");

$cn = connectDB();
//Receive passing data	
$edit_tbl = mysql_real_escape_string(htmlspecialchars($_REQUEST['tbl']));
$page = mysql_real_escape_string(htmlspecialchars($_REQUEST['page']));
$per_page = mysql_real_escape_string(htmlspecialchars($_REQUEST['per_page']));					

	
$user_id = $_SESSION['USER_ID'];
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
	
if($edit_tbl == "smsgw_contactGroupRecipient"){
	$groupId = mysql_real_escape_string(htmlspecialchars($_REQUEST['0']));
	$contact_no = mysql_real_escape_string(htmlspecialchars($_REQUEST['1']));
	$count_qry = "select count(id) from `tbl_smsgw_group_recipient` WHERE `is_active`='active' " .
				" AND `group_id`='".$groupId."' AND `recipient_no` LIKE '%".$contact_no."%'";
	$content_arr = array("ID","Recipient Name","Recipient Number");
	$load_qry = "SELECT `id`,`recipient_name`,`recipient_no` FROM `tbl_smsgw_group_recipient` WHERE `is_active`='active' " .
					" AND `group_id`='".$groupId."' AND `recipient_no` LIKE '%".$contact_no."%'";
	$key = 'id';
	$extraBtn = false;
	$editOption = false;
	$deleteOption = true;
	
} else if($edit_tbl == "smsgw_sms_permission"){
	
	$count_qry = "select count(smp.`id`) from `tbl_smsgw_msg_permission` smp inner join `tbl_smsgw_contact_group` scg on smp.`group_id`=scg.`id` WHERE smp.`status`='pending' "; 
	$content_arr = array("ID","Msg","Mask","Group");
	$load_qry = "SELECT smp.`id`,smp.`msg`,smp.`mask`,scg.`group_name` FROM `tbl_smsgw_msg_permission` smp inner join `tbl_smsgw_contact_group` scg on smp.`group_id`=scg.`id` WHERE smp.`status`='pending' ";
	
	if(isset($_REQUEST['msg']) && trim($_REQUEST['msg']) != ""){ 
		$msg = mysql_real_escape_string(htmlspecialchars($_REQUEST['msg']));
		$count_qry.= " AND smp.`msg` Like '%".$msg."%'";
		$load_qry.= " AND smp.`msg` Like '%".$msg."%'";
	}
	
	if(isset($_REQUEST['mask']) && trim($_REQUEST['mask']) != ""){ 
		$mask = mysql_real_escape_string(htmlspecialchars($_REQUEST['mask']));
		$count_qry.= " AND smp.`mask` Like '%".$mask."%'";
		$load_qry.= " AND smp.`msg` Like '%".$msg."%'";
	}
	
	$key = 'id';
	$extraBtn = false;
	$editOption = true;
	$editBtnTxt = "SEND";
	$deleteOption = false;
	
} else {
	$count_qry = "";
	$content_arr = NULL;
	$load_qry = "";
	$key = '';
	$extraBtn = false;
}
	
	
		
		// function Parameters
		$options = array();
		$options['cn'] = $cn;
		$options['count_qry'] = $count_qry;
		$options['page'] = $page;
		$options['per_page'] = $per_page;
		$options['content_arr'] = $content_arr;
		$options['load_qry'] = $load_qry;
		$options['key'] = $key;
		$options['isEdit'] = $editOption;;
		$options['edit_tbl'] = $edit_tbl;
		$options['isDelete'] = $deleteOption;	
		$options['extraBtn'] = $extraBtn;
		$options['extraBtnText'] = $extraBtnText;
		$options['skipLastColumn'] = false;
		$options['editBtnTxt'] = $editBtnTxt;
		
					
		pagination_all_page($options);
	
	ClosedDBConnection($cn);		
?>
<script>
	$(document).ready(function() {
		
		// Pagination Javascript
		function page_load(page,per_page){
			var tbl = "<?php echo $edit_tbl; ?>";
			var groupId = "<?php echo $groupId; ?>";
			
			//var data = "page="+page+"&per_page="+per_page+"&tbl="+tbl;
			var data = "page="+page+"&per_page="+per_page+"&tbl="+tbl+"&0="+groupId;
			
				$.ajax({
					type: "POST",
					url: "report/view_smsgw_contactGroupRecipient.php",
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
				
				
				if(tbl == "smsgw_sms_permission"){
					var data = "action=update&action_id="+value;
						
						$.post("modules/smsgw/submitBulkSms.php",data,function(response){
							if(response == "Successfully inserted to smsoutbox"){
								//alert("Deleted successfully");
								$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");
								
							} 
							
							alert(response);
							
						});
				}
			} else if(action == "delete"){
				r=confirm("Are you sure you want to delete this?");
				
				if (r==true){
					//var data = "action="+tbl+"&value="+value;
					if(tbl == "smsgw_contactGroupRecipient"){
						var data = "action=delete&action_id="+value;
						
						$.post("modules/smsgw/submit_smsgw_contactGroupRecipient.php",data,function(response){
							if(response == 0){
								alert("Deleted successfully");
								$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");
								
							} else {
								alert("Deletion failed");
							}
						});
					}
				}
			}
        });
	});


</script>