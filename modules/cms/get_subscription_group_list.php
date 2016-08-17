<?php
session_start();
require_once "../.././commonlib.php";

$ROLE_ID = $_SESSION['ROLE_ID'];
$CP_ID = $_SESSION['CP_ID'];	
$UserID = $_SESSION['USER_ID'];

$cn = connectDB();

$requestType=mysql_real_escape_string(htmlspecialchars($_POST['request_type']));
$pageType=mysql_real_escape_string(htmlspecialchars($_POST['page_type']));

	if($pageType=="subscription_status"){

		/*	$query = "SELECT subscription_group_name FROM tbl_cms_subscriptiongroup 
		  			  WHERE id IN 
		  			  (SELECT subscription_group_id FROM tbl_cms_subscriptiongroup_permission WHERE user_id='$UserID' AND is_active='active')  
		              AND is_active='active'";*/
			/*$qry="SELECT DISTINCT t1.subscription_group_name FROM tbl_cms_subscriptiongroup t1
				INNER JOIN tbl_cms_subscriptiongroup_permission t2 ON t1.id= t2.subscription_group_id WHERE t1.is_active='active' 
				AND t2.is_active='active' AND t2.user_id='$UserID'";*/
			$remoteCnQry="select * from tbl_process_db_access where pname='CGW'";
			$res = Sql_exec($cn,$remoteCnQry);
			$dt = Sql_fetch_array($res);
			
			$dbtype=$dt['db_type'];
			$MYSERVER=$dt['db_server'];
			$MYUID=$dt['db_uid'];
			$MYPASSWORD=$dt['db_password'];
			$MYDB=$dt['db_name'];
			ClosedDBConnection($cn);
			
			$cn=connectDB();
			$qry = "SELECT DISTINCT `ServiceID` FROM `subscriptiongroup`";
			if($ROLE_ID != "1") $qry .= " where `cpid`='$CP_ID'";
			
			$data=array();
			$res=Sql_exec($cn,$qry);
			while($dt = Sql_fetch_array($res))
			{
				$data[$dt['ServiceID']]=$dt['ServiceID'];
			
			}


			echo json_encode($data);
	}else if($pageType=="revenue_report"){
	
	      /* $query = "SELECT service_id FROM tbl_cms_subscriptiongroup 
		  			  WHERE id IN 
		  			  (SELECT subscription_group_id FROM tbl_cms_subscriptiongroup_permission WHERE user_id='$UserID' AND is_active='active')  
		              AND is_active='active'";*/
			/*$qry = "SELECT DISTINCT t1.service_id FROM tbl_cms_subscriptiongroup t1
						INNER JOIN tbl_cms_subscriptiongroup_permission t2 ON t1.id= t2.subscription_group_id WHERE t1.is_active='active' 
							AND t2.is_active='active' AND t2.user_id='$UserID'";*/
			$remoteCnQry="select * from tbl_process_db_access where pname='CGW'";
			$res = Sql_exec($cn,$remoteCnQry);
			$dt = Sql_fetch_array($res);
			
			$dbtype=$dt['db_type'];
			$MYSERVER=$dt['db_server'];
			$MYUID=$dt['db_uid'];
			$MYPASSWORD=$dt['db_password'];
			$MYDB=$dt['db_name'];
			ClosedDBConnection($cn);
			
			$cn=connectDB();
			$qry = "SELECT DISTINCT `ServiceID` FROM `subscriptiongroup`";
			if($ROLE_ID != "1") $qry .= " where `cpid`='$CP_ID'";
			$data=array();
			$res=Sql_exec($cn,$qry);
			while($dt = Sql_fetch_array($res))
			{
				$data[$dt['ServiceID']]=$dt['ServiceID'];
			
			}


			echo json_encode($data);
	}else if($pageType=="node_log_report"){
	
			
	    /*   $query = "SELECT nodelog_shortcode FROM tbl_cms_subscriptiongroup 
		  			  WHERE id IN 
		  			  (SELECT subscription_group_id FROM tbl_cms_subscriptiongroup_permission WHERE user_id='$UserID' AND is_active='active')  
		              AND is_active='active'";*/
			 $qry="SELECT DISTINCT t1.nodelog_shortcode FROM tbl_cms_subscriptiongroup t1
				INNER JOIN tbl_cms_subscriptiongroup_permission t2 ON t1.id= t2.subscription_group_id WHERE t1.is_active='active' 
				AND t2.is_active='active' AND t2.user_id='$UserID' AND t1.nodelog_shortcode IS NOT NULL";
			$data=array();
			$res=Sql_exec($cn,$qry);
			while($dt = Sql_fetch_array($res))
			{
				$data[$dt['nodelog_shortcode']]=$dt['nodelog_shortcode'];
			
			}


			echo json_encode($data);
	}else if($pageType=="subscription_attempt"){
	
	/*	$query = "SELECT subscription_group_name FROM tbl_cms_subscriptiongroup 
		  			  WHERE id IN 
		  			  (SELECT subscription_group_id FROM tbl_cms_subscriptiongroup_permission WHERE user_id='$UserID' AND is_active='active')  
		              AND is_active='active'";*/
			$qry="SELECT DISTINCT t1.subscription_group_name FROM tbl_cms_subscriptiongroup t1
				INNER JOIN tbl_cms_subscriptiongroup_permission t2 ON t1.id= t2.subscription_group_id WHERE t1.is_active='active' 
				AND t2.is_active='active' AND t2.user_id='$UserID'";
			$data=array();
			$res=Sql_exec($cn,$qry);
			while($dt = Sql_fetch_array($res))
			{
				$data[$dt['subscription_group_name']]=$dt['subscription_group_name'];
			
			}


			echo json_encode($data);
	}

ClosedDBConnection($cn);
?>