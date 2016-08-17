<?php
session_start();
require_once "../.././commonlib.php";
$cn = connectDB();

$operator_id=mysql_real_escape_string(htmlspecialchars($_REQUEST['operator_id']));
$service_id=mysql_real_escape_string(htmlspecialchars($_REQUEST['service_id']));
$frmdate=mysql_real_escape_string(htmlspecialchars($_REQUEST['from_id']))." 00:00:00";
$todate=mysql_real_escape_string(htmlspecialchars($_REQUEST['to_id']))." 23:59:59";
$UserID=mysql_real_escape_string(htmlspecialchars($_SESSION['USER_ID']));
$trigger=mysql_real_escape_string(htmlspecialchars($_REQUEST['trigger']));
//$startDate = date( 'Y-m-d', strtotime($frmdate))." 00:00:00";
//$endDate = date( 'Y-m-d', strtotime($todate))." 23:59:59";
	

$And = "";
if($service_id == "All")
{
		 $out="";
		 $qry="SELECT DISTINCT t1.nodelog_shortcode FROM tbl_cms_subscriptiongroup t1
				INNER JOIN tbl_cms_subscriptiongroup_permission t2 ON t1.id= t2.subscription_group_id WHERE t1.is_active='active' 
				AND t2.is_active='active' AND t2.user_id='$UserID'";
		/*$query = "SELECT distinct nodelog_shortcode FROM tbl_cms_subscriptiongroup
		WHERE id IN (SELECT subscription_group_id FROM tbl_cms_subscriptiongroup_permission  WHERE user_id='$UserID'
		 
		AND is_active='active') AND is_active='active'";*/
		
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
			
			
if($trigger=="yes")
{
	$title=array('NodeName','Hit','MoU','Service');
	$data=array();
	if(Sql_Num_Rows($res)>0)
	{
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
	}else{
		
		echo 1;
	}
}else if($trigger=="no"){

	if(Sql_Num_Rows($res)>0){
		
			$result="<table cellspacing='0' style='height:auto;'><tbody><tr><td>NodeName</td>
			<td>Hit</td><td>Mou</td><td>Service</td></tr>";
			while($dt = Sql_fetch_array($res))
			{
				$result.="<tr><td>".$dt['NodeName']."</td><td>".$dt['Hit'].
				"</td><td>".$dt['MoU']."</td><td>".$dt['Service']."</td></tr>";
			
			}
			
			$result.="</tbody></table>";
			echo $result;
	}else{
		
		  echo 1;	
	}
}




ClosedDBConnection($remote_cn);

$dbtype=$dbt;
$MYSERVER=$ms;
$MYDB=$mdb;
$MYUID=$muid;
$MYPASSWORD=$mpass;


?>