<?php
session_start();
require_once "../.././commonlib.php";
require_once "../.././".$FILE_WRITER_LIB;

if (!empty($_POST))
{
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
	$action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	
	$is_error = 0;
	$err_field = array();
	$count = 0;
	$seperator = "";
	
	if($action == "insert" ){
		$qry = "insert into `subscriptiongroup` (";	
		$values = "";	
	} elseif($action == "update") {
		$qry = "update `subscriptiongroup` set ";		
	} elseif($action == "delete"){
		$qry = "delete from `subscriptiongroup` where `SubscriptionGroupID`='".$action_id."'";
	}
	

	foreach($_POST as $pname => $pvalue){
		$pname = mysql_real_escape_string(htmlspecialchars(trim($pname)));
		$$pname = mysql_real_escape_string(htmlspecialchars(trim($pvalue)));
			
		if(!($pname == "action" || $pname == "action_id")){
			if($count>0){
				$seperator = ",";
			}
			
			if($action == "insert"){
				$qry .= $seperator.$pname;
				//$values .= $seperator."'".$$pname."'";
				if($$pname=='Null')
				{
					$values .= $seperator.'NULL';
				}
				else
				{
					$values .= $seperator."'".$$pname."'";
				}
				
			} elseif($action == "update") {
				//$qry .= $seperator." ".$pname."='".$$pname."'";
				
				//$qry .= $seperator.$pname;
				if($$pname=='Null')
				{
					$qry .= $seperator." ".$pname."=NULL";
					//$values .= $seperator.'NULL';
				}
				else
				{
					$qry .= $seperator." ".$pname."='".$$pname."'";
				}
				
			}
			$count++;
		}
	}
	
	if($action == "insert"){
		$qry .= ") values (".$values.")";
	} elseif($action == "update") {
		$qry .= "  where SubscriptionGroupID = '$action_id'";
	}

	
	
	try {
		$res = Sql_exec($remoteCn,$qry);
	} catch (Exception $e){
		$is_error = 1;
		array_push($err_field,$qry);
	}
	
	foreach($err_field as $e_val){
		$is_error .= "|".$e_val;
	} 
	
	echo $is_error;
	
	// Ignore it!
	try {
		$res = Sql_exec($remoteCn,"Delete from servicemapping where `SubscriptionRoot`='$ParentID'");
		if(trim($CMSSeviceID) != "")
			$res = Sql_exec($remoteCn,"insert into servicemapping (`SubscriptionRoot`,`CMSServiceID`,`Status`,`UserID`,`LastUpdate`) values ('$ParentID','$CMSSeviceID','Active','$UserID',NOW())");
	} catch (Exception $e){
		$is_error = 1;
		//array_push($err_field,$qry);
	}
	if($remoteCn)ClosedDBConnection($remoteCn);
}

?>