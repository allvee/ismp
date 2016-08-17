<?php
require_once "../.././commonlib.php";
session_start();
$v_arr = array();
$count = 0;
$user_id = $_SESSION['USER_ID'];
$cn = connectDB();
$remoteCnQry="select * from tbl_process_db_access where pname='CGW'";
$res = Sql_exec($cn,$remoteCnQry);
$dt = Sql_fetch_array($res);
//remote connection parameter set up
$dbtype=$dt['db_type'];
$MYSERVER=$dt['db_server'];
$MYUID=$dt['db_uid'];
$MYPASSWORD=$dt['db_password'];
$MYDB=$dt['db_name'];
ClosedDBConnection($cn);// close current connection
// open remote connection
$remoteCn=connectDB();



$rate_id_str;
$qry = "SELECT `UniqueID`,`ServiceID`,`PackageID`,`ChargingType`,`ActivationStart`,`ActivationEnd`,`Priority`,`CallTypeID`, " .
		"`TimeSlotID`,`SubscriptionGroupID`,`SubscriptionStatus`,`RateID`,`cpid` from `ratemaster`";
if(isset($_POST['action_id'])){
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$qry .= " where `UniqueID`='$action_id'"; 
}
	
    $res = Sql_exec($remoteCn,$qry);
	while($dt = Sql_fetch_array($res)){
		// $v_arr[$count]['RateName'] = $dt['RateName'];
		$v_arr[$count]['ServiceID'] = $dt['ServiceID'];
		$v_arr[$count]['PackageID'] = $dt['PackageID'];
		$v_arr[$count]['ChargingType'] = $dt['ChargingType'];
		
		$v_arr[$count]['ActivationStart'] = $dt['ActivationStart'];
		$v_arr[$count]['ActivationEnd'] = $dt['ActivationEnd'];
		$v_arr[$count]['Priority'] = $dt['Priority'];
		
		$v_arr[$count]['CallTypeID'] = $dt['CallTypeID'];
		$v_arr[$count]['TimeSlotID'] = $dt['TimeSlotID'];
		// $v_arr[$count]['accumulatorid'] = $dt['accumulatorid'];
		
		if( $dt['SubscriptionGroupID'] == NULL)
			$v_arr[$count]['SubscriptionGroupID'] = 'Null';
		else
			$v_arr[$count]['SubscriptionGroupID'] = $dt['SubscriptionGroupID'];
		
		if( $dt['SubscriptionStatus'] == NULL)
			$v_arr[$count]['SubscriptionStatus'] = 'Null';
		else
			$v_arr[$count]['SubscriptionStatus'] = $dt['SubscriptionStatus'];
			
		$v_arr[$count]['RateID'] = $dt['RateID'];
		$v_arr[$count]['cp_id'] = $dt['cpid'];
		$rate_id_str = $dt['RateID'];

		$count++;
	}
	
if($cn)ClosedDBConnection($cn);
if($remoteCn)ClosedDBConnection($remoteCn);
//	$count_qry = "select count(UniqueID) AS `Count` from `ratepulse` where `rateid`='$rate_id_str'";
//	$cn = connectDB();
//    $res = Sql_exec($cn,$count_qry);
//    while($dt = Sql_fetch_array($res)){
//		$Count = $dt['Count'];
//	}	
//    ClosedDBConnection($cn);
//	$qry2 = "SELECT `rateid`,`stepno`,`stepduration`,`steppulse`,`steppulserate`,`serviceunit` from `ratepulse` where ";
//	$qry2 .= " `rateid`='$rate_id_str'"; 		
//	$cn = connectDB();
//    $res = Sql_exec($cn,$qry2);
//    $i=0;	
//    while($dt = Sql_fetch_array($res)){
//		$v_arr[$count]['stepNumber_1'] = $dt['stepno'];
//		$v_arr[$count]['stepduration_1'] = $dt['stepduration'];
//		$v_arr[$count]['steppulse_1'] = $dt['steppulse'];
//		$v_arr[$count]['steppulserate_1'] = $dt['steppulserate'];
//		$v_arr[$count]['serviceunit_1'] = $dt['serviceunit'];
//		
//		$count++;
//		$i++;
//	}
//    ClosedDBConnection($cn);
    
	echo json_encode($v_arr);
	//echo $res;
	// echo $qry2;
?>