<?PHP
/**
 * Log Library
 * Version 1.0 (16.07.2014)
 * Author : Atanu Saha
 * Copyright (c) 2014 SSD-Tech Ltd., http://www.ssd-tech.com
 */

function log_generator($msg,$file,$function,$line,$cn=NULL){
	global $LOG_TYPE;
	global $LOG_HOLDER;
	
	if($LOG_TYPE == "FILE"){ 
		$log_file_name = $LOG_HOLDER . date("Y-m-d-H",strtotime("now")) . ".log";
		$current_datetime = date("Y-m-d H:i:s",strtotime("now"));
		if(!file_exists($log_file_name)){
			$ourFileName = $log_file_name;
			$ourFileHandle = fopen($ourFileName, 'w');
			$Data = "START AT ".$current_datetime."\n"; 
 			fwrite($Handle, $Data);
			fclose($ourFileHandle);
		}
		
		$data = file_get_contents($log_file_name);
		$data .= "[".$current_datetime."]  USER:: " . $_SESSION["LoggedInUserID"] . "(" . $_SESSION["USER_ID"] .")";
		$data .= " :: " . $msg . " :: " . $file . " :: " . $function . " :: " . $line . "\n";
		file_put_contents($log_file_name,$data);
	} elseif($LOG_TYPE == "DB"){
		$user = $_SESSION["LoggedInUserID"] . "(" . $_SESSION["USER_ID"] .")";
		$message = $msg . " :: " . $file . " :: " . $function . " :: " . $line;
		$qry = "insert into $LOG_HOLDER (user_info,message,date_time) values ('$user','$message',now())";
		Sql_exec($cn,$qry);
	}
}

?>