<?php
session_start();
require_once "../.././commonlib.php";

$ROLE_ID = $_SESSION['ROLE_ID'];
$CP_ID = $_SESSION['CP_ID'];
$UserID = $_SESSION['USER_ID'];

$cn = connectDB();

$requestType=mysql_real_escape_string(htmlspecialchars($_POST['request_type']));
$And="";
if(isset($requestType) && $requestType){
		$And = " AND reporting_type='$requestType'";
}else{
        $And="";
}

$query = "SELECT dwh_request_source_id, source_name, db_type, db_server, db_user_name, db_password, db_name 
		  FROM tbl_cms_requestsource_dwh 
		  WHERE dwh_request_source_id IN 
		  (SELECT dwh_request_source_id FROM tbl_cms_requestsource_dwh_permission WHERE is_active='active'";
if($ROLE_ID != "1") $query .= " and `cpid`='$CP_ID'";
$query .= ") 
		   AND is_active='active' ".$And;

$data=array();
$res=Sql_exec($cn,$query);
while($dt = Sql_fetch_array($res))
{
	$data[$dt['dwh_request_source_id']]=$dt['source_name'];

}

ClosedDBConnection($cn);
echo json_encode($data);
?>