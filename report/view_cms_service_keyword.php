<?php
// session_start();

include("../commonlib.php");
$cn=connectDB();
	//Receive passing data	
	$edit_tbl = mysql_real_escape_string(htmlspecialchars($_REQUEST['tbl']));
	$page = mysql_real_escape_string(htmlspecialchars($_REQUEST['page']));
	$per_page = mysql_real_escape_string(htmlspecialchars($_REQUEST['per_page']));				
	$operator_db = mysql_real_escape_string(htmlspecialchars($_REQUEST['operator_db']));				
	
	//$user_id = $_SESSION['USER_ID'];
	
	$remoteCnQry="select * from tbl_process_db_access where id='$operator_db'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
ClosedDBConnection($cn);
	
$cn=connectDB();

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
$extraBtnCnd = array();	
		
if($edit_tbl == "cms_service_keyword"){
	$count_qry = "select count(`id`) from `service`";
	$content_arr = array("ID","Root","ServiceID", 
	"ServiceName", 
	"Description", 
	"IsDeregMsg", 
	"DeRegURL", 
	"DeRegMsg", 
	"DeRegAllMsg", 
	"DeRegExtraURL", 
	"RegURL", 
	"RegMsg", 
	"RegExtraURL", 
	"AlreadyRegistedMsg", 
	"InfoURL", 
	"STATUS", 
	"SrcType", 
	"SMSText",  
	"ShortCode");
	$load_qry = "select `id`,`Root`,`ServiceID`, 
	`ServiceName`, 
	`Description`, 
	`IsDeregMsg`, 
	`DeRegURL`, 
	`DeRegMsg`, 
	`DeRegAllMsg`, 
	`DeRegExtraURL`, 
	`RegURL`, 
	`RegMsg`, 
	`RegExtraURL`, 
	`AlreadyRegistedMsg`, 
	`InfoURL`,
	`Status`,
	`SrcType`, 
	`SMSText`, 
	`ShortCode` from `service` ";
	$key = 'id';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
}  else {
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
		$options['isEdit'] = $editOption;
		$options['edit_tbl'] = $edit_tbl;
		$options['isDelete'] = $deleteOption;	
		$options['extraBtn'] = $extraBtn;
		$options['extraBtnText'] = $extraBtnText;
		$options['deleteBtnText'] = $deleteBtnText;
		$options['editBtnTxt'] = $editBtnTxt;
        $options['extraBtnCondition '] = $extraBtnCnd;
					
		pagination_all_page($options);
	
	ClosedDBConnection($cn);		
?>
<script>
	$(document).ready(function() {
		
		// Pagination Javascript
		function page_load(page,per_page){
			var tbl = "<?php echo $edit_tbl; ?>";
			var operator_db = "<?php echo $operator_db; ?>";
			var data = "page="+page+"&per_page="+per_page+"&tbl="+tbl+"&operator_db="+operator_db;
			
				$.ajax({
					type: "POST",
					url: "report/view_cms_service_keyword.php",
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
				
				if(tbl == "cms_service_keyword"){
					get_user_data("modules/cms/get_service_keyword",["action_id","operator_db"]);
					set_value("action","update",selector_type_id);
				} 
			} else if(action == "delete"){
				r=confirm("Are you sure you want to delete this?");
				
				if (r==true){
					//var data = "action="+tbl+"&value="+value;
					if(tbl == "cms_service_keyword"){
						var data = "action=delete&action_id="+value+"&operator_db="+get_value("#operator_db");
						
						$.post("modules/cms/submit_cms_service_keyword.php",data,function(response){
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
			}
        });
	});


</script>