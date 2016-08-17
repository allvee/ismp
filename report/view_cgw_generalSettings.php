<?php
session_start();

include("../commonlib.php");
$cn=connectDB();
//Receive passing data	
$edit_tbl = mysql_real_escape_string(htmlspecialchars($_REQUEST['tbl']));
$page = mysql_real_escape_string(htmlspecialchars($_REQUEST['page']));
$per_page = mysql_real_escape_string(htmlspecialchars($_REQUEST['per_page']));				

$user_id = $_SESSION['USER_ID'];
	
	$remoteCnQry="select * from tbl_process_db_access where pname='CGW'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);
	
	$cn=connectDB();
		
if($edit_tbl == "cgw_generalSettings"){
	$count_qry = "select count(pName) from `applicationsettings`";
	$content_arr = array("Name","Value");
	$load_qry = "select `pName`,`pValue` from `applicationsettings` ";
	$key = 'pName';
	$deleteOption = false;
	$extraBtn = false;
} elseif($edit_tbl == "cgw_tps"){
	$count_qry = "select count(*) from `tps`";
	$content_arr = array("ID","App Id","Service Id","Timeslot","Priority","Value");
	$load_qry = "select `id`,`appid`,`serviceid`,`timeslot`,`priority`,`value` from `tps`"; /*`UserID`='".$user_id."' AND*/
	$key = 'id';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
} elseif($edit_tbl == "cgw_subscription_wallet"){
	$count_qry = "select count(*) from `subscriptionwallet`";
	$content_arr = array("ID","Subscription Group Id","Service Id","BNo","Balance","Start Date","End Date","Free Wallet","Free Wallet End Date");
	$load_qry = "select `id`,`subscriptiongroupid`,`serviceid`,`bno`,`balance`,`startdate`,`enddate`,`freewallet`,`freewallet_enddate` from `subscriptionwallet`"; /*`UserID`='".$user_id."' AND*/
	$key = 'id';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
} elseif($edit_tbl == "cgw_statewisemsg"){
	$count_qry = "select count(`UniqueID`) from `statewisemsg`";
	$content_arr = array("ID","FromState","ToState","Msg","URL","NotificationStatus","SubscriptionGroupID");
	$load_qry = "select `UniqueID`,`FromState`,`ToState`,`Msg`,`URL`,`NotificationStatus`,`SubscriptionGroupID` from `statewisemsg`"; /*`UserID`='".$user_id."' AND*/
	$key = 'UniqueID';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
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
		$options['isEdit'] = true;
		$options['edit_tbl'] = $edit_tbl;
		$options['isDelete'] = $deleteOption;	
		$options['extraBtn'] = $extraBtn;
		$options['extraBtnText'] = $extraBtnText;
		$options['skipLastColumn'] = false;
		
					
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
					url: "report/view_cgw_generalSettings.php",
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
				
				if(tbl == "cgw_generalSettings"){
					get_cgw_generalSettings([ "status" ]);
					set_value("action","update",selector_type_id);
				} else if(tbl == "cgw_tps"){
					get_user_data("modules/cgw/get_cgw_tps",["action_id"]);
					set_value("action","update",selector_type_id);
				} else if(tbl == "cgw_subscription_wallet"){
					get_user_data("modules/cgw/get_subscription_wallet",["action_id"]);
					set_value("action","update",selector_type_id);
				} else if(tbl == "cgw_statewisemsg"){
					get_user_data("modules/cgw/get_cgw_statewisemsg",["action_id"]);
					set_value("action","update",selector_type_id);
				}
			} else if(action == "delete"){
				r=confirm("Are you sure you want to delete this?");
				
				if (r==true){
					//var data = "action="+tbl+"&value="+value;
					if(tbl == "cgw_tps"){
						var data = "action=delete&action_id="+value;
						
						$.post("modules/cgw/submit_cgw_tps.php",data,function(response){
							if(response == 0){
								alert("Deleted successfully");
								$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");
								set_value("action","insert",selector_type_id);
								
							} else {
								alert("Deletion failed");
							}
						});
					} else if(tbl == "cgw_subscription_wallet"){
						var data = "action=delete&action_id="+value;
						
						$.post("modules/cgw/submit_cgw_subscription_wallet.php",data,function(response){
							if(response == 0){
								set_value("action","insert",selector_type_id);
								set_value("action_id","",selector_type_id);
								alert("Deleted successfully");
								$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");
								
							} else {
								alert("Deletion failed");
							}
						});
					} else if(tbl == "cgw_statewisemsg"){
						var data = "action=delete&action_id="+value;
						
						$.post("modules/cgw/submit_cgw_statewisemsg.php",data,function(response){
							if(response == 0){
								set_value("action","insert",selector_type_id);
								set_value("action_id","",selector_type_id);
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