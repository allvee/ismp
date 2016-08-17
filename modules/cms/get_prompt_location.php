<?php
session_start();

include_once "../../commonlib.php";

$cn = connectDB();
$is_error = 0;
$location = "";
$id = mysql_real_escape_string(htmlspecialchars($_REQUEST['current_src_holder']));

$qry = "SELECT prompt FROM tbl_cms_content WHERE content_id = '$id'";
try{
$rs = Sql_exec($cn, $qry);
$dt = Sql_fetch_array($rs); 
$location = $dt['prompt'];
}catch(Exception $e){
    $is_error = 1;	
}

ClosedDBConnection($cn);
if( $is_error == 1 ) echo $is_error;
else {
	echo $location;
}
?>