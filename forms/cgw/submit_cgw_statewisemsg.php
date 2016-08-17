<?php
session_start();
require_once "../.././commonlib.php";

if (!empty($_POST))
{
	$user_id = $_SESSION['USER_ID'];
	
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
	
	$remoteCn=connectDB();
	
	$action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	
	$is_error = 0;
	$err_field = array();
	$count = 0;
	$seperator = "";
	
	if($action == "insert" ){
		$qry = "insert into `statewisemsg` (";	
		$values = "";	
	} elseif($action == "update") {
		$qry = "update `statewisemsg` set ";		
	} elseif($action == "delete"){
		$qry = "delete from `statewisemsg` where `UniqueID`='".$action_id."'";
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
				$values .= $seperator."'".$$pname."'";
			} elseif($action == "update") {
				$qry .= $seperator." ".$pname."='".$$pname."'";
			}
			$count++;
		}
	}
	
	if($action == "insert"){
		$qry .= ",UserID,LastUpdate) values (".$values.",'".$user_id."',NOW())";
	} elseif($action == "update") {
		$qry .= ",UserID = '".$user_id."', LastUpdate=NOW()  where `UniqueID` = '$action_id'";
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
	
	ClosedDBConnection($remoteCn);
	
	echo $is_error;
	
	
}

?>