<?php
set_time_limit(0); 
require_once(".././commonlib.php");

$available_version = 0;
$available_version_name = 0;
$curr_version = 0;

if(isset($_REQUEST['available_version'])){
	$available_version = mysql_real_escape_string(htmlspecialchars($_REQUEST['available_version']));
}

if(isset($_REQUEST['available_version_name'])){
	$available_version_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['available_version_name']));
}

if(isset($_REQUEST['curr_version'])){
	$curr_version = mysql_real_escape_string(htmlspecialchars($_REQUEST['curr_version']));
}

// UPGRADE Functions
function start_upgrade($cn){
	log_generator("SYSTEM UPGRADE PROCESS START");
	update_db_upgrade_status($cn,"0");
	db_export($cn);
	files_export($cn);
	download_zip_file($cn);
	unzip_file($cn);
	db_import($cn);
	files_import($cn);
	shell_file_run();
	log_generator("SYSTEM UPGRADE PROCESS END");
}

// Upgrade Status update
function update_db_upgrade_status($cn,$completed_step,$upgrade_status="processing"){
	global $available_version;
	global $available_version_name;
	if($upgrade_status=="no"){ 
		$select_qry = "select total_step,auto_upgrade from ugw_version.version where is_active='active'";
		$rs = Sql_fetch_array(Sql_exec($cn, $select_qry));
		$total_step = $rs['total_step'];
		$auto_upgrade = $rs['auto_upgrade'];
		
		$update_qry = "update ugw_version.version set upgrade_status='$upgrade_status',completed_step='$completed_step',is_active='inactive',last_updated=now()";
		$update_qry .= " where is_active='active'";
		Sql_exec($cn, $update_qry);
		$qry = "insert into ugw_version.version ( version_name, curr_version, available_version_name, available_version, upgrade_status, completed_step,";
		$qry .= " total_step,auto_upgrade,last_updated,is_active) values  ";
		$qry .= "('$available_version_name','$available_version','$available_version_name',";
		$qry .= "'$available_version','no','0','$total_step','$auto_upgrade',now(),'active') ";
	} else {
		$qry = "update ugw_version.version set upgrade_status='$upgrade_status',completed_step='$completed_step'";
		$qry .= " where is_active='active'";
	}
	
	try {
		Sql_exec($cn, $qry);
	} catch (Exception $e) {
    	echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}

// STEP 1
function db_export($cn){
	global $MYSERVER;
	global $MYUID;
	global $MYPASSWORD;
	global $MYDB;
	global $LATEST_FILES_BACKUP_PATH;
	global $curr_version;
	
	$mysqlHostName = $MYSERVER;
	$mysqlUserName = $MYUID;
	$mysqlPassword = $MYPASSWORD;
	$mysqlDatabaseName = $MYDB;
	//$current_datetime = date("Y-m-d",strtotime("now"));
	
	//$mysqlExportPath = $LATEST_FILES_BACKUP_PATH.$mysqlDatabaseName.".sql";
	$mysqlExportPath = $LATEST_FILES_BACKUP_PATH.$curr_version."/DB/".$mysqlDatabaseName.".sql";
	$is_error = 0;
	shell_exec("sudo mkdir ".$LATEST_FILES_BACKUP_PATH.$curr_version);
	shell_exec("sudo mkdir ".$LATEST_FILES_BACKUP_PATH.$curr_version."/DB");
	shell_exec("sudo chmod -R 0777 ".$LATEST_FILES_BACKUP_PATH.$curr_version."/DB/");
	// Database Backup
	$DB_export_cmd="mysqldump --opt -h" .$mysqlHostName ." -u" .$mysqlUserName ." -p" .$mysqlPassword ." " .$mysqlDatabaseName ." --routines > " .$mysqlExportPath;
	exec($DB_export_cmd,$output1=array(),$worked);
	
	$msg = "";
	if($worked == 0){
		
		//$command = "sudo cp -r ".$mysqlExportPath." ".$file_replace_path;
		//shell_exec($command);
		update_db_upgrade_status($cn,"1");
		$msg =  "Database EXPORT Successfully Done";
	} else {
		$is_error = 1;
		$msg =  "Database EXPORT Failed";
	}
	
	if($is_error){
		echo $msg."\n";
	} 
	log_generator($msg);
}

// STEP 2
function files_export($cn){
	global $CURRENT_FILE_HOSTING_PATH;
	global $LATEST_FILES_BACKUP_PATH;
	global $curr_version;
	
	shell_exec("sudo mkdir ".$LATEST_FILES_BACKUP_PATH.$curr_version."/files");
	shell_exec("sudo chmod -R 0777 ".$LATEST_FILES_BACKUP_PATH.$curr_version."/files/");
	$backup_command = "sudo cp -r ".$CURRENT_FILE_HOSTING_PATH."* ".$LATEST_FILES_BACKUP_PATH.$curr_version."/files/";
	$msg = "";
	try {
		$is_error = 0;
		shell_exec($backup_command);
		update_db_upgrade_status($cn,"2");
		$msg = "FILE EXPORT Successfully Done";
	} catch (Exception $e){
		$is_error = 1;
		$msg = "FILE EXPORT Failed";
	}
	if($is_error){
		echo $msg."\n";
	}
	log_generator($msg);
}

// STEP 3
function download_zip_file($cn){
	global $UPGRADE_SOURCE_FILE_PATH;
	global $UPGRADE_DESTINATION_FILE_PATH;
	global $available_version;
	
	$msg = "";
	try {
		$download_command = "sudo wget -O ".$UPGRADE_DESTINATION_FILE_PATH." ".$UPGRADE_SOURCE_FILE_PATH."v-".$available_version.".zip";
		shell_exec($download_command);
		update_db_upgrade_status($cn,"3");
		$msg = "Download ZIP file Successfully Done";
	} catch (Exception $e){
		$is_error = 1;
		$msg = "Download ZIP file Failed";
	}
	if($is_error){
		echo $msg."\n";
	}
	log_generator($msg);
}

// STEP 4
function unzip_file($cn){
	global $UPGRADE_DESTINATION_FILE_PATH;
	global $DEFAULT_SOURCE_FILES;
	global $available_version;
	
	$file_unzip_command = "sudo unzip ".$UPGRADE_DESTINATION_FILE_PATH."  -d ".$DEFAULT_SOURCE_FILES."/".$available_version."/";
	
	$msg = "";
	try {
		$is_error = 0;
		shell_exec($file_unzip_command);
		update_db_upgrade_status($cn,"4");
		$msg = "File Unzip Done";
	} catch (Exception $e){
		$is_error = 1;
		$msg = "File Unzip Failed";
	}
	if($is_error){
		echo $msg."\n";
	}
	log_generator($msg);
}

// STEP 5
function db_import($cn){
	global $MYSERVER;
	global $MYUID;
	global $MYPASSWORD;
	global $MYDB;
	global $DEFAULT_SOURCE_FILES;
	global $available_version;
	global $LATEST_FILES_BACKUP_PATH;
	
	$mysqlHostName = $MYSERVER;
	$mysqlUserName = $MYUID;
	$mysqlPassword = $MYPASSWORD;
	$mysqlDatabaseName = $MYDB;  
	$mysqlImportFilename = $DEFAULT_SOURCE_FILES."/".$available_version."/DB/".$MYDB.".sql";
	
		// Database Import
		$command='mysql -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' < ' .$mysqlImportFilename;
		exec($command,$output3=array(),$worked);
		
		$msg = "";	
		if($worked == 0){
			update_db_upgrade_status($cn,"5");
			$msg = "Database SQL Import Done";
		} else {
			$msg = "Database SQL Import Failed";
		}
		log_generator($msg);
}

// STEP 6
function files_import($cn){
	global $DEFAULT_SOURCE_FILES;
	global $CURRENT_FILE_HOSTING_PATH;
	global $available_version;
	
	shell_exec("sudo rm -rf ".$CURRENT_FILE_HOSTING_PATH."/*");
	$backup_command = "sudo cp -r ".$DEFAULT_SOURCE_FILES.$available_version."/files/* ".$CURRENT_FILE_HOSTING_PATH;
	try {
		$is_error = 0;
		shell_exec($backup_command);
		update_db_upgrade_status($cn,"6","no");
		$msg = "FILE IMPORT Successfully Done";
	} catch (Exception $e){
		$is_error = 1;
		$msg = "FILE IMPORT Failed";
	}
	if($is_error){
		echo $msg."\n";
	}
	log_generator($msg);
}

$cn = connectDB();
	start_upgrade($cn);
ClosedDBConnection($cn);
echo '0';
?>