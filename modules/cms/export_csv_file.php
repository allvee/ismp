<?php
session_start();
require_once "../.././commonlib.php";


$cn = connectDB();

$operator_id=mysql_real_escape_string(htmlspecialchars($_REQUEST['operator_id']));
$service_id=mysql_real_escape_string(htmlspecialchars($_REQUEST['service_id']));
$frmdate=mysql_real_escape_string(htmlspecialchars($_REQUEST['from_id']));
$todate=mysql_real_escape_string(htmlspecialchars($_REQUEST['to_id']));
$UserID=mysql_real_escape_string(htmlspecialchars($_SESSION['USER_ID']));
$startDate = date( 'Y-m-d', strtotime($frmdate))." 00:00:00";
$endDate = date( 'Y-m-d', strtotime($todate))." 23:59:59";
$page_type=mysql_real_escape_string(htmlspecialchars($_REQUEST['page_type']));
$page_type=mysql_real_escape_string(htmlspecialchars($_REQUEST['page_type']));
 

if($page_type=="subscription_status")
{
	
	
		$And = "";
		if($service_id == "All")
		{
				$out="";
				$qry="SELECT DISTINCT t1.subscription_group_name FROM tbl_cms_subscriptiongroup t1
						INNER JOIN tbl_cms_subscriptiongroup_permission t2 ON t1.id= t2.subscription_group_id WHERE t1.is_active='active' 
						AND t2.is_active='active' AND t2.user_id='$UserID'";
				
				
				$res=Sql_exec($cn,$qry);
				while($dt = Sql_fetch_array($res))
				{
					if($out != "") $out .= ",";
					$out .= "'".$dt['subscription_group_name']."'";
				}
				
				if($out != "")
				{
					$And = " AND SubscriptionGroupID IN ($out)"; // ('2','5','7')
				}
		}else if(isset($service_id) && $service_id!=""){
				$And = " AND SubscriptionGroupID='$service_id' ";
		}else{
			   
		}


		$dbt=$dbtype;
		$ms=$MYSERVER;
		$mdb=$MYDB;
		$muid=$MYUID;
		$mpass=$MYPASSWORD;
	
		$qry_server = "SELECT source_name, db_type, db_server, db_user_name, db_password, db_name 
		FROM tbl_cms_requestsource_dwh WHERE dwh_request_source_id='$operator_id' limit 1";
		$res=Sql_exec($cn,$qry_server);
		$dt= Sql_fetch_array($res);


		$dbtype=$dt['db_type'];
		$MYSERVER=$dt['db_server'];
		$MYDB=$dt['db_name'];
		$MYUID=$dt['db_user_name'];
		$MYPASSWORD=$dt['db_password'];

		ClosedDBConnection($cn);
		$remote_cn = connectDB();

		$next_date_after_24 = date('Y-m-d', strtotime($endDate)+(24*60*60));
		$next_date_after_24_start = $next_date_after_24 . " 00:00:00";
		$next_date_after_24_end = $next_date_after_24 . " 23:59:59";


		$qry_report = "select SubscriptionGroupID as Service,
		sum(case when ChargingDueDate< '$endDate' and Status <> 'Deregistered' then 1 else 0 end) as Total_due_now,
		sum(case when status <> 'Deregistered' and ChargingDueDate between '$next_date_after_24_start' AND '$next_date_after_24_end'  then 1 else 0 end) 
		as Total_due_next_24_hr,
		sum(case when RegistrationDate between '$startDate' AND '$endDate' then 1 else 0 end) as Total_registration,
		sum(case when DeregistrationDate between '$startDate' and '$endDate' then 1 else 0 end) as Total_deregistration,
		sum(case when RegistrationDate< '$endDate' and status<>'Deregistered' then 1 else 0  end) as Subbase
		from subscriberservices
		where SubscriptionGroupID is not null  
								 $And 
								 group by SubscriptionGroupID";


		if($remote_cn)
		{
			$res=Sql_exec($remote_cn,$qry_report);
			
			$title=array('Service','Total_due_now','Total_due_next_24_hr','Total_registration','Total_deregistration','Subbase');
			$data=array();
			while($dt = Sql_fetch_array($res))
			{
				$one_row=array("Service"=>$dt['Service'],"Total_due_now"=>$dt['Total_due_now'],"Total_due_next_24_hr"=>$dt['Total_due_next_24_hr'],
				"Total_registration"=>$dt['Total_registration'],"Total_deregistration"=>$dt['Total_deregistration'],"Subbase"=>$dt['Subbase']);
				
				array_push($data,$one_row);
			}
			
		 
			if(!empty($data) && count($data)>0)
			{
				
				
				export_csv_file($title,$data,"data_file.csv");
				
		
			}else{
				
				print "<script>
								alert ('Sorry, no data found to be processed. ');
								window.close();
					</script>";
		
			}
			
		}else{
			
		 echo "Connection error: "+$remote_cn;	
		}



		ClosedDBConnection($remote_cn);

		$dbtype=$dbt;
		$MYSERVER=$ms;
		$MYDB=$mdb;
		$MYUID=$muid;
		$MYPASSWORD=$mpass;
	
	
	
}else if($page_type=="revenue_report"){
	
	
$And = "";
if($service_id == "All")
{
		$out="";
	
		$query = "SELECT DISTINCT t1.service_id FROM tbl_cms_subscriptiongroup t1
		INNER JOIN tbl_cms_subscriptiongroup_permission t2 ON t1.id= t2.subscription_group_id WHERE t1.is_active='active' 
		AND t2.is_active='active' AND t2.user_id='$UserID'";
		
		$res=Sql_exec($cn,$query);
		while($dt = Sql_fetch_array($res))
		{
			if($out != "") $out .= ",";
			$out .= "'".$dt['service_id']."'";
		}
		
		if($out != "")
		{
			$And = " AND ServiceName IN ($out)"; // ('2','5','7')
		}
}else if(isset($service_id) && $service_id!=""){
		$And = " AND ServiceName='$service_id' ";
}else{
	   
}


	$dbt=$dbtype;
	$ms=$MYSERVER;
	$mdb=$MYDB;
	$muid=$MYUID;
	$mpass=$MYPASSWORD;
	
	$qry_server = "SELECT source_name, db_type, db_server, db_user_name, db_password, db_name 
	FROM tbl_cms_requestsource_dwh WHERE dwh_request_source_id='$operator_id' limit 1";
	$res=Sql_exec($cn,$qry_server);
	$dt= Sql_fetch_array($res);


	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYDB=$dt['db_name'];
	$MYUID=$dt['db_user_name'];
	$MYPASSWORD=$dt['db_password'];
   //  echo $dbtype.":".$MYSERVER.":".$MYDB.":".$MYUID.":".$MYPASSWORD;
ClosedDBConnection($cn);
$remote_cn = connectDB();

$next_date_after_24 = date('Y-m-d', strtotime($endDate)+(24*60*60));
$next_date_after_24_start = $next_date_after_24 . " 00:00:00";
$next_date_after_24_end = $next_date_after_24 . " 23:59:59";


$query_report_rev_his="SELECT 
     ServiceName, SUM(Hit) as Hit, sum(Mou) as Mou, sum(BrowsingMSC) as BrowsingMSC, 
     sum(BrowsingCGW) as BrowsingCGW, sum(Subscription) as Subscription, sum(Total) as Total, 
     sum(Revenue) as Revenue, Date 
     FROM RevenueHistory 
     where date between '$frmdate' AND '$todate' $And 
     GROUP BY ServiceName, Date";




if($remote_cn)
{
	$res=Sql_exec($remote_cn,$query_report_rev_his);
	$result="<table cellspacing='0' style='height:auto;'><tbody><tr><td>ServiceName</td><td>Hit</td><td>Mou</td><td>BrowsingMSC</td>
	<td>BrowsingCGW</td><td>Subscription</td><td>Total</td><td>Revenue</td><td>Date</td></tr>";
    $title=array('ServiceName','Hit','Mou','BrowsingMSC','BrowsingCGW','Subscription','Total','Revenue','Date');
	$data=array();
	while($dt = Sql_fetch_array($res))
	{
			$one_row=array('ServiceName'=>$dt['ServiceName'],'Hit'=>$dt['Hit'],'Mou'=>$dt['Mou'],
			'BrowsingMSC'=>$dt['BrowsingMSC'],'BrowsingCGW'=>$dt['BrowsingCGW'],'Subscription'=>$dt['Subscription'],
			'Total'=>$dt['Total'],'Revenue'=>$dt['Revenue'],'Date'=>$dt['Date']
			);
			
			array_push($data,$one_row);
			
	}
    
	if(!empty($data) && count($data)>0)
	{
		
		export_csv_file($title,$data,"data_file.csv");
		
	}


}else{
	
 echo "Connection error: "+$remote_cn;	
}



ClosedDBConnection($remote_cn);

$dbtype=$dbt;
$MYSERVER=$ms;
$MYDB=$mdb;
$MYUID=$muid;
$MYPASSWORD=$mpass;
	
}else if($page_type=="node_log_report")
{
	
	$And = "";
	if($service_id == "All")
	{
			$out="";
			$qry="SELECT DISTINCT t1.nodelog_shortcode FROM tbl_cms_subscriptiongroup t1
					INNER JOIN tbl_cms_subscriptiongroup_permission t2 ON t1.id= t2.subscription_group_id WHERE t1.is_active='active' 
					AND t2.is_active='active' AND t2.user_id='$UserID'";
		
			
			$res=Sql_exec($cn,$qry);
			while($dt = Sql_fetch_array($res))
			{
				if($out != "") $out .= ",";
				$out .= "'".$dt['nodelog_shortcode']."'";
			}
			
			if($out != "")
			{
				$And = " AND Service IN ($out)"; // ('2','5','7')
			}
	}else if(isset($service_id) && $service_id!=""){
			$And = " AND Service='$service_id' ";
	}else{
		   
	}


	$dbt=$dbtype;
	$ms=$MYSERVER;
	$mdb=$MYDB;
	$muid=$MYUID;
	$mpass=$MYPASSWORD;
	
	$qry_server = "SELECT source_name, db_type, db_server, db_user_name, db_password, db_name 
	FROM tbl_cms_requestsource_dwh WHERE dwh_request_source_id='$operator_id' limit 1";
	$res=Sql_exec($cn,$qry_server);
	$dt= Sql_fetch_array($res);


	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYDB=$dt['db_name'];
	$MYUID=$dt['db_user_name'];
	$MYPASSWORD=$dt['db_password'];
    // echo $dbtype.":".$MYSERVER.":".$MYDB.":".$MYUID.":".$MYPASSWORD;
ClosedDBConnection($cn);
$remote_cn = connectDB();




$query_nodelog_report="select NodeName, sum(Hit) as Hit, sum(MoU) as MoU, Service from 
						BnoWiseNodeLogReport where Date > '$frmdate' and Date <= '$todate' $And group by NodeName,Service";																						







	$res=Sql_exec($remote_cn,$query_nodelog_report);
	
    $title=array('NodeName','Hit','MoU','Service');
	$data=array();
	while($dt = Sql_fetch_array($res))
	{
		$one_row=array(
		   'NodeName'=>$dt['NodeName'],
		    'Hit'=>$dt['Hit'],
			 'MoU'=>$dt['MoU'],
			  'Service'=>$dt['Service']
		
		);
		
		array_push($data,$one_row);
			
	}
    
	if(!empty($data) && count($data)>0)
	{
		
		export_csv_file($title,$data,"data_file.csv");
	}





ClosedDBConnection($remote_cn);

$dbtype=$dbt;
$MYSERVER=$ms;
$MYDB=$mdb;
$MYUID=$muid;
$MYPASSWORD=$mpass;

}




?>