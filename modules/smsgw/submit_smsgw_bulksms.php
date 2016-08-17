<?php
session_start();
require_once "../.././commonlib.php";
require_once "../.././".$FILE_WRITER_LIB;

if (isset($_POST))
{
	$user_id = $_SESSION['USER_ID'];
	
	$cn = connectDB();
	$action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	
	$is_error = 0;
	$err_field = array();
	$count = 0;
	$seperator = "";
	
	if($action == "insert" ){
		$qry = "insert into tbl_smsgw_msg_permission (";	
		$values = "";	
	} elseif($action == "update") {
		$qry = "update tbl_smsgw_msg_permission set ";		
	} elseif($action == "delete"){
		$qry = "delete from tbl_smsgw_msg_permission where id='$action_id'";
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
		$qry .= ",last_updated_by,last_updated) values (".$values.",'".$user_id."',NOW())";
	} elseif($action == "update") {
		$qry .= "  where id = '$action_id'";
	}
	
	try {
		$res = Sql_exec($cn,$qry);
	} catch (Exception $e){
		$is_error = 1;
		array_push($err_field,$qry);
	}
	
	foreach($err_field as $e_val){
		$is_error .= "|".$e_val;
	} 
	
	echo $is_error;
	
	ClosedDBConnection($cn);
}

?>