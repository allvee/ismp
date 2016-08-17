<?php
// CMS Permission
// Date: February 8, 2015
// Author: Atanu Saha
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
$extraBtnCnd = NULL;	

if($edit_tbl == "content_permission"){
	$remoteCnQry="select * from tbl_process_db_access where pname='CMS'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	//remote connection parameter set up
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);// close current connection
	
	$cn=connectDB();
	$content_name = "";
	
	if(isset($_REQUEST['content_name']))
		$content_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['content_name']));
	
	$count_qry = "select count(`ContentID`) from content";
	$count_qry .= " where `ContentName` Like '%".$content_name."%' and `Status`='pending'";
	$content_arr = array("ID","Content","Title","Description","Content Type","Activation Date","Deactivation Date","Status");
	$load_qry = "SELECT `ContentID`,`ContentName`,`Title`,`Description`,`ContentTypeID`,`ActivationDate`,`DeactivationDate`,`Status` FROM content";
	$load_qry .= " where `ContentName` Like '%".$content_name."%' and `Status`='pending'";
	$load_qry .= " ORDER BY `ContentID` DESC";
	$key = 'ContentID';
	$extraBtn = true;
	$editOption = true;
	$deleteOption = true;
	
	$deleteBtnText = "Active";
    $editBtnTxt = "Reject";
    $extraBtnText = "Load"; 
	 
       
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
        $options['extraBtnCondition'] = $extraBtnCnd;			
		pagination_all_page($options);
	
if($cn)ClosedDBConnection($cn);		
?>
<script>
	$(document).ready(function() {
		
		// Pagination Javascript
		function page_load(page,per_page){
			var tbl = "<?php echo $edit_tbl; ?>";
			var data = "page="+page+"&per_page="+per_page+"&tbl="+tbl;
			
				$.ajax({
					type: "POST",
					url: "report/view_page.php",
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
				
				if(tbl=="content_permission"){
					var data = "action=edit&action_id="+value;
						
						$.post("modules/cms/submit_content_permission.php",data,function(response){
							if(response == 0){
								set_value("action","insert",selector_type_id);
								set_value("action_id","",selector_type_id);
								alert("Submit successfully");
								$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");
								
							} else {
								alert("Submit failed");
							}
						});
				}
			} else if(action == "delete"){
				
					if(tbl=="content_permission"){
						
						var data = "action=delete&action_id="+value;
						
						$.post("modules/cms/submit_content_permission.php",data,function(response){
							if(response == 0){
								set_value("action","insert",selector_type_id);
								set_value("action_id","",selector_type_id);
								alert("Submit successfully");
								$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");
								
							} else {
								alert("Submit failed");
							}
						});
					} 
				
			}else if(action == "extra") {
					
				if( tbl == 'content_permission'){
					set_value("current_src_holder",value,selector_type_id);
					var audio_src = get_prompt_location("modules/cms/get_prompt_location",["current_src_holder"]);
					$("#play").attr({src:audio_src});
					$("#audio_id").load();
					$("#playfile").dialog("open");	
					$("#playfile").css({'display':'block'});
					console.log("Src::",$("#play").attr('src')); 
					
				}				
			}
        });
	});


</script>