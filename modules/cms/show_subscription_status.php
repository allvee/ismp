<?php
session_start();
require_once "../.././commonlib.php";

$ROLE_ID = $_SESSION['ROLE_ID'];
$CP_ID = $_SESSION['CP_ID'];
$UserID = $_SESSION['USER_ID'];

$cn = connectDB();

$operator_id=mysql_real_escape_string(htmlspecialchars($_REQUEST['operator_id']));
$service_id=mysql_real_escape_string(htmlspecialchars($_REQUEST['service_id']));
$frmdate=mysql_real_escape_string(htmlspecialchars($_REQUEST['from_id']));
$todate=mysql_real_escape_string(htmlspecialchars($_REQUEST['to_id']));
$trigger=mysql_real_escape_string(htmlspecialchars($_REQUEST['trigger']));
$startDate = date( 'Y-m-d', strtotime($frmdate))." 00:00:00";
$endDate = date( 'Y-m-d', strtotime($todate))." 23:59:59";

$dbt=$dbtype;
$ms=$MYSERVER;
$mdb=$MYDB;
$muid=$MYUID;
$mpass=$MYPASSWORD;
	

$And = "";
if($service_id == "All")
{
		$out="";
		/*$qry="SELECT DISTINCT t1.subscription_group_name FROM tbl_cms_subscriptiongroup t1
				INNER JOIN tbl_cms_subscriptiongroup_permission t2 ON t1.id= t2.subscription_group_id WHERE t1.is_active='active' 
				AND t2.is_active='active' AND t2.user_id='$UserID'";*/
		/*$query = "SELECT distinct subscription_group_name FROM tbl_cms_subscriptiongroup
		WHERE id IN (SELECT subscription_group_id FROM tbl_cms_subscriptiongroup_permission  WHERE user_id='$UserID'
		 
		AND is_active='active') AND is_active='active'";*/
		
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
		
		
		$query = "SELECT DISTINCT `ServiceID` FROM `subscriptiongroup`";
		if($ROLE_ID != "1") $qry .= " where `cpid`='$CP_ID'";
		
		
		$res=Sql_exec($cn,$query);
		while($dt = Sql_fetch_array($res))
		{
			if($out != "") $out .= ",";
			$out .= "'".$dt['ServiceID']."'";
		}
		
		if($out != "")
		{
			$And = " AND `SubscriptionGroupID` IN ($out)"; // ('2','5','7')
		}
		
		ClosedDBConnection($cn);
		
		$dbtype=$dbt;
		$MYSERVER=$ms;
		$MYUID=$muid;
		$MYPASSWORD=$mpass;
		$MYDB=$mdb;
		$cn=connectDB();
}else if(isset($service_id) && $service_id!=""){
		$And = " AND SubscriptionGroupID='$service_id' ";
}else{
	   
}


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
	
	if($trigger=="no")
	{
			if(Sql_Num_Rows($res)>0){
						$result="<table id='sub_status' cellspacing='0' style='height:auto;'><tbody><tr><td>Service</td><td>Total_due_now</td>
						<td>Total_due_next_24_hr</td><td>Total_registration</td>
						<td>Total_deregistration</td><td>Subbase</td></tr>";
						while($dt = Sql_fetch_array($res))
						{
								$result.="<tr><td>".
								$dt['Service'].
								"</td><td>".
								$dt['Total_due_now'].
								"</td><td>".
								$dt['Total_due_next_24_hr'].
								"</td><td>
								".$dt['Total_registration'].
								"</td><td>".$dt['Total_deregistration']."</td><td>".$dt['Subbase']."</td></tr>";
								
						}
						
						$result.="</tbody></table>";
						echo $result;
			}else{
				
				  echo 1;	
			}
	}else if($trigger=="yes"){
		
		     if(Sql_Num_Rows($res)>0){
		  
			
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
				 
			    echo 1;	 
				 
			 }
	}


} else{
	
 echo 1;	
}



ClosedDBConnection($remote_cn);

$dbtype=$dbt;
$MYSERVER=$ms;
$MYDB=$mdb;
$MYUID=$muid;
$MYPASSWORD=$mpass;


?>

