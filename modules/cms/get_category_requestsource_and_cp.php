<?php
session_start();
include_once "../../commonlib.php";
$cn = connectDB();
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
	
	if(isset($_POST))
	{
		$action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
		$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
		
		$value_arr = array();
		
		$qry="SELECT `CategoryName`,`ParentID`,`Prompt`,`Pre-Prompt`,`Post-Prompt`,`IVR-String`,`DisplayOrder`,`ActivationDate`,
		`DeactivationDate`,`Status` FROM category where CategoryID='$action_id'";
		
		$rs = Sql_exec($cn, $qry);
		$dt = Sql_fetch_array($rs);
		$value_arr['category_name']=$dt['CategoryName'];
		$value_arr['parent']=$dt['ParentID'];
		$value_arr['prompt']=$dt['Prompt'];
		$value_arr['pre_prompt']=$dt['Pre-Prompt'];
		$value_arr['post_prompt']=$dt['Post-Prompt'];
		$value_arr['ivr_string']=$dt['IVR-String'];
		$value_arr['display_order']=$dt['DisplayOrder'];
		$value_arr['active']=$dt['ActivationDate'];
		$value_arr['deactive']=$dt['DeactivationDate'];
		$value_arr['status']=$dt['Status'];
		
		try {
			$qry="SELECT `TimeSlotID` FROM service where ServiceID='$action_id'";
			
			$rs = Sql_exec($cn, $qry);
			$dt = Sql_fetch_array($rs);
			$value_arr['timeslot_id']=$dt['TimeSlotID'];
		} catch (Exception $e){
			
		}
		
		echo json_encode($value_arr);
	
	}


ClosedDBConnection($cn);


?>