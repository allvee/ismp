<?php
session_start();
require_once "../.././commonlib.php";
require_once "../.././".$FILE_WRITER_LIB;

if (!empty($_POST))
{
	$is_error = 0;
	$err_field = array();
	$cn = connectDB();
	
	foreach($_POST as $pname => $pvalue){
		$pname = mysql_real_escape_string(htmlspecialchars($pname));
		$pvalue = mysql_real_escape_string(htmlspecialchars($pvalue));
		
		if(!($pname == "action" || $pname == "action_id")){
			$qry = "update tbl_cgw_configuration set pvalue = '$pvalue' where pname='$pname' and is_active='active'";
			try {
				Sql_exec($cn,$qry);
				log_generator("Success QRY :: ".$qry,__FILE__,__FUNCTION__,__LINE__,NULL);
			} catch (Exception $e){
				$is_error = 1;
				array_push($err_field,$pname);
				log_generator("Failed QRY :: ".$qry,__FILE__,__FUNCTION__,__LINE__,NULL);
			}
		}
	}
	
	file_writer_cgw_configuration($cn);
	
	foreach($err_field as $e_val){
		$is_error .= "|".$e_val;
	} 
	
	echo $is_error;
	
	ClosedDBConnection($cn);
}

?>