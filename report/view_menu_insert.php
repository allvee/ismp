<?php
// CH, CGW, SMSGW etc. report show,edit,delete etc.
// Date: August 10, 2014
// Author: Atanu Saha
session_start();
include("../commonlib.php");

$cn = connectDB();
//Receive passing data	
$edit_tbl =  mysql_real_escape_string(htmlspecialchars($_REQUEST['tbl']));
$page     =  mysql_real_escape_string(htmlspecialchars($_REQUEST['page']));
$per_page =  mysql_real_escape_string(htmlspecialchars($_REQUEST['per_page']));				
//$user_id = $_SESSION['USER_ID'];	


//Initialize 
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


if($edit_tbl == "tbl_menuInsert"){
	
	$count_qry = "select count(id) from tbl_menu";
	$content_arr = array("ID","Title","page","parent","Sub Heading","Order","Status");
	$load_qry = "SELECT id,title,page,parent,sub_title,order_by,is_active FROM  tbl_menu ORDER BY id ASC";
	$key = 'id';
	$extraBtn = false;
	$editOption = true;
	$deleteOption = true;
	$extraBtnText = NULL;
   	
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
		
		// Pagination Javascript
		function page_load(page,per_page){
			var tbl = "<?php echo $edit_tbl; ?>";
			var data = "page="+page+"&per_page="+per_page+"&tbl="+tbl;
			
				$.ajax({
					type: "POST",
					url: "report/view_menu_insert.php",
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
			var id_arr = id.split("-");
			var action = id_arr[0];
			var tbl = id_arr[1];
			var value = id_arr[2];
		
			
			if(action == "edit"){
				$("#action_id").val(value);
				    if(tbl == "tbl_menuInsert"){
						   var data = "action=edit&action_id="+value;
						   set_value("action","edit",selector_type_id);
						   get_menu_data("modules/cms/menu_insert",["action_id","action"]);
						   set_value("action","update",selector_type_id);
					}
			} else if( action == "delete" ){
				r=confirm("Are you sure you want to delete this?");
				
				if (r==true){
					//var data = "action="+tbl+"&value="+value;
					if( tbl == "tbl_menuInsert" ){
						
						var data = "action=delete&action_id="+value;
					    $.post("modules/cms/menu_insert.php",data,function(response){
							if(response == 0){
								alert("Deleted successfully");
								$("#"+id).parent("td").parent("tr").css("display","none");
								set_value("action","insert",selector_type_id);
							} else {
								alert("Deletion failed");
							}
						});
					} 
				}
			}else if(action == "extra") {
					
								
			}
        });
	});


</script>