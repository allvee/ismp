<?php
// CH, CGW, SMSGW etc. report show,edit,delete etc.
// Date: August 10, 2014
// Author: Atanu Saha
session_start();
include("../commonlib.php");

$cn = connectDB();
//Receive passing data	
$edit_tbl = mysql_real_escape_string(htmlspecialchars($_REQUEST['tbl']));
$page = mysql_real_escape_string(htmlspecialchars($_REQUEST['page']));
$per_page = mysql_real_escape_string(htmlspecialchars($_REQUEST['per_page']));	

$user_id = $_SESSION['USER_ID'];
$ROLE_ID = $_SESSION['ROLE_ID'];
$CP_ID = $_SESSION['CP_ID'];		

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
$remoteCn = null;
$extraBtnCnd = array();	
if($edit_tbl == "ch_call_routing"){
	$remoteCnQry="select * from tbl_process_db_access where pname='CH'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);
	
	$cn=$remoteCn=connectDB();
	
	$count_qry = "select count(id) from geturl";
	$content_arr = array("ID","Ano","Bno","Status","Provision End Date","URL");
	$load_qry = "select id,ano,bno,Status,ProvisionEndDate,url from geturl";
	$key = 'id';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
}elseif($edit_tbl == "ch_channelmap"){
	
	$count_qry = "select count(id) from `tbl_ch_channel_map`";
	$content_arr = array("ID","Start Channel","End Channel", "SIP Server IP","SIP Server Port","IPBCP Enabled","IUFP Enabled");
	$load_qry = "select id,st_channel, e_channel, sip_server_ip, sip_server_port, ipbcp_enabled, iufp_enabled from `tbl_ch_channel_map`";
	$key = 'id';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
} elseif($edit_tbl == "cgw_callType"){
	
	$remoteCnQry="select * from tbl_process_db_access where pname='CGW'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);
	
	$cn=$remoteCn=connectDB();
	
	$count_qry = "select count(CallTypeID) from `calltype`";
	$content_arr = array("Call Type ID","Ano","Bno");
	$load_qry = "select `CallTypeID`,`Ano`,`Bno` from `calltype` ";
	$key = 'CallTypeID';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
} elseif($edit_tbl == "cgw_counter"){
	
	$remoteCnQry="select * from ismp.tbl_process_db_access where pname='CGW'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);
	
	$cn=$remoteCn=connectDB();
	
	$count_qry = "select count(id) from `counter`";
	$content_arr = array("ID","Content Type","AggType","Period","Clause","Value");
	$load_qry = "select `id`,`countertype`,`aggtype`,`period`,`clause`,`value` from `counter`";
	$key = 'id';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
} elseif($edit_tbl == "cgw_accumulator"){
	
	$remoteCnQry="select * from ismp.tbl_process_db_access where pname='CGW'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);
	
	$cn=$remoteCn=connectDB();
	
	$count_qry = "select count(id) from `accumulator`";
	$content_arr = array("ID","Counter ID","Discount Type","Amount");
	$load_qry = "select `id`,`counterid`,`discounttype`,`amount` from `accumulator`";
	$key = 'id';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
} elseif($edit_tbl == "cgw_timeSlot"){
	
	$remoteCnQry="select * from tbl_process_db_access where pname='CGW'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);
	
	$cn=$remoteCn=connectDB();
	
	$count_qry = "select count(TimeSlotID) from `timeslot`";// where `UserID`='".$user_id."' ";
	$content_arr = array("Time Slot ID","Start Day","End Day","Start Time","End Time");
	$load_qry = "select `TimeSlotID`,`StartDay`,`EndDay`,`StartTime`,`EndTime` from `timeslot`";// where `UserID`='".$user_id."' ";
	$key = 'TimeSlotID';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
} elseif($edit_tbl == "cgw_rc_servicePromo"){
	
	$remoteCnQry="select * from tbl_process_db_access where pname='CGW'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);
	
	$cn=$remoteCn=connectDB();
	
	$count_qry = "select count(id) from `servicepromo`";
	$content_arr = array("ID","Subscription Group ID","To Subscription Group ID","To Status","Activation Start","Activation End","Status","Ano");
	$load_qry = "select `id`,`SubscriptionGroupID`,`ToSubscriptionGroupID`,`ToStatus`,`ActivationStart`,`ActivationEnd`,`Status`,`Ano` from `servicepromo`"; /*`UserID`='".$user_id."' AND*/
	$key = 'id';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
} elseif($edit_tbl == "smsgw_account_manager") {
	$count_qry = "select count(id) from tbl_smsgw_account";
	$content_arr = array("ID","Acc. Name","Balance","Masks","Status");
	$load_qry = "select id,acc_name,balance,masks,is_active from tbl_smsgw_account";
	$key = 'id';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
} elseif($edit_tbl == "smsgw_account_template"){
	$count_qry = "select count(id) from tbl_smsgw_template where is_active='active' and `created_by`='".$user_id."'";
	$content_arr = array("ID","Text","Created By","Last Updated");
	$load_qry = "select id,msg,created_by,last_updated from tbl_smsgw_template where `created_by`='".$user_id."' AND is_active='active'";
	$key = 'id';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
} elseif($edit_tbl == "smsgw_contactGroup"){
	$count_qry = "select count(id) from tbl_smsgw_contact_group where `created_by`='".$user_id."' AND is_active='active'";
	$content_arr = array("ID","Group Name","Created By","Last Updated");
	$load_qry = "select id,group_name,created_by,last_updated from tbl_smsgw_contact_group where `created_by`='".$user_id."' AND is_active='active'";
	$key = 'id';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
} elseif($edit_tbl == "smsgw_keyword"){
	$remoteCnQry="select * from tbl_process_db_access where pname='SMSGW'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);
	
	$cn=$remoteCn=connectDB();
	
	$count_qry = "SELECT count(keyword) FROM `keyword`";
	$content_arr = array("ID","Keyword","SMSText","SrcType","URL","ShortCode","Status");
	$load_qry = "SELECT `id`,`keyword`,`SMSText`,`SrcType`,`URL`,`ShortCode`,`Status` FROM `keyword`";
	
	$search_id = "";
  	if(isset($_REQUEST['kw_search_bar'])){
		$search_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['kw_search_bar']));
		$count_qry .= " where keyword like '%$search_id%'";
		$load_qry .= " where keyword like '%$search_id%'";
	}
	
	$key = 'id';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
} elseif($edit_tbl == "smsgw_shortcode"){
	$remoteCnQry="select * from tbl_process_db_access where pname='SMSGW'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);
	
	$cn=$remoteCn=connectDB();
	
	$count_qry = "SELECT count(shortcode) FROM `shortcode`";
	$content_arr = array("shortcode","ErrorSMS","DefaultKeyword");
	$load_qry = "SELECT `shortcode`,`ErrorSMS`,`DefaultKeyword` FROM `shortcode`";
	$key = 'shortcode';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
}
else if($edit_tbl == "role_manager"){
	$count_qry = "select count(id) from tbl_roles";
	$content_arr = array("ID","Name");
	$load_qry = "select id,rolename from tbl_roles where is_active='active' and id > '1'";
	$key = 'id';
	$extraBtn = false;
	$deleteOption = false;
	$editOption = true;
} else if($edit_tbl=="tbl_user"){
	 $count_qry = "select count(user_id) from tbl_user where user_id > 1";
	$content_arr = array("ID","User Name","Role Name","User ID","Email");
	$load_qry = "select tu.user_id,tu.UserName,tr.rolename,tu.UserID,tu.Email 
	FROM tbl_user tu
	INNER JOIN tbl_roles tr ON tu.role_id=tr.id where tu.user_id > 1";
	$key = 'user_id';
	$extraBtn = false;
	$deleteOption = true;
	$editOption = true;
} else if($edit_tbl=="content_list"){
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
	$count_qry = "select count(ContentID) from content";
	if($ROLE_ID != "1") $count_qry .= " where `CategoryID` in (select `CategoryID` from categorypermission where `CPID`='".$CP_ID."' and `HasPermission`='Yes')";
	$content_arr = array("ID","Content","Title","Description","Content Type","Activation Date","Deactivation Date","Status");
	$load_qry = "SELECT `ContentID`,`ContentName`,`Title`,`Description`,`ContentTypeID`,`ActivationDate`,`DeactivationDate`,`Status` FROM content";
	if($ROLE_ID != "1") $load_qry .= " where `CategoryID` in (select `CategoryID` from categorypermission where `CPID`='".$CP_ID."' and `HasPermission`='Yes')";
	$load_qry .= " ORDER BY ContentID DESC";
	$key = 'ContentID';
	$extraBtn = true;
	$editOption = true;
	$deleteOption = true;
	$extraBtnText = "Send";
	
} else if($edit_tbl == "content_permission"){
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
	$count_qry .= " where `ContentName Like '%".$content_name."%' and `Status`='pending'";
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
       // $extraBtnCnd['content_type'] = 'sms';
} elseif($edit_tbl == "cms_timeSlot"){
	
	$remoteCnQry="select * from tbl_process_db_access where pname='CMS'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);
	
	$cn=$remoteCn=connectDB();
	
	$count_qry = "select count(TimeSlotID) from `timeslot`";
	$content_arr = array("Unique ID","Timeslot ID","Start Day","End Day","Start Time","End Time");
	$load_qry = "select `UniqueID`,`TimeSlotID`,`StartDay`,`EndDay`,`StartTime`,`EndTime` from `timeslot` ";
	$key = 'UniqueID';
	$editOption = true;
	$deleteOption = true;
	$extraBtn = false;
	$extraBtnText = "";
} else if($edit_tbl=="tbl_cms_account"){
	
	$count_qry = "select count(id) from tbl_cms_account";
	$content_arr = array("ID","Name","Email");
	$load_qry = "SELECT id,name,email FROM  tbl_cms_account ORDER BY id ASC";
	$key = 'id';
	$extraBtn = false;
	$editOption = true;
	$deleteOption = true;
	$extraBtnText = NULL;
	
} else if($edit_tbl=="tbl_cms_category"){
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
	$count_qry = "select count(CategoryID) from category";
	$content_arr = array("ID","Name","Prompt","Status");
	$load_qry = "SELECT `CategoryID`,`CategoryName`,`Prompt`,`Status` FROM  category ORDER BY `CategoryID` ASC";
	$key = 'CategoryID';
	$extraBtn = false;
	$editOption = true;
	$deleteOption = true;
	$extraBtnText = NULL;
	
} else if($edit_tbl=="cp"){
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

	$count_qry = "select count(CPID) from contentprovider";
	$content_arr = array("ID","Name","Address");
	$load_qry = "SELECT CPID,CPName,CPAddress FROM contentprovider ORDER BY CPID DESC";
	$key = 'CPID';
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

	if(tbl == "ch_call_routing"){
	get_ch_call_routing([ "status" ]);
	set_value("action","update",selector_type_id);
	}
	else if(tbl == "ch_channelmap"){
	get_user_data("modules/ch/get_channel_map",["action_id"]);
	set_value("action","update",selector_type_id);
	}
	else if(tbl == "smsgw_account_manager"){
	get_smsgw_account_info();
	set_value("action","update",selector_type_id);
	}
	else if(tbl == "smsgw_account_template"){
	get_smsgw_account_template([ "status" ]);
	set_value("action","update",selector_type_id);
	}
	else if(tbl == "cgw_callType"){
	get_cgw_callType([ "status" ]);
	set_value("action","update",selector_type_id);
	}
	else if(tbl == "cgw_counter"){
	get_cgw_counter_info();
	set_value("action","update",selector_type_id);
	}
	else if(tbl == "cgw_accumulator"){
	get_cgw_accumulator_info();
	get_cgw_counter_list();
	set_value("action","update",selector_type_id);
	}
	else if(tbl == "cgw_timeSlot"){
	get_cgw_timeSlot([ "status" ]);
	set_value("action","update",selector_type_id);
	}
	else if(tbl == "cms_timeSlot"){
	get_user_data("modules/cms/get_cms_timeSlot",["action_id"]);
	set_value("action","update",selector_type_id);
	}
	else if(tbl == "cgw_rc_servicePromo"){
	get_cgw_rc_servicePromo([ "status" ]);
	set_value("action","update",selector_type_id);
	}
	else if(tbl == "smsgw_contactGroup"){
	get_smsgw_contactGroup([ "status" ]);
	set_value("action","update",selector_type_id);
	}
	else if(tbl == "smsgw_keyword"){
	get_smsgw_keyword([ "status" ]);
	set_value("action","update",selector_type_id);
	} else if(tbl == "smsgw_shortcode"){
	//get_smsgw_shortcode([ "status" ]);
	get_user_data("modules/smsgw/get_smsgw_shortcode",["action_id"]);
	set_value("action","update",selector_type_id);
	} else if(tbl=="role_manager"){
	get_user_data("modules/cms/get_role_manager",["action_id"]);
	set_value("action","update",selector_type_id);
	} else if(tbl=="cp"){
	get_user_data("modules/cms/get_cp",["action_id"]);
	set_value("action","update",selector_type_id);
	} else if(tbl=="tbl_user"){
	get_user_data("modules/cms/get_user_data",["action_id"]);
	set_value("action","update",selector_type_id);
	$("#user_id").prop("disabled","disabled");
	//$("#role_id").prop("disabled","disabled");
	//$("#password").prop("disabled","disabled");
	//console.log(get_value("#action"));
	}else if(tbl=="content_list"){

	get_user_data("modules/cms/get_content_data",["action_id"]);
	set_value("action","update",selector_type_id);
	var val=get_value("#category_id");
	$("#category_id").prop("disabled","disabled");
	choose_cms_content($("#c_type").val());
	//console.log(get_value("#action"));
	} else if(tbl=="tbl_cms_account"){

	get_user_data("modules/cms/get_cms_account_data",["action_id"]);
	set_value("action","update",selector_type_id);

	$("#cpid").prop("disabled","disabled");
	// console.log(get_value("#action"));
	}else if(tbl=="tbl_cms_category"){


	get_user_data("modules/cms/get_category_requestsource_and_cp",["action_id"]);
	set_content_provider("modules/cms/get_content_provider1",["action_id"]);
	set_request_source("modules/cms/get_request_source1",["action_id"]);

	//alert(get_value("#cph"));

	set_value("action","update",selector_type_id);

	$("#category_name").prop("disabled","disabled");
	console.log(get_value("#action"));
	} else if(tbl=="content_permission"){
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
	r=confirm("Are you sure you want to delete this?");

	if (r==true){
	//var data = "action="+tbl+"&value="+value;
	if(tbl == "ch_call_routing"){
	var data = "action=delete&action_id="+value;

	$.post("modules/ch/submit_call_routing.php",data,function(response){
	if(response == 0){
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");
	set_value("action","insert",selector_type_id);

	} else {
	alert("Deletion failed");
	}
	});
	}
	else if(tbl == "ch_channelmap"){
	var data = "action=delete&action_id="+value;

	$.post("modules/ch/submit_channel_map.php",data,function(response){
	if(response == 0){
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");
	set_value("action","insert",selector_type_id);

	} else {
	alert("Deletion failed");
	}
	});
	}
	else if(tbl == "smsgw_account_manager"){
	var data = "action=delete&action_id="+value;

	$.post("modules/smsgw/submit_account_manager.php",data,function(response){
	if(response == 0){
	set_value("action","insert",selector_type_id);
	set_value("action_id","",selector_type_id);
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");

	} else {
	alert("Deletion failed");
	}
	});
	} else if(tbl == "smsgw_account_template"){
	var data = "action=delete&action_id="+value;

	$.post("modules/smsgw/submit_smsgw_account_template.php",data,function(response){
	if(response == 0){
	set_value("action","insert",selector_type_id);
	set_value("action_id","",selector_type_id);
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");

	} else {
	alert("Deletion failed");
	}
	});
	} else if(tbl == "cgw_callType"){
	var data = "action=delete&action_id="+value;

	$.post("modules/cgw/submit_cgw_callType.php",data,function(response){
	if(response == 0){
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");
	set_value("action","insert",selector_type_id);
	set_value("action_id","",selector_type_id);

	} else {
	alert("Deletion failed");
	}
	});
	} else if(tbl == "cgw_counter"){
	var data = "action=delete&action_id="+value;

	$.post("modules/cgw/submit_cgw_counter.php",data,function(response){
	if(response == 0){
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");
	set_value("action","insert",selector_type_id);
	set_value("action_id","",selector_type_id);

	} else {
	alert("Deletion failed");
	}
	});
	} else if(tbl == "cgw_accumulator"){
	var data = "action=delete&action_id="+value;

	$.post("modules/cgw/submit_cgw_accumulator.php",data,function(response){
	if(response == 0){
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");
	set_value("action","insert",selector_type_id);
	set_value("action_id","",selector_type_id);

	} else {
	alert("Deletion failed");
	}
	});
	} else if(tbl == "cgw_timeSlot"){
	var data = "action=delete&action_id="+value;

	$.post("modules/cgw/submit_cgw_timeSlot.php",data,function(response){
	if(response == 0){
	set_value("action","insert",selector_type_id);
	set_value("action_id","",selector_type_id);
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");

	} else {
	alert("Deletion failed");
	}
	});
	} else if(tbl == "cms_timeSlot"){
	var data = "action=delete&action_id="+value;

	$.post("modules/cms/submit_cms_timeSlot.php",data,function(response){
	if(response == 0){
	set_value("action","insert",selector_type_id);
	set_value("action_id","",selector_type_id);
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");

	} else {
	alert("Deletion failed");
	}
	});
	} else if(tbl == "cgw_rc_servicePromo"){
	var data = "action=delete&action_id="+value;

	$.post("modules/cgw/submit_cgw_rc_servicePromo.php",data,function(response){
	if(response == 0){
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");

	} else {
	alert("Deletion failed");
	}
	});
	} else if(tbl == "smsgw_contactGroup"){
	var data = "action=delete&action_id="+value;

	$.post("modules/smsgw/submit_smsgw_contactGroup.php",data,function(response){
	if(response == 0){
	set_value("action","insert",selector_type_id);
	set_value("action_id","",selector_type_id);
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");

	} else {
	alert("Deletion failed");
	}
	});
	} else if(tbl == "smsgw_keyword"){
	var data = "action=delete&action_id="+value;

	$.post("modules/smsgw/submit_smsgw_keyword.php",data,function(response){
	if(response == 0){
	set_value("action","insert",selector_type_id);
	set_value("action_id","",selector_type_id);
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");

	} else {
	alert("Deletion failed");
	}
	});
	} else if(tbl == "smsgw_shortcode"){
	var data = "action=delete&action_id="+value;

	$.post("modules/smsgw/submit_smsgw_shortcode.php",data,function(response){
	if(response == 0){
	set_value("action","insert",selector_type_id);
	set_value("action_id","",selector_type_id);
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");

	} else {
	alert("Deletion failed");
	}
	});
	} else if(tbl=="tbl_user"){

	var data = "action=delete&action_id="+value;

	$.post("modules/cms/fileupload.php",data,function(response){
	if(response == 0){
	set_value("action","insert",selector_type_id);
	set_value("action_id","",selector_type_id);
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");

	} else {
	alert("Deletion failed");
	}
	});
	} else if(tbl=="content_list"){

	var data = "action=delete&action_id="+value;

	$.post("modules/cms/content_upload.php",data,function(response){
	if(response == 0){
	set_value("action","insert",selector_type_id);
	set_value("action_id","",selector_type_id);
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");

	} else {
	alert("Deletion failed");
	}
	});
	} else if(tbl=="tbl_cms_account"){

	var data = "action=delete&action_id="+value;

	$.post("modules/cms/save_account_data.php",data,function(response){
	if(response == 0){
	set_value("action","insert",selector_type_id);
	set_value("action_id","",selector_type_id);
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");

	} else {
	alert("Deletion failed");
	}
	});
	} else if(tbl=="content_permission"){

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
	} else if(tbl=="tbl_cms_category"){

	var data = "action=delete&action_id="+value;

	$.post("modules/cms/save_category_and_services.php",data,function(response){
	if(response == 0){
	set_value("action","insert",selector_type_id);
	set_value("action_id","",selector_type_id);
	set_value("category_name","",selector_type_id);
	set_value("prompt","",selector_type_id);
	set_value("post_prompt","",selector_type_id);
	set_value("display_order","",selector_type_id);
	set_value("active","",selector_type_id);
	set_value("parent","",selector_type_id);



	set_value("pre_prompt","",selector_type_id);
	set_value("ivr_string","",selector_type_id);
	set_value("deactive","",selector_type_id);

	$("#cp option:selected").removeAttr("selected");
	$("#source option:selected").removeAttr("selected");

	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");

	} else {
	alert("Deletion failed");
	}
	});
	} else if(tbl == "cp"){
	var data = "action=delete&action_id="+value;

	$.post("modules/cms/submit_cp.php",data,function(response){
	if(response == 0){
	alert("Deleted successfully");
	$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");

	} else {
	alert("Deletion failed");
	}
	});
	}
	}
	}else if(action == "extra") {

	if( tbl == 'content_permission'){
	set_value("current_src_holder",value,selector_type_id);
	var audio_src = get_prompt_location("modules/cms/get_prompt_location",["current_src_holder"]);
	$("#play").attr({src:audio_src});
	$("#audio_id").load();
	$("#playfile").dialog("open");
	$("#playfile").css({'display':'block'});
	// console.log("Src::",$("#play").attr('src'));

	} else if(tbl=="content_list"){
	var data = "action=extra&action_id="+value;

	$.post("modules/cms/send_content.php",data,function(response){
	alert(response);

	});
	}
	}
	});
	});


</script>