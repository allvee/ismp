<?php
session_start();

include("../commonlib.php");

$cn = connectDB();
$remoteCnQry="select * from tbl_process_db_access where pname='CGW'";
$res = Sql_exec($cn,$remoteCnQry);
$dt = Sql_fetch_array($res);
//remote connection parameter set up
$dbtype=$dt['db_type'];
$MYSERVER=$dt['db_server'];
$MYUID=$dt['db_uid'];
$MYPASSWORD=$dt['db_password'];
$MYDB=$dt['db_name'];
ClosedDBConnection($cn);// close current connection
// open remote connection
$remoteCn=connectDB();
//Receive passing data	
$edit_tbl = mysql_real_escape_string(htmlspecialchars($_REQUEST['tbl']));
$page = mysql_real_escape_string(htmlspecialchars($_REQUEST['page']));
$per_page = mysql_real_escape_string(htmlspecialchars($_REQUEST['per_page']));				
$serviceId = mysql_real_escape_string(htmlspecialchars($_REQUEST['ServiceIDSearch']));

$user_id = $_SESSION['USER_ID'];
		
if($edit_tbl == "cgw_ratePlan"){
	$count_qry = "select count(UniqueID) from `ratemaster` where `ServiceID`='".$serviceId."'";
	$content_arr = array("UniqueID","Service","Package","Charging Type","Call Type",
						"Time Slot","Subscription Group","Subscription Status","Rate ID");
	$load_qry = "select `UniqueID`,`ServiceID`,`PackageID`,`ChargingType`,`CallTypeID`, " .
					"`TimeSlotID`,`SubscriptionGroupID`,`SubscriptionStatus`,`RateID` from `ratemaster` " .
					" where `ServiceID`='".$serviceId."'";
	$key = 'UniqueID';
	$extraBtn = false;
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
		$options['isEdit'] = true;
		$options['edit_tbl'] = $edit_tbl;
		$options['isDelete'] = false;	
		$options['extraBtn'] = $extraBtn;
		$options['extraBtnText'] = $extraBtnText;
		$options['skipLastColumn'] = false;
		
					
		pagination_all_page($options);
	
if($cn)ClosedDBConnection($cn);	
if($remoteCn)ClosedDBConnection($remoteCn);		
?>
<script>
	$(document).ready(function() {
		
		// Pagination Javascript
		function page_load(page,per_page){
			var tbl = "<?php echo $edit_tbl; ?>";
			var serviceId = "<?php echo $serviceId; ?>";
			
			var data = "page="+page+"&per_page="+per_page+"&tbl="+tbl+"&ServiceIDSearch="+serviceId;
			//alert("data :"+data);
				$.ajax({
					type: "POST",
					url: "report/view_cgw_ratePlan.php",
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
				
				if(tbl == "cgw_ratePlan"){
					get_cgw_ratePlan([ "status" ]);
					set_value("action","update",selector_type_id);
					show_hide("#contentId",null);		
				}
			}/* else if(action == "delete"){
				r=confirm("Are you sure you want to delete this?");
				
				if (r==true){
					//var data = "action="+tbl+"&value="+value;
					if(tbl == "dnd_list"){
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
			}*/
        });
	});


</script>