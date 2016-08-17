<?php
require_once ".././commonlib.php";
$file_extension = strrev(strtok(strrev($_FILES['uploadfile']['name']),'.'));

$file = $DEFAULT_SOURCE_FILES.'store-'.date("Y-m-d_H-i-s").'.'.$file_extension; //basename($_FILES['uploadfile']['name']); 

if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
	$is_valid = 1;  
} else {  
	$is_valid = 0;
} 

if($is_valid){
	$cn = connectDB();
		$return = db_import($cn,$file);
	ClosedDBConnection($cn);
	shell_file_run();
} else {
	$return = "File import failed";
}

function db_import($cn,$file){
	global $MYSERVER;
	global $MYUID;
	global $MYPASSWORD;
	global $MYDB;
	
	$mysqlHostName = $MYSERVER;
	$mysqlUserName = $MYUID;
	$mysqlPassword = $MYPASSWORD;
	$mysqlDatabaseName = $MYDB;  
	$mysqlImportFilename = $file;
	
		// Database Import
		$command='mysql -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' < ' .$mysqlImportFilename;
		exec($command,$output3=array(),$worked);
		
		$msg = "";	
		if($worked == 0){
			$msg = "Successfully Completed";
		} else {
			$msg = "Database SQL Import Failed";
		}
		// log_generator($msg);
		return $msg;
}

echo $return;
?>