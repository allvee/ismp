<?php
session_start();
require_once "../.././commonlib.php";

$ROLE_ID = $_SESSION['ROLE_ID'];
$CP_ID = $_SESSION['CP_ID'];
$UserID = $_SESSION['USER_ID'];

$dbt=$dbtype;
$ms=$MYSERVER;
$mdb=$MYDB;
$muid=$MYUID;
$mpass=$MYPASSWORD;
	
$cn = connectDB();
	
$operator_id=mysql_real_escape_string(htmlspecialchars($_REQUEST['operator_id']));
$service_id=mysql_real_escape_string(htmlspecialchars($_REQUEST['service_id']));
$frmdate=mysql_real_escape_string(htmlspecialchars($_REQUEST['from_id']))." 00:00:00";
$todate=mysql_real_escape_string(htmlspecialchars($_REQUEST['to_id']))." 23:59:59";
$trigger=mysql_real_escape_string(htmlspecialchars($_REQUEST['trigger']));
//$startDate = date( 'Y-m-d', strtotime($frmdate))." 00:00:00";
//$endDate = date( 'Y-m-d', strtotime($todate))." 23:59:59";
	

$And = "";
if($service_id == "All")
{
		$out="";
	
		/*$query = "SELECT DISTINCT t1.service_id FROM tbl_cms_subscriptiongroup t1
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
			$And = " AND `ServiceID` IN ($out)"; // ('2','5','7')
		}
		
		ClosedDBConnection($cn);
		
		$dbtype=$dbt;
		$MYSERVER=$ms;
		$MYUID=$muid;
		$MYPASSWORD=$mpass;
		$MYDB=$mdb;
		$cn=connectDB();
			
}else if(isset($service_id) && $service_id !=""){
		$And = " AND `ServiceID`='$service_id' ";
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
   //  echo $dbtype.":".$MYSERVER.":".$MYDB.":".$MYUID.":".$MYPASSWORD;

ClosedDBConnection($cn);
$remote_cn = connectDB();

$next_date_after_24 = date('Y-m-d', strtotime($endDate)+(24*60*60));
$next_date_after_24_start = $next_date_after_24 . " 00:00:00";
$next_date_after_24_end = $next_date_after_24 . " 23:59:59";
/*
SELECT 
     ServiceName, SUM(Hit) as Hit, sum(Mou) as Mou, sum(BrowsingMSC) as BrowsingMSC, 
     sum(BrowsingCGW) as BrowsingCGW, sum(Subscription) as Subscription, sum(Total) as Total, 
     sum(Revenue) as Revenue, date 
     FROM RevenueHistory 
     where date between '$frmdate' AND '$todate' $And 
     GROUP BY ServiceName, date
	 */

$query_report_rev_his="SELECT 
     `ServiceID`, SUM(`Amount`) as Amount, DATE(`EndTime`) as Reporting_date
     FROM cdr 
     where (`EndTime` between '$frmdate' AND '$todate') $And 
     GROUP BY ServiceID,DATE(`EndTime`)";




if($remote_cn)
{
	$res=Sql_exec($remote_cn,$query_report_rev_his);
	
	if($trigger=="yes"){
			$title=array('Date','ServiceID','Total');
			$data=array();
			if(Sql_Num_Rows($res)>0)
			{
						while($dt = Sql_fetch_array($res))
						{
								$one_row=array('Date'=>$dt['Reporting_date'],'ServiceID'=>$dt['ServiceID'],'Total'=>$dt['Amount']
								);
								
								array_push($data,$one_row);
								
						}
						
						if(!empty($data) && count($data)>0)
						{
							
							export_csv_file($title,$data,"REV_".strtotime('NOW').".csv");
							
						}
			} else{
			       echo 1;	
			}
	} else if($trigger=="no"){
		   
			if(Sql_Num_Rows($res)>0)
			{
				$result="<table cellspacing='0' style='height:auto;'><tbody><tr>
				<td>Date</td><td>ServiceID</td><td>Total</td></tr>";
				while($dt = Sql_fetch_array($res))
				{
						$result.="<tr><td>".
						$dt['Reporting_date'].
						"</td><td>".
						$dt['ServiceID'].
						"</td><td>".
						$dt['Amount'].
						"</td></tr>";
						
				}
				
				$result.="</tbody></table>";
				
				 
			} else{
				$result = '<span style="color:salmon">No Data Available</span>';
			}
		echo $result;
	}
	
}else{
	
 echo '<span style="color:salmon">No Data Available</span>';	
}



ClosedDBConnection($remote_cn);



?>