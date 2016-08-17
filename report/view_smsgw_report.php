<?php
session_start();
include("../commonlib.php");

$cn = connectDB();
$remoteCnQry="select * from tbl_process_db_access where pname='SMSBLAST'";
$res = Sql_exec($cn,$remoteCnQry);
$dt = Sql_fetch_array($res);

$dbtype=$dt['db_type'];
$MYSERVER=$dt['db_server'];
$MYUID=$dt['db_uid'];
$MYPASSWORD=$dt['db_password'];
$MYDB=$dt['db_name'];
ClosedDBConnection($cn);
$remoteCn=connectDB();
//Receive passing data	
$edit_tbl = mysql_real_escape_string(htmlspecialchars($_REQUEST['tbl']));
$page = mysql_real_escape_string(htmlspecialchars($_REQUEST['page']));
$per_page = mysql_real_escape_string(htmlspecialchars($_REQUEST['per_page']));				
$start_date = mysql_real_escape_string(htmlspecialchars($_REQUEST['start_date']));
$end_date = mysql_real_escape_string(htmlspecialchars($_REQUEST['end_date']));	
$destination_number = mysql_real_escape_string(htmlspecialchars($_REQUEST['destination_number']));
$msg = mysql_real_escape_string(htmlspecialchars($_REQUEST['msg']));		
$srcMN = mysql_real_escape_string(htmlspecialchars($_REQUEST['srcMN']));		

$user_id = $_SESSION['LoggedInUserID'];


$extraBtn ="";
$extraBtnText="";

if($edit_tbl == "smsgw_report"){
	$content_arr = array("ID","SMS","Mask","Destination", "Date", "Status");
	
	$applied_condition = "";
	if(($start_date != NULL && trim($start_date) != '')  && ($end_date != NULL && trim($end_date) != '')){
		$applied_condition .= " where ";
		$applied_condition .= " `writeTime` BETWEEN '".$start_date."' AND '".$end_date."'";
	}
	
	if(trim($destination_number) != ""){ 
		if($applied_condition != "" ) $applied_condition .= " and "; 
		else $applied_condition .= " where ";
		$applied_condition .= " `dstMN` LIKE '%".$destination_number."%'";
	}
	if(trim($msg) != ""){ 
		if($applied_condition != "" ) $applied_condition .= " and "; 
		else $applied_condition .= " where ";
		$applied_condition .= " `msg` LIKE '%".$msg."%'";
	}
	if(trim($srcMN) != ""){ 
		if($applied_condition != "" ) $applied_condition .= " and "; 
		else $applied_condition .= " where ";
		$applied_condition .= " `srcMN` LIKE '%".$srcMN."%'";
	}
	
	if($_SESSION["ROLE_ID"] > 1){ 
		if($applied_condition != "" ) $applied_condition .= " and "; 
		else $applied_condition .= " where ";
		$applied_condition .= " `srcAccount` = '".$user_id."'";
	}
	
	$count_qry = "SELECT count(dstMN) FROM `smsoutbox`" . $applied_condition;
	$load_qry = "SELECT `msgID`,`msg`,`srcMN`, `dstMN`, `writeTime`, `msgStatus` FROM `smsoutbox`" . $applied_condition;
	$key = 'msgID';
	
	
	$extraBtn = true;
	$extraBtnText="Resend";
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
		$options['isDelete'] = false;	
		$options['extraBtn'] = $extraBtn;
		$options['extraBtnText'] = $extraBtnText;
		$options['skipLastColumn'] = false;
	//	$options['extraBtnCondition']=array("msgStatus"=>"FAILED");
		
					
		pagination_all_page($options);
	
	if($remoteCn)ClosedDBConnection($remoteCn);		
?>
<script>
	$(document).ready(function() {
		
		// Pagination Javascript
		function page_load(page,per_page){
			var tbl = "<?php echo $edit_tbl; ?>";
			var start_date = "<?php echo $start_date; ?>";
			var end_date = "<?php echo $end_date; ?>";
			var destination_number = "<?php echo $destination_number; ?>";
			var msg = "<?php echo $msg; ?>";
			
			//var data = "page="+page+"&per_page="+per_page+"&tbl="+tbl;
			var data = "page="+page+"&per_page="+per_page+"&tbl="+tbl+"&0="+start_date+"&1="+end_date+"&2="+destination_number+"&3="+msg;
			
				$.ajax({
					type: "POST",
					url: "report/view_smsgw_report.php",
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
			
		    if(action == "extra"){
				
				   //var data = "action="+tbl+"&value="+value;
					if(tbl == "smsgw_report"){
						var data = "action=extra&action_id="+value;
						
						$.post("modules/smsgw/update_sms_status.php",data,function(response){
							if(parseInt(response) == 0){
								alert("Resend successfully");
								//$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");
								var page = <?php echo $page ?>;
								var per_page =<?php echo $per_page?>;
								page_load(page,per_page);
								
							} else {
								alert("Resend failed");
							}
						});
					}
				
			}
        });
	});


</script>