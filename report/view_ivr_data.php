<?php
session_start();
// White LIST etc. report show,edit,delete etc.
// Date: August 10, 2014
// Author: Atanu Saha

include("../commonlib.php");

$cn = connectDB();
//Receive passing data	

$edit_tbl = mysql_real_escape_string(htmlspecialchars($_REQUEST['tbl']));
$page = mysql_real_escape_string(htmlspecialchars($_REQUEST['page']));
$per_page = mysql_real_escape_string(htmlspecialchars($_REQUEST['per_page']));	
$service_id =  mysql_real_escape_string(htmlspecialchars($_REQUEST['service_id']));				
$page_id =  mysql_real_escape_string(htmlspecialchars($_REQUEST['page_id']));			
$key = "";
$remoteCnQry = "SELECT * FROM tbl_process_db_access WHERE pname='CH'";
$res         = Sql_exec($cn, $remoteCnQry);
$dt          = Sql_fetch_array($res);

$dbtype     = $dt['db_type'];
$MYSERVER   = $dt['db_server'];
$MYUID      = $dt['db_uid'];
$MYPASSWORD = $dt['db_password'];
$MYDB       = $dt['db_name'];
ClosedDBConnection($cn);

$remoteCn = connectDB();

if($edit_tbl == "ivr_data"){
	$count_qry = "SELECT count(PageName) FROM ivrmenu where PageName='$page_id' and Service='$service_id'";
	$content_arr = array("Service","Current State","Key Press","Short Code","Next State","NextKey","Action Command","URL","Play File","Record File","Input Length","Recording Time","Menu Status","Next File","Prev File","Repeat Key","Back Key","Forward Key","Select Key","Instruction File","MaxRetryCount","ErrorName","NodeName","PageName","ICF","IVF","SP","Rate Code"
					);
	$load_qry = "SELECT * FROM ivrmenu WHERE PageName='$page_id' and Service='$service_id'";
	
	$key = 'Service';
	$extraBtn = false;
	//$extraBtnText = "Download";
} else {
	$count_qry = "";
	$content_arr = NULL;
	$load_qry = "";
	$key = '';
	$extraBtn = false;
}
	
		// function Parameters
		$options = array();
		$options['cn'] = $remoteCn;
		$options['count_qry'] = $count_qry;
		$options['page'] = $page;
		$options['per_page'] = $per_page;
		$options['content_arr'] = $content_arr;
		$options['load_qry'] = $load_qry;
		$options['key'] = $key;
		$options['isEdit'] = false;
		$options['edit_tbl'] = $edit_tbl;
		//$options['isDelete'] = true;	
		//$options['extraBtn'] = $extraBtn;
		//$options['extraBtnText'] = $extraBtnText;
		//$options['skipLastColumn'] = true;
					
		pagination_all_page($options);
	
	ClosedDBConnection($remoteCn);		
?>
<script>
	$(document).ready(function() {
		
		// Pagination Javascript
		function page_load(page,per_page){
			var tbl = "<?php echo $edit_tbl; ?>";
			var data = "page="+page+"&per_page="+per_page+"&tbl="+tbl+"&service_id="+get_value("#service_id")+"&page_id="+get_value("#page_id");
			
				$.ajax({
					type: "POST",
					url: "report/view_ivr_data.php",
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
			/*	$("#action_id").val(value);
				var data = "action="+tbl+"&value="+value;
				
				if(tbl == "white_list"){
					get_obd_white([ "status" ]);
					set_value("action","update",selector_type_id);
				}  */
			}  else if(action == "delete"){
			
			/*	r=confirm("Are you sure you want to delete this?");
				
				if (r==true){
					//var data = "action="+tbl+"&value="+value;
					if(tbl == "white_list"){
						var data = "action=delete&action_id="+value;
						
						$.post("modules/obd/submit_obd_white.php",data,function(response){
							if(response == 0){
								alert("Deleted successfully");
								$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");
								
							} else {
								alert("Deletion failed");
							}
						});
					}
				}  */
			}else if(action == "extra"){
				//var data = "action="+tbl+"&value="+value;
			/*	if(tbl == "white_list"){
					var data = "action=download&action_id="+value;
					location.href="report/downloadWhite.php?action_id="+value;
				}  */
				
			}
			
        });
	});


</script>