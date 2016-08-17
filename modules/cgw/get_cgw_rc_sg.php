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

	$qry = "select `SubscriptionGroupID`,`ParentID`,`CMSSeviceID`,`ServiceID`,`ServiceDuration`,`GracePeriod`,`AllowDowngrade`,`BNI`,`FreeServicePeriod`," .
			"`OriginalSubscriptionGroupID`,`RetryRenewalPeriod`,`RetryRenewalIntervalMinutes`,`RenewNotificationDays`,`RenewNotificationURL`," .
			"`has_balance_option`,`initial_balance`,`cpid`,`wallettype` from `subscriptiongroup`";
	if(isset($_POST['action_id'])){
		$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
		$qry .= " where  `SubscriptionGroupID`='$action_id'"; 
	}
	
    $res = Sql_exec($remoteCn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr[$count]['action_id'] = $dt['SubscriptionGroupID'];
		$v_arr[$count]['SubscriptionGroupID'] = $dt['SubscriptionGroupID'];
		$v_arr[$count]['ParentID'] = $dt['ParentID'];
		$v_arr[$count]['CMSSeviceID'] = $dt['CMSSeviceID'];
		$v_arr[$count]['ServiceID'] = $dt['ServiceID'];
		$v_arr[$count]['ServiceDuration'] = $dt['ServiceDuration'];
		$v_arr[$count]['GracePeriod'] = $dt['GracePeriod'];
		if( $dt['AllowDowngrade'] == NULL)
			$v_arr[$count]['AllowDowngrade'] = 'Null';
		else
			$v_arr[$count]['AllowDowngrade'] = $dt['AllowDowngrade'];
		$v_arr[$count]['BNI'] = $dt['BNI'];
		
		
		$v_arr[$count]['FreeServicePeriod'] = $dt['FreeServicePeriod'];
		if( $dt['OriginalSubscriptionGroupID'] == NULL)
			$v_arr[$count]['OriginalSubscriptionGroupID'] = 'Null';
		else
			$v_arr[$count]['OriginalSubscriptionGroupID'] = $dt['OriginalSubscriptionGroupID'];
		$v_arr[$count]['RetryRenewalPeriod'] = $dt['RetryRenewalPeriod'];
		$v_arr[$count]['RetryRenewalIntervalMinutes'] = $dt['RetryRenewalIntervalMinutes'];
		$v_arr[$count]['RenewNotificationDays'] = $dt['RenewNotificationDays'];
		$v_arr[$count]['RenewNotificationURL'] = $dt['RenewNotificationURL'];
		
		$v_arr[$count]['has_balance_option'] = $dt['has_balance_option'];
		$v_arr[$count]['initial_balance'] = $dt['initial_balance'];
		$v_arr[$count]['cp_id'] = $dt['cpid'];
		$v_arr[$count]['wallettype'] = $dt['wallettype'];
		
		$count++;
	}
	
ClosedDBConnection($remoteCn);
	echo json_encode($v_arr);
?>