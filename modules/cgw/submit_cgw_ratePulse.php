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
//	$serviceId = mysql_real_escape_string(htmlspecialchars($_REQUEST['0']));
	
	$is_error = 0;
	$err_field = array();
	$count = 0;
	$seperator = "";
	
	$rateid = mysql_real_escape_string(htmlspecialchars($_POST['rateid']));
	if(isset($_POST['stepno']) && $_POST['stepno'] == 1){
		$qry = "DELETE from `ratepulse` where ";
		$qry .= " `rateid`='$rateid'"; 
		try {
			$res = Sql_exec($remoteCn,$qry);
		} catch (Exception $e){
			$is_error = 2;
			array_push($err_field,$qry);
		}
	}
	
	if($action == "insert" ){
		$qry = "insert into `ratepulse` (";	
		$values = "";	
	} elseif($action == "update") {
		$qry = "update `ratepulse` set ";		
	} elseif($action == "delete"){
		$qry = "update `ratepulse` set is_active='inactive' where is_active='active'";
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
		$qry .= "  where `UniqueID` = '$action_id'";
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