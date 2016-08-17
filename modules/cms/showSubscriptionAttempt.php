<?php
session_start();
require_once "../.././commonlib.php";



//putenv("ODBCINI=/etc/odbc.ini");
//putenv("ODBCINST=/etc/odbcinst.ini");

$u="sa";
$p="Nopass123";
$s="192.168.241.105";
$db="ISMP_DWH";
//echo $u;

//$dsn="{SQL Server}";
$dsn = "Driver={SQL Server};Server=192.168.241.105;Port=1433;Database=ISMP_DWH";
$cx = odbc_connect("$dsn","$u","$p");
// Get the error message
/*
$dbtype="odbc";
$MYSERVER="192.168.241.105";
$MYUID="sa";
$MYPASSWORD="Nopass123";
$MYDB="ISMP_DWH";
*/
$dbtype="odbc";
$MYSERVER="192.168.241.105";
$MYUID="sa";
$MYPASSWORD="Nopass123";
$MYDB="ISMP_DWH";
//$cx=connectDB();
if($cx == false) {
      echo "Connection Error: ".odbc_errormsg();
}else{
	  echo "Connection Established: ".$cx;
         $qry="select * from ServiceWiseURL";
         $rs=odbc_exec($cx ,$qry);
         $dt=odbc_fetch_array($rs);
         echo json_encode($dt);
}   



exit;













$operator_id=$_REQUEST['operator_id'];
$service_id=$_REQUEST['service_id'];
$frmdate=$_REQUEST['from_id'];
$todate=$_REQUEST['to_id'];
$UserID=$_SESSION['USER_ID'];
$frmdate = date( 'Y-m-d', strtotime($frmdate))." 00:00:00";
$todate = date( 'Y-m-d', strtotime($todate))." 23:59:59";












$dbtype="mysql";
$MYSERVER="localhost";
$MYUID="root";
$MYPASSWORD="nopass";
$MYDB="ismp";
$cn = connectDB();

$And = "";
	if($service_id == "All")
	{
		$out=array();
		$SubscriptionGroupID = '';
	/*	$qry="SELECT DISTINCT t1.subscription_group_name FROM tbl_cms_subscriptiongroup t1
				INNER JOIN tbl_cms_subscriptiongroup_permission t2 ON t1.id= t2.subscription_group_id WHERE t1.is_active='active' 
				AND t2.is_active='active' AND t2.user_id='$UserID'";
	*/
		$query = "SELECT DISTINCT subscription_group_id FROM tbl_cms_subscriptiongroup
		WHERE id IN (SELECT subscription_group_id FROM tbl_cms_subscriptiongroup_permission  WHERE user_id='$UserID')";
		$qry="SELECT DISTINCT t1.subscription_group_name FROM tbl_cms_subscriptiongroup t1
				INNER JOIN tbl_cms_subscriptiongroup_permission t2 ON t1.id= t2.subscription_group_id 
				WHERE t1.is_active='active' 
				AND t2.is_active='active' AND t2.user_id='$UserID'";
		
        $res=Sql_exec($cn,$qry);
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
	}else{}
	
$qry_server = "SELECT source_name, db_type, db_server, db_user_name, db_password, db_name FROM tbl_cms_requestsource_dwh WHERE dwh_request_source_id='$operator_id' limit 1";
$res=Sql_exec($cn,$qry_server);
$dt= Sql_fetch_array($res);
ClosedDBConnection($cn);





$dbt=$dbtype;
$server=$MYSERVER;
$myid=$MYUID;
$mypassword=$MYPASSWORD;
$mydb=$MYDB;

$dba=array();	
$dba['dbtype']=$dbtype=$dt['db_type'];
$dba['db_server']=$MYSERVER=$dt['db_server'];
$dba['db_user_name']=$MYUID=$dt['db_user_name'];
$dba['db_password']=$MYPASSWORD=$dt['db_password'];
$dba['db_name']=$MYDB=$dt['db_name'];
$cn = connectDB();
//echo json_encode($dba);
/*
$next_date_after_24 = date('Y-m-d', strtotime($enddate)+(24*60*60));
$next_date_after_24_start = $next_date_after_24 . " 00:00:00";
$next_date_after_24_end = $next_date_after_24 . " 23:59:59";

// run query for Subscription Attempt
$qry_report =   "SELECT serviceid as Service, sum(1) as Total_attempt, 
					sum(case when resultcode = 2001 then 1 else 0 end) as Successful_attempt, 
					sum(case when resultcode <> 2001 then 1 else 0 end) as Failed_renewal 
					FROM $From_DB_Name 
					WHERE direction = 0 and chargingtype = 'specific_charge' and 
					lastupdate between '$frmdate' AND '$todate'	$And  
					GROUP BY serviceid"; */






$query="select dwh_request_source_id, 
	source_name, 
	description, 
	reporting_type, 
	operator, 
	db_type, 
	db_server from tbl_cms_requestsource_dwh";
if($cn)
{
	$res=Sql_exec($cn,$query);
	$result="<table><tr><td>source_name</td><td>description</td><td>reporting_type</td><td>operator</td><td>db_type</td><td>db_server</td></tr>";
while($dt = Sql_fetch_array($res))
{
	    $result.="<tr><td>".
		$dt['source_name'].
		"</td><td>".
		$dt['description'].
		"</td><td>".
		$dt['reporting_type'].
		"</td><td>
		".$dt['operator'].
		"</td><td>".$dt['db_type']."</td><td>".$dt['db_server']."</td></tr>";
		
}
$result.="</table>";
echo $result;
}else{
	echo "error";
	
}




ClosedDBConnection($cn);

$dbtype=$dbt;
$MYSERVER=$server;
$MYUID=$myid;
$MYPASSWORD=$mypassword;
$MYDB=$mydb;	



?>