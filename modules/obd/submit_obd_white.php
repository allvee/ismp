<?php
session_start();
require_once "../.././commonlib.php";
require_once "../.././".$FILE_WRITER_LIB;

if (!empty($_POST))
{
	$action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));

	//$server_id =$action_id;


	$arr = explode("S", $action_id);
	$server_id = $arr[1];
	$arr[0] = str_replace('D', '-', $arr[0]);
	$arr[0] = str_replace('T', ' ', $arr[0]);
	$time_stamp = str_replace('C', ':', $arr[0]);
	
			
	$is_error = 0;
	$err_field = array();
	$count = 0;
	$seperator = "";
	$user_id = $_SESSION['USER_ID'];
	if($action == "insert" ){
		$qry = "insert into tbl_obd_white_list (";	
		$values = "";	
	} elseif($action == "update") {
		$qry = "update tbl_obd_white_list set ";		
	} elseif($action == "delete"){
		//$qry = "DELETE FROM `tbl_obd_white_list` WHERE `user_id`='".$user_id."' AND `server_id`='".$server_id."'";
		$qry = "DELETE FROM `tbl_obd_white_list` WHERE `user_id`='".$user_id."' AND `server_id`='".$server_id."' AND `time_stamp`='".$time_stamp."'";
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
		$qry .= "  where is_active='active' and id = '$action_id'";
	}elseif($action == "delete") {
		//$qry = "DELETE FROM `tbl_obd_white_list` WHERE `user_id`='".$user_id."' AND `server_id`='".$server_id."'";
		$qry = "DELETE FROM `tbl_obd_white_list` WHERE `user_id`='".$user_id."' AND `server_id`='".$server_id."' AND `time_stamp`='".$time_stamp."'";

	}
	$cn = connectDB();
	
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