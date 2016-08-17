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
	
	$remoteCn=connectDB();
	
	$action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	
	$is_error = 0;
	$err_field = array();
	$count = 0;
	$seperator = "";
	
	if($action == "insert" ){
		$qry = "insert into `calltype` (";	
		$values = "";	
	} elseif($action == "update") {
		$qry = "update `calltype` set ";		
	} elseif($action == "delete"){
		//$qry = "update `calltype` set is_active='inactive' where is_active='active' and `id`='".$action_id."'";
		$qry = "delete from `calltype` where `CallTypeID`='".$action_id."'";
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
		$qry .= ") values (".$values.")";
	} elseif($action == "update") {
		$qry .= "  where  `CallTypeID` = '$action_id'";
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
	
	if($cn)ClosedDBConnection($cn);
	if($remoteCn)ClosedDBConnection($remoteCn);
}

?>