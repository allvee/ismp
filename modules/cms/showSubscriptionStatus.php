<?php
session_start();
require_once "../.././commonlib.php";
/*$operator_id=$_REQUEST['operator_id'];
$service_id=$_REQUEST['service_id'];
$frmdate=$_REQUEST['from_id'];
$todate=$_REQUEST['to_id'];
$UserID=$_SESSION['USER_ID'];
$frmdate = date( 'Y-m-d', strtotime($frmdate))." 00:00:00";
$todate = date( 'Y-m-d', strtotime($todate))." 23:59:59";*/
	


$cn = connectDB();
echo "danial"
/*$And = "";
	if($service_id == "All")
	{
		$out="";
		
		$query = "SELECT subscription_group_id FROM tbl_cms_subscriptiongroup
		WHERE id IN (SELECT subscription_group_id FROM tbl_cms_subscriptiongroup_permission  WHERE user_id='$UserID' AND is_active='active')";
		
		
        $res=Sql_exec($cn,$query);
		while($dt = Sql_fetch_array($res))
		{
			if($out != "") $out .= ",";
			$out .= "'".$dt['subscription_group_id']."'";
		}
		
		if($out != "")
		{
			$And = " AND subscriptiongroupid IN ($out)"; // ('2','5','7')
		}
	}
	else if(isset($service_id))
	{
		$And = " AND subscriptiongroupid='$service_id' ";
	}else{
	   	
	}*/



/*	
$qry_server = "SELECT source_name, db_type, db_server, db_user_name, db_password, db_name 
FROM tbl_cms_requestsource_dwh WHERE dwh_request_source_id='$operator_id' limit 1";
$res=Sql_exec($cn,$qry_server);
$dt= Sql_fetch_array($res);
echo json_encode($dt);*/
ClosedDBConnection($cn);
















?>