<?php
session_start();
// DND LIST etc. report show,edit,delete etc.
// Date: August 10, 2014
// Author: Atanu Saha

include("../commonlib.php");
	
$cn=connectDB();
//Receive passing data	
$edit_tbl = mysql_real_escape_string(htmlspecialchars($_REQUEST['tbl']));
$page = mysql_real_escape_string(htmlspecialchars($_REQUEST['page']));
$per_page = mysql_real_escape_string(htmlspecialchars($_REQUEST['per_page']));				
$MSISDN = mysql_real_escape_string(htmlspecialchars($_REQUEST['MSISDN']));
$short_code = mysql_real_escape_string(htmlspecialchars($_REQUEST['short_code']));	
$service_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['service']));		

	
//$user_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['param']));
$user_id = $_SESSION['USER_ID'];

if($edit_tbl == "cgw_cdr"){
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
	//$count_qry = "select count(UniqueID) from `cdr`";
	$content_arr = array("UniqueID","ServiceID","ChargingType", "CGWID", "Ano", "Bno", "Direction", "RateID", "ResultCode","Start Time", "End Time" ,"Amount", "Purpose", "PackageID","BillingNode");
	if($short_code != null AND $short_code != ' ' AND $service_id != null AND  $service_id != ' ')
	{
		$count_qry = "select count(UniqueID) from `cdr` where `Ano` LIKE '".$MSISDN."%' AND `Bno` = '".$short_code."' AND `ServiceID`='".$service_id."'";
		$load_qry = "SELECT `UniqueID`,`ServiceID`, `ChargingType`, `CGWID`, `Ano`, `Bno`, `Direction`, `RateID`,  `ResultCode`,`StartTime`,`EndTime`,  `Amount`, `Purpose`, " .
			" `PackageID`,`BillingNode`   FROM `cdr`  " .
			" where `Ano` LIKE '".$MSISDN."%' AND `Bno` = '".$short_code."' AND `ServiceID`='".$service_id."'";	
	}
	else if($short_code != null AND $short_code != ' ' && ($service_id == null OR  $service_id ==' '))
	{
		$count_qry = "select count(UniqueID) from `cdr` where `Ano` LIKE '".$MSISDN."%' AND `Bno` = '".$short_code."'";
		$load_qry = "SELECT `UniqueID`,`ServiceID`, `ChargingType`, `CGWID`, `Ano`, `Bno`, `Direction`, `RateID`,  `ResultCode`,  `StartTime`,`EndTime`,`Amount`, `Purpose`, " .
			" `PackageID`,`BillingNode`   FROM `cdr`  " .
			" where `Ano` LIKE '".$MSISDN."%' AND `Bno` = '".$short_code."'";	
	}else if(($short_code == null OR $short_code == ' ') AND $service_id != null AND  $service_id != ' ')
	{
		$count_qry = "select count(UniqueID) from `cdr`  where `Ano` LIKE '".$MSISDN."%' AND `ServiceID`='".$service_id."'";
		$load_qry = "SELECT `UniqueID`,`ServiceID`, `ChargingType`, `CGWID`, `Ano`, `Bno`, `Direction`, `RateID`,  `ResultCode`, `StartTime`,`EndTime`, `Amount`, `Purpose`, " .
			" `PackageID`,`BillingNode`   FROM `cdr`  " .
			" where `Ano` LIKE '".$MSISDN."%' AND `ServiceID`='".$service_id."'";	
	}
	else if(($short_code == null OR $short_code == ' ') OR ($service_id != null OR  $service_id != ' '))
	{
		$count_qry = "select count(UniqueID) from `cdr` where `Ano` LIKE '".$MSISDN."%'";
		$load_qry = "SELECT `UniqueID`,`ServiceID`, `ChargingType`, `CGWID`, `Ano`, `Bno`, `Direction`, `RateID`,  `ResultCode`, `StartTime`,`EndTime`, `Amount`, `Purpose`, " .
			" `PackageID`,`BillingNode`   FROM `cdr`  " .
			" where `Ano` LIKE '".$MSISDN."%'";	
	}
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
		$options['cn'] = $cn;
		$options['count_qry'] = $count_qry;
		$options['page'] = $page;
		$options['per_page'] = $per_page;
		$options['content_arr'] = $content_arr;
		$options['load_qry'] = $load_qry;
		$options['key'] = $key;
		$options['isEdit'] = false;
		$options['edit_tbl'] = $edit_tbl;
		$options['isDelete'] = false;	
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
					url: "report/view_cgw_cdr.php",
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
			/*
			if(action == "edit"){
				$("#action_id").val(value);
				var data = "action="+tbl+"&value="+value;
				
				if(tbl == "cgw_cdr"){
					get_cgw_rc_sg([ "status" ]);
					set_value("action","update",selector_type_id);
				}
			} else if(action == "delete"){
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